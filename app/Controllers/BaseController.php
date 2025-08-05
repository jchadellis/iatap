<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\PageAccessLogs; 

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.

        

        $this->session = service('session');
        $this->request = service('request'); 
        $this->pageLogger(); 
    }

    public function pageLogger()
    {
                
        $user = auth()->user(); 
        $request = service('request'); 
        if ($user) {
            try {
                $router = service('router');
                $current_url = current_url(true);

                if($current_url->__toString() !== 'http://connectportal/index.php/sadmin/page-logs'){
                    $page = [
                        'user_id' => $user->id,
                        'previous_url' => previous_url(),
                        'controller' => $router->controllerName() ?: ($current_url->getSegments()[0] ?? 'unknown'),
                        'method' => $router->methodName() ?: 'index',
                        'current_url' => $current_url->__toString(),
                        'ip_address' => $request->getIPAddress(),
                        'user_agent' => $request->getUserAgent()->getAgentString(),
                    ];
                    

                    $pagelogger = new PageAccessLogs();
                    $pagelogger->save($page);
                }
                
            } catch (\Exception $e) {
                // Log error but don't break the application
                log_message('error', 'Page logging failed: ' . $e->getMessage());
            }
        }
    }

}
