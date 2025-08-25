<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SubController extends BaseCommand
{
    protected $group       = 'Generators';
    protected $name        = 'make:sub-controller';
    protected $description = 'Generates a new standard iATAP controller.';

    public function run(array $params)
    {
        $path = array_shift($params);
        
        if(!$path)
        {
            CLI::prompt('Enter directory path for Controller'); 
        }

        $controllerPath = explode('/', $path); 

        //Get class name or use the default of Index
        $className = CLI::prompt('Class Name', 'Index'); 

        // Get the site name and page title
        $siteName = CLI::prompt('Site name', 'iATAP');
        $pageTitle = CLI::prompt('Page title', $controllerPath[array_key_last($controllerPath)]);

        $breadcrumbs = [ "['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ]" ]; //Default first segment of breadcrumbs
        
        $baseUrlSegments = []; 

        $fullPath = explode('/', $path);
        $lastIndex = count($fullPath) -1;

        foreach($fullPath as $index => $item) {
            $itemName = ucfirst($item);
            $baseUrlSegments[] = strtolower($itemName); 
            
            if(strtolower($item) != 'index') {
                if($index === $lastIndex) {
                    // Last item is active
                    $breadcrumbs[] = "['name' => '$itemName', 'is_active' => true, 'url' => '#']";
                } else {
                    $url = implode('/', $baseUrlSegments);
                    $breadcrumbs[] = "['name' => '$itemName', 'is_active' => false, 'url' => '$url']";
                }
            }
        }

        $breadcrumb = implode(",\n\t\t\t\t", $breadcrumbs); 

        // Read the template file as raw text
        $templatePath = APPPATH . 'Commands/Generators/Views/sub_controller.tpl.php';
        $viewPath = APPPATH.'Views/'.implode('/', $baseUrlSegments); 

        $template = file_get_contents($templatePath);
         
        // Replace placeholders
        $replacements = [
            '<@php' => '<?php', 
            '{namespace}' => 'App\\Controllers\\'.implode('\\', $controllerPath),
            '{useStatement}' => 'App\\Controllers\\BaseController',
            '{class}' => $className,
            '{extends}' => 'BaseController',
            '{siteName}' => $siteName,
            '{breadCrumbs}' => $breadcrumb,
            '{pageTitle}' => $pageTitle,
            '{viewPath}' => implode('/', $baseUrlSegments ) . '/index',
            '{jsPath}' => implode('/', $baseUrlSegments ). '/index.js.php',
        ];
        
        $processedTemplate = str_replace(array_keys($replacements), array_values($replacements), $template);
        
        $templateDirectory = APPPATH . 'Controllers/'.$path; 

        $success = $this->createTemplates( $path, $processedTemplate, $className);
        
        // Add route generation prompt after successful controller creation
        // if ($success) {
        //     $this->promptForRoutes($controllerPath, $className, $baseUrlSegments);
        // }
    }

    /**
     * Prompt user to generate routes for the controller
     */
    private function promptForRoutes(array $controllerPath, string $className, array $baseUrlSegments): void
    {
        $generateRoutes = CLI::prompt('Do you want to generate routes for this controller?', ['y', 'n'], 'required');
        
        if (strtolower($generateRoutes) === 'y') {
            // Build the full controller class name
            $fullControllerClass = implode('\\', $controllerPath) . '\\' . $className;
            $routePath = implode('/', $baseUrlSegments);
            
            // Check if route already exists
            if ($this->routeExists($fullControllerClass, $routePath)) {
                CLI::write("Route for {$fullControllerClass} already exists in Routes.php", 'yellow');
                $overwrite = CLI::prompt('Do you want to replace the existing route?', ['y', 'n'], 'required');
                
                if (strtolower($overwrite) !== 'y') {
                    CLI::write("Skipping route generation.", 'blue');
                    return;
                }
            }
            
            // Ask if it's a main controller that needs session protection
            $isMainController = CLI::prompt('Is this a main controller that requires session authentication?', ['y', 'n'], 'required');
            
            if (strtolower($isMainController) === 'y') {
                $this->addSessionProtectedRoute($fullControllerClass, $routePath);
            } else {
                $this->addPublicRoute($fullControllerClass, $routePath);
            }
        }
    }

    /**
     * Check if route already exists for this controller
     */
    private function routeExists(string $controllerClass, string $routePath): bool
    {
        $routesFile = APPPATH . 'Config/Routes.php';
        $routesContent = file_get_contents($routesFile);
        
        // Check for controller class name in routes
        if (strpos($routesContent, $controllerClass) !== false) {
            return true;
        }
        
        // Check for route path in group definitions
        if (strpos($routesContent, "'{$routePath}'") !== false) {
            return true;
        }
        
        return false;
    }
    /**
     * Add route to session protected section
     */
    private function addSessionProtectedRoute(string $controllerClass, string $routePath): void
    {
        $routesFile = APPPATH . 'Config/Routes.php';
        $routesContent = file_get_contents($routesFile);

        // Find the session protected routes section and add before Error Routes
        $sessionPattern = '/(\$routes->group\(\'\', \[\'filter\' => \'session\'\], static function\(\$routes\) \{.*?)(    \/\/ Error Routes)/s';
        
        $newRoute = <<<ROUTE

            // {$controllerClass} Routes
            \$routes->group('{$routePath}', static function(\$routes) {
                \$routes->get('/', '{$controllerClass}::index');
            });
        ROUTE;

        if (preg_match($sessionPattern, $routesContent)) {
            $updatedContent = preg_replace($sessionPattern, '$1' . $newRoute . "\n\n$2", $routesContent);
            
            if (file_put_contents($routesFile, $updatedContent)) {
                CLI::write("Route added to session protected section: /{$routePath}", 'green');
            } else {
                CLI::error("Failed to write routes to file.");
                $this->showManualRouteInstructions($controllerClass, $routePath, true);
            }
        } else {
            CLI::error("Could not find session protected routes section in Routes.php");
            $this->showManualRouteInstructions($controllerClass, $routePath, true);
        }
    }

    /**
     * Add route to public section
     */
    private function addPublicRoute(string $controllerClass, string $routePath): void
    {
        $routesFile = APPPATH . 'Config/Routes.php';
        $routesContent = file_get_contents($routesFile);

        // Find the public routes section (before authentication routes)
        $publicPattern = '/(\/\/ =============================================================================\n\/\/ AUTHENTICATION ROUTES\n\/\/ =============================================================================)/';
        
        $newRoute = <<<ROUTE

        // {$controllerClass} Routes
        \$routes->group('{$routePath}', static function(\$routes) {
            \$routes->get('/', '{$controllerClass}::index');
        });

        ROUTE;

        if (preg_match($publicPattern, $routesContent)) {
            $updatedContent = preg_replace($publicPattern, $newRoute . '$1', $routesContent);
            
            if (file_put_contents($routesFile, $updatedContent)) {
                CLI::write("Route added to public section: /{$routePath}", 'green');
            } else {
                CLI::error("Failed to write routes to file.");
                $this->showManualRouteInstructions($controllerClass, $routePath, false);
            }
        } else {
            CLI::error("Could not find public routes section in Routes.php");
            $this->showManualRouteInstructions($controllerClass, $routePath, false);
        }
    }

    /**
     * Show manual route instructions if automatic placement fails
     */
    private function showManualRouteInstructions(string $controllerClass, string $routePath, bool $isSessionProtected): void
    {
        CLI::write("\nPlease manually add the following route to your Routes.php file:", 'yellow');
        
        if ($isSessionProtected) {
            CLI::write("\nAdd inside the session protected routes section:");
            $route = <<<ROUTE

            // {$controllerClass} Routes
            \$routes->group('{$routePath}', static function(\$routes) {
                \$routes->get('/', '{$controllerClass}::index');
            });
        ROUTE;
                } else {
                    CLI::write("\nAdd to the public routes section:");
                    $route = <<<ROUTE

        // {$controllerClass} Routes
        \$routes->group('{$routePath}', static function(\$routes) {
            \$routes->get('/', '{$controllerClass}::index');
        });
        ROUTE;
        }
        
        CLI::write($route, 'cyan');
    }

    /**
     * Build the Templates 
     */
    private function createTemplates($path, $template, $className):bool
    {
        $directories = [
            'controller' => APPPATH . 'Controllers/' . $path ,
            'view'  => APPPATH . 'Views/'. strtolower($path),
        ];

        $files = [
            'controller' => $className.'.php', 
            'view'       => 'index.php', 
            'javascript' => 'index.js.php', 
        ];

        foreach($directories as $directory )
        {
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0755, true)) {
                    CLI::error('Failed to create directory: ' . $directory);
                    return false; 
                }else{
                    CLI::write('Created Directory: ' . CLI::color($directory, 'green'));
                }
            }
        }

        foreach($files as $key => $file)
        {

            if($key === 'controller' ){

                $target = $directories['controller'] . '/' . $file;

                if (! $this->overwrite($target) ) {
                    return false;
                }

                if(!write_file($target , $template )){
                    CLI::error('Failed to create directory: ' . $file);
                    return false; 
                }else{
                    CLI::write('Created File: ' . CLI::color($file, 'green'));
                }
            }elseif( $key == 'view' ){

                $target = $directories['view'] . '/' . $file;

                if (! $this->overwrite($target) ) {
                    return false;
                }
                $templatePath = APPPATH . 'Commands/Generators/Views/sub_index.tpl.php';
                $template = file_get_contents($templatePath);
                if(!write_file( $target, $template )){
                    CLI::error('Failed to create directory: ' . $file);
                    return false; 
                }else{
                    CLI::write('Created File: ' . CLI::color($file, 'green'));
                }

            }elseif( $key == 'javascript' ){

                $target = $directories['view'] . '/' . $file;

                if (! $this->overwrite($target) ) {
                    return false;
                }
                $templatePath = APPPATH . 'Commands/Generators/Views/sub_index.tpl.js.php';
                $template = file_get_contents($templatePath);
                if(!write_file( $target, $template )){
                    CLI::error('Failed to create directory: ' . $file);
                    return false; 
                }else{
                    CLI::write('Created File: ' . CLI::color($file, 'green'));
                }

            }
        }

        return true; 
    }
    /**
     * Check if we should overwrite existing file
     */
    private function overwrite(string $path): bool
    {
        if (! file_exists($path)) {
            return true;
        }

        return CLI::prompt('File exists. Overwrite?', ['y', 'n']) === 'y';
    }
}