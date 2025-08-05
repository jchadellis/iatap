<?php

namespace App\Controllers\Employee;

use App\Controllers\BaseController; 

class Leave extends BaseController
{
    public function index(): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Employee Resources', 'is_active' => false, 'url' => '/employee/resources'],
            ['name' => 'Leave Request', 'is_active' => true, 'url' => '/employee/leave/index']
        ];
        
       $data = array('title' => 'Employee Leave Request', 'breadcrumbs' => $breadcrumbs, 'site_name' => 'iATAP', 'js' => view('employee/js') );
       $data['content'] = view('employee/leave_request_form'); 
       return view('template/index', $data);
    }
}
