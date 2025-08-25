<?php

namespace App\Controllers\User;
use App\Controllers\BaseController; 
use App\Models\UserModel; 
use App\Models\EmployeeModel; 

class Index extends BaseController
{
    public function index($id = null): string
    {
        $employee = new EmployeeModel(); 
        
        if( is_null($id) )
        {
            $breadcrumbs = [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Profile', 'is_active' => false, 'url' => '/user/profile'],
                ['name' => auth()->user()->first_name . ' ' . auth()->user()->last_name , 'is_active' => true, 'url' => '#'],
            ];
    
            $user = auth()->user();
            $details = $employee->where('employee_id', $user->employee_id )->first(); 
            $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => $user->first_name . ' ' . $user
            ->last_name .' - Profile', 'content' => view('user/index', ['user' => $user , 'details' => $details ] ) , 'js' => ''];
            return view('template/index', $data);
        }

        $model = new UserModel(); 
        $user = $model->find($id); 
        $details = $$employee->where('employee_id', $user->employee_id )->first();

        if( $user )
        {
            $breadcrumbs = [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
                ['name' => 'Users', 'is_active' => false, 'url' => '/sadmin/user-management'],
                ['name' => 'Edit', 'is_active' => false, 'url' => '/sadmin/user/edit/'.$user->id],
                ['name' => $user->first_name . ' ' . $user->last_name , 'is_active' => true, 'url' => '#'],
            ];

            $data = [
                'site_name' => 'iATAP', 
                'breadcrumbs' => $breadcrumbs, 
                'title' =>$user->first_name . ' ' . $user->last_name.' - Profile', 
                'content' => view('user/index', ['user' => $user, 'details' => $details]),
                'js' => '', 
            ];


            return view('template/index', $data);

        }

    }

}
