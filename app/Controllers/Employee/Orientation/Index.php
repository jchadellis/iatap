<?php 

namespace App\Controllers\Employee\Orientation;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Employee', 'is_active' => false, 'url' => 'employee'],
				['name' => 'Orientation', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Orientation', 
            'content' => view('employee/orientation/index'),
            'js' => view('employee/orientation/index.js.php'), 
        ];
    }
}