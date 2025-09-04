<?php 

namespace App\Controllers\Admin\UserManager;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel; 
use App\Models\NetAssetsModel;
use App\Models\EmployeeModel; 
use App\Entities\CustomUser; 
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Controllers\RegisterController; 
use Exception;

class Index extends RegisterController
{

    public function __construct()
    {
        $db = \Config\Database::connect(); 
        $employees = new EmployeeModel(); 
        $this->model = new UserModel(); 
        $this->depts            = $db->table('tbl_depts')->get()->getResult(); 
        $this->building         = $db->table('tbl_buildings')->get()->getResult();
        $this->workstations     = $db->table('tbl_net_assets')->where('type_id', '1')->orWhere('type_id', '2')->orderBy('display_name')->get()->getResult();
        $this->pages            = $db->table('tbl_pages')->get()->getResult(); 
        $this->groups           = $db->table('auth_groups')->orderBy('sort_order', 'asc')->get()->getResult();
        $this->permissions      = $db->table('auth_permissions')->get()->getResult();
        $this->employees        = $employees->select('employee_id, first_name, last_name')->orderBy('last_name', 'asc')->findAll(); 
        $this->email_service = service('email'); 
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Control Panel', 'is_active' => false, 'url' => 'sadmin/control-panel'],
				['name' => 'User Manager', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'User Manager', 
            'content' => view('admin/usermanager/index',[
                'depts' => $this->depts, 
                'building' => $this->building,
                'workstations' => $this->workstations, 
                'pages' => $this->pages, 
                'groups' => $this->groups, 
                'permissions' => $this->permissions,
                'employees' => $this->employees,  
            ]),
            'js' => view('admin/usermanager/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $data = $this->model->select("*, '1' as row_order")->findAll(); 

        if( $data )
        {
            return $this->response->setJSON(
                [
                    'data' => $data, 
                    'success' => true,
                    'message' => 'Retrieved Data',
                ]
            );
        }
        return $this->response->setJSON(
            [
                'success' => false, 
                'message' => 'Failed to get data', 
            ]
        );  
    }

    public function get_new_user()
    {
        $content = view('admin/usermanager/new-user-modal',[
            'data' => null,
            'depts' => $this->depts, 
            'buildings' => $this->building,
            'workstations' => $this->workstations, 
            'pages' => $this->pages, 
            'groups' => $this->groups, 
            'permissions' => $this->permissions, 
            'employees' => $this->employees,  
        ]); 

        return $this->response->setJSON(
            [
                'data' => $content,
                'success' => true,
            ]
        );
    }

    public function get_edit_user()
    {
        $post = $this->request->getPost();

        if(empty($post['id']))
        {
           return $this->response->setJSON(
                [
                    'title' => 'Error', 
                    'message' => 'User not found', 
                    'success' => false, 
                    'data' => null, 
                ]
           );
        }
        
        $user = auth()->getProvider()->findByID($post['id']); 

        $content = view('admin/usermanager/edit-user-modal',[
            'data' => $user,
            'depts' => $this->depts, 
            'buildings' => $this->building,
            'workstations' => $this->workstations, 
            'pages' => $this->pages, 
            'groups' => $this->groups, 
            'permissions' => $this->permissions, 
        ]); 

        return $this->response->setJSON(
            [
                'title' => 'User Name', 
                'message' => 'Retrieved User', 
                'success' => true, 
                'data'  => $content, 
                'first_name' => $user->first_name, 
                'last_name' => $user->last_name,
            ]
        );
    }

    public function add_user()
    {
        $post = $this->request->getPost();
        $userProvider   = $this->getUserProvider();
        $userEntity   = $this->getUserEntity();

        if(!empty($post))
        {
            $userEntity->fill($post);
            if (empty($userEntity->username)) {
                $userEntity->username = $userEntity->email;
            }

            $userProvider->save($userEntity);
            $lastID = $userProvider->getInsertID();

            $user = $this->model->find($lastID);

            if($user)
            {
                $groups = $post['groups'] ?? [];
                $permissions = $post['permissions'] ?? [];

                $this->syncUserAuth($user, $groups, $permissions); 
            }
        }


        $password = $post['password'] ?? '';

        $pw_changed = $this->syncPassword($user, $password); 

        $user->row_order = 0;

        if( $pw_changed )
        {
            return $this->response->setJSON([
                'password' => $password, 
                'success' => true,
                'email' => true,  
                'user' => $user, 
                'id' => $user->id, 
                'title' => 'User Created', 
                'message' => "User saved! Do you want to email the new password to {$user->first_name} {$user->last_name}?", 
            ]);
        }

        return $this->response->setJSON(
            [
                'data' => $user, 
                'post' => $post, 
                'success' => true, 
                'title' => 'User Created', 
                'message' => 'first_name last_name was without a password.', 
            ]
        );
        
    }

    public function save_user()
    {
        $post = $this->request->getPost(); 

        $user = $this->updateEntity($post);

        if ($user === null) {
            return $this->response->setJSON([
                'success' => false,
                'title' => 'Error',
                'message' => 'User not found or invalid data'
            ]);
        }

        $groups = $post['groups'] ?? [];
        $permissions = $post['permissions'] ?? [];
        $this->syncUserAuth($user, $groups, $permissions); 

        $host = $post['host_id'];
        $this->syncHost($user, $host);

        $password = $post['password'] ?? '';
        $pw_changed = $this->syncPassword($user, $password); 

        if( $pw_changed )
        {
            return $this->response->setJSON([
                'password' => $password, 
                'success' => true,
                'email' => true,  
                'user' => $user, 
                'id' => $user->id, 
                'title' => 'New Password', 
                'message' => "The user password was successfully changed. Do you want to email the new password to {$user->first_name} {$user->last_name}?", 
            ]);
        }

        return $this->response->setJSON(
            [
                'data' => $user, 
                'success' => true, 
                'title' => 'Success',
                'message' => "{$post['first_name']} {$post['last_name']} was updated!",
            ]
        );
    }

    public function remove_user()
    {
        $post = $this->request->getPost();
        $id = $post['id'] ?? null; 
        if (!$id) 
        {
            return $this->response->setJSON([
                'data' => null,
                'title' => 'Error',
                'message' => 'User ID is required',
                'success' => false,
            ]);
        }
            
        $userProvider = $this->getUserProvider();
        $assets = new NetAssetsModel();
        $user = $this->model->find($id);
        
        if (!$user) {
            return $this->response->setJSON([
                'data' => null,
                'title' => 'Error',
                'message' => 'User not found',
                'success' => false,
            ]);
        }
        
        $first_name = $user->first_name ?? '';
        $last_name = $user->last_name ?? '';

        try {
            $groups = $user->getGroups();
            $permissions = $user->getPermissions();

            if (!empty($groups)) {
                $user->removeGroup(...$groups);
            }

            if (!empty($permissions)) {
                $user->removePermission(...$permissions);
            }
        } catch (Exception $e) {  // Fixed typo: Exception not Expection
            return $this->response->setJSON([
                'data' => null,
                'title' => 'Groups and Permissions Error',
                'message' => $e->getMessage(),
                'success' => false,
            ]);
        }

        try {
            if ($user->host_id !== null) {
                $host = [
                    'assigned_to' => null,
                    'id' => $user->host_id,
                ];
                $assets->save($host);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'data' => null,
                'title' => 'Error Removing Host',
                'message' => $e->getMessage(),
                'success' => false,
            ]);
        }

        try {
            $userProvider->delete($id);
        } catch (Exception $e) {  // Fixed typo and success value
            return $this->response->setJSON([
                'data' => null,
                'title' => 'Error Deleting User',
                'message' => $e->getMessage(),
                'success' => false,  // Changed from true to false
            ]);
        }

        return $this->response->setJSON([
            'data' => null,
            'title' => 'Removed',
            'message' => "{$first_name} {$last_name} was successfully removed.",
            'success' => true,
        ]);
    }

    public function email_credentials()
    {
        $post = $this->request->getPost(); 

        $user = $this->model->find($post['id']); 

        $this->email_service->setMailType('html');
        $this->email_service->setFrom('jeremy.ellis@atap.com', 'iATAP Admin'); 
        $this->email_service->setTo($user->email); 
        $this->email_service->setSubject('iATAP Login Credentials');

        $message = view('admin/usermanager/email-body', ['data' => $user, 'password' => $post['password']]); 

        $this->email_service->setMessage($message); 

        if( $this->email_service->send() )
        {
            return $this->response->setJSON([
                'success' => true, 
                'title' => 'Success', 
                'message' => 'The username and password has been successfully emailed', 
            ]);
        }

        return $this->response->setJSON([
            'success' => false, 
            'title' => 'Error', 
            'meassage' => 'The was an error while sending the email', 
        ]);

    }

    protected function syncUserAuth($user, $groups, $permissions)
    {

        // Always sync groups - empty array will remove all groups
        if (is_array($groups)) {
            if (empty($groups)) {
                $user->syncGroups(...[]);
            } else {
                $user->syncGroups(...$groups);
            }
        }

        // Always sync permissions - empty array will remove all permissions
        if (is_array($permissions)) {
            if (empty($permissions)) {
                $user->syncPermissions(...[]);
            } else {
                $user->syncPermissions(...$permissions);
            }
        }
    }

    protected function syncPassword($user, $password)
    {
        if (!empty($password)) {
            $user->setPassword($password); 
            if( $this->model->save($user)){
                return true; 
            }  
        }
    }

    protected function syncHost($user, $host)
    {
        $model = new NetAssetsModel(); 
        if($host != 0)
        {
            $data = ['id' => $host, 'assigned_to' => $user->id]; 
        } else { 
            $data = ['id' => $host, 'assigned_to' => null]; 
        }
        $model->save($data); 
        return; 
    }

    protected function updateEntity($data)
    {
        if (!$data) return;

        $entity = isset($data['id']) ? $this->model->find($data['id']) : null;

        /**
         * If entity is empty of user does not exists 
         * Add new user 
         */

        if(!$entity)
        {
            $this->model->save($data); 
            $entity = $this->model->find($this->model->insertID()); 
            return $entity; 
        }

        $allowedFields = array_flip($this->model->getAllowedFields());
        
        $filteredData = array_intersect_key($data, $allowedFields);

        foreach ($filteredData as $key => $value) {
            $entity->$key = $value;
        }

        $dirty = $entity->getDirty();

        if (!empty($dirty)) {
            $this->model->save($entity);
        }
        return $entity; 
    }



}