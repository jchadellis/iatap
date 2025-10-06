<?php

namespace App\Controllers\Errors;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    public function index()
    {

        
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Access Error', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Access Error', 
            'content' => view('errors/denied'),
            'js' => '', 
        ];

        return view('template/index', $data); 
    }
}
