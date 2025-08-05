<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Errors extends BaseController
{
    public function index()
    {
        //
    }

    public function denied()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'] ,
        ];

        return view('template/index', ['breadcrumbs' => $breadcrumbs, 'content' => view('errors/denied'), 'js' => '']); 
    }
}
