<?php

namespace App\Controllers\User;
use App\Controllers\BaseController; 
use App\Models\UserModel; 

class Index extends BaseController
{
    public function index($id = null): string
    {
        
        if( is_null($id) )
        {
            $breadcrumbs = [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Profile', 'is_active' => false, 'url' => '/user/profile'],
                ['name' => auth()->user()->first_name . ' ' . auth()->user()->last_name , 'is_active' => true, 'url' => '#'],
            ];
    
            $user['user'] = auth()->user();
            $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => auth()->user()->first_name . ' ' . auth()->user()
            ->last_name .' - Profile', 'content' => view('user/index', $user) ];
            return view('template/index', $data);
        }

        $model = new UserModel(); 
        $user['user'] = $model->find($id); 
        $firstname = $user['user']->first_name; 
        $lastname = $user['user']->last_name; 
        $id = $user['user']->id; 

        if( $user )
        {
            $breadcrumbs = [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
                ['name' => 'Users', 'is_active' => false, 'url' => '/sadmin/user-management'],
                ['name' => 'Edit', 'is_active' => false, 'url' => '/sadmin/user/edit/'.$id],
                ['name' => $firstname . ' ' . $lastname , 'is_active' => true, 'url' => '#'],
            ];

            $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => $firstname . ' ' . $lastname.' - Profile', 'content' => view('user/index', $user) ];


            return view('template/index', $data);

        }

    }

}
