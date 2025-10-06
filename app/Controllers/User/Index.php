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
            ->last_name .' - Profile', 'content' => view('user/index', ['user' => $user , 'details' => $details ] ) , 'js' => view('user/index.js.php')];
            return view('template/index', $data);
        }

        $model = new UserModel(); 
        $user = $model->find($id); 
        $details = $employee->where('employee_id', $user->employee_id )->first();

        if( $user )
        {
            $breadcrumbs = [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
                ['name' => 'Users', 'is_active' => false, 'url' => '/sadmin/user-manager'],
                ['name' => $user->first_name . ' ' . $user->last_name , 'is_active' => true, 'url' => '#'],
            ];

            $data = [
                'site_name' => 'iATAP', 
                'breadcrumbs' => $breadcrumbs, 
                'title' =>$user->first_name . ' ' . $user->last_name.' - Profile', 
                'content' => view('user/index', ['user' => $user, 'details' => $details]),
                'js' => view('user/index.js.php'), 
            ];


            return view('template/index', $data);

        }

    }


    public function get_pto()
    {
        $employee = new EmployeeModel(); 
        $post = $this->request->getPost(); 

        if($post['password'])
        {
            $user = auth()->user(); 
            $hashed_pwd = $user->password_hash;
            $submitted_pwd = $post['password']; 
            if(password_verify($submitted_pwd, $hashed_pwd))
            {

                $user = auth()->user();
                $user->details = $employee->where('employee_id', $user->employee_id )->first(); 
                return $this->response->setJSON([
                    'success' => true, 
                    'data' => $user,
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Submitted password did not match', 
        ]);

    }

}
