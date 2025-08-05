<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LoginManagerModel; 
use App\Models\UserModel; 
use App\Models\PwdTypesModel; 

class LoginManager extends BaseController
{
    protected $model; 

    public function __construct()
    {
        $this->model = new LoginManagerModel(); 
    }

    public function index($id = null)
    {
        $users = (new UserModel())->findAll();  
        $pwd_types = (new PwdTypesModel())->findAll();   
        $model =  new LoginManagerModel(); 

        $user_btns = [];

        foreach( $users as $user )
        {
            $user_btns[] = ['name' => $user->first_name. ' ' . $user->last_name, 'id' => $user->id ];
        }

        $logins = ($id) ? $model->where('user_id', $id)->findAll() : $model->findAll(); 

        foreach($logins as $login)
        {
            foreach($pwd_types as $type)
            {
                if( $type->id == $login->type_id)
                {
                    $login->type = $type->name;
                }
            }
        }

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
            ['name' => 'Logins', 'is_active' => true, 'url' => ''],
        ];

        $data = [
            'breadcrumbs' => $breadcrumbs, 
            'content'   => view('admin/logins/index', ['data' => $logins, 'pwd_types' => $pwd_types, 'users' => $users, 'user_btns' => $user_btns, 'title' => 'Login Manager']),
            'js' => view('admin/logins/index.js.php'),
        ];

        return view('template/index', $data); 
    }

    public function save_data()
    {
        $post = $this->request->getPost(); 

        $has_pwd = ($post['password'] != '') ? true : false; 

        if(!$has_pwd)
        {
            unset($post['password']);
        }

        $this->model->save($post); 

        $login = $this->model->find(isset($post['id']) ? $post['id'] : $this->model->getInsertId() ); 

        unset($login->password); 

        return $this->response->setJSON([
            'success' => true, 
            'message' => 'Login Successfully Saved', 
            'data'  => $login, 
        ]);

    }

    public function decrypt($id)
    {

        $pwd = $this->model->find($id); 
        return $this->response->setJSON([
            'success' => true, 
            'data' => $this->model->decryptPassword($pwd->password),
        ]);
    }

    public function edit($id)
    {
        $users = (new UserModel())->findAll();  
        $pwd_types = (new PwdTypesModel())->findAll();    
        $pwd = $this->model->find($id);
    
        return $this->response->setJSON([
            'modal' => view('admin/logins/edit-modal-body', ['pwd' => $pwd, 'pwd_types' => $pwd_types, 'users' => $users ]),
        ]);
    }
}
