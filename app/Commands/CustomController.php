<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CustomController extends BaseCommand
{
    protected $group       = 'Generators';
    protected $name        = 'make:standard-controller';
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
        $templatePath = APPPATH . 'Commands/Generators/Views/controller.tpl.php';
        $viewPath = APPPATH.'Views/'.implode('/', $baseUrlSegments); 

        $template = file_get_contents($templatePath);
         
        // Replace placeholders
        $replacements = [
            '<@php' => '<?php', 
            '{namespace}' => 'App\\Controllers\\'.implode('\\', $controllerPath),
            '{useStatement}' => 'CodeIgniter\\Controller',
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

        $this->createTemplates( $path, $processedTemplate, $className);
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
            }else{

                $target = $directories['view'] . '/' . $file;

                if (! $this->overwrite($target) ) {
                    return false;
                }

                if(!write_file( $target, 'Template File' )){
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