<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController; 
use App\Models\UserModel; 
use App\Models\LoginsModel; 
use App\Models\NetAssetsModel; 
use App\Entities\CustomUser; 
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Controllers\RegisterController; 

/**
 * This Controller extends RegisterController this id done so that 
 * the registering of users can use the building \Codigniter\Shield\ methods.
 * for example adding the user to auth_identies and auth_group_users. 
 * 
 * $this->create()
 * Takes the 
 * The default user group is 'user';  This will give any new users the default 
 * access to the site. 
 */

class Users extends RegisterController
{
    protected $data = []; 
    private $users; 
    public function __construct()
    {
        $db = db_connect(); 
        $this->users = new UserModel(); 
        $this->data['depts']            = $db->table('tbl_depts')->get()->getResult(); 
        $this->data['building']         = $db->table('tbl_buildings')->get()->getResult();
        $this->data['pwd_types']        = $db->table('tbl_pwd_types')->get()->getResult();
        $this->data['workstations']     = $db->table('tbl_net_assets')->where('type_id', '1')->orWhere('type_id', '2')->orderBy('display_name')->get()->getResult();
        $this->data['pages']            = $db->table('tbl_pages')->get()->getResult(); 
        $this->data['groups']           = $db->table('auth_groups')->orderBy('sort_order', 'asc')->get()->getResult();
    }
    public function index($id = null): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
            ['name' => 'Users', 'is_active' => true, 'url' => ''],
        ];

        $this->data['users'] = $this->users->findAll(); 
        $this->data['js'] = view('admin/users/index.js.php');   

        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'User Management', 'content' => view('admin/users/index', $this->data) ];
        return view('template/index', $data);
    }

    /**
     * Handles creation of a new user and their associated login credentials.
     *
     * - Fills a new user entity with data from the POST request.
     * - Saves the user using the user provider model.
     * - Adds the user to the default user group upon successful creation.
     * - Iterates through provided passwords and stores them in the login table.
     *
     * @return string 'true' on successful creation, 'false' if validation fails.
     * 
     * CI4 Shield has a default http://base_url/register controller that allows users to add thier own login. This is disabled 
     * so that we can controller users being entered into the DB. 
     */

    public function create()
    {

        // Retrieve all POST data
        $postData = $this->request->getPost('user');
        log_message('debug', 'POST Data: ' . print_r($postData, true));

        $users   = $this->getUserProvider();
        $user    = $this->getUserEntity();
        $newUser = $this->request->getPost('user');

        $user->fill($newUser);

        if (empty($user->username)) {
            $user->username = $user->email;
        }

        try {
            if (! $users->save($user)) {
                $lastQuery = $users->db->getLastQuery(); 
                log_message('error', 'Save failed for user: ' . ($lastQuery ?? 'No query executed'));
                log_message('error', 'Validation errors: ' . json_encode($users->errors()));

                return $this->response->setStatusCode(400)
                                    ->setJSON(['errors' => $users->errors()]);
            }

            // Save succeeded, log the insert
            log_message('info', 'Save succeeded: ' . $users->db->getLastQuery());

            $uid  = $users->getInsertID();
            $user = $users->findById($uid);

            $groups = $postData['groups'] ?? null; 

            if($groups)
            {
                $array = [];
                foreach($groups as $key => $value)
                {
                    $array[] = $value; 
                }
    
                $str = implode(', ', $array); 
    
                $user->syncGroups(...$array);
            }

            $host_id = $this->request->getPost('user')['host_id'];
            if($host_id != 0)
            {
                $assetsModel = new NetAssetsModel(); 
                $data = ['id' => $host_id, 'assigned_to' => $uid]; 
                $assetsModel->save($data); 
            }

           return $this->response->setJSON([
                'success' => true,
                'user'    => $user, 
                'message'   => 'User was saved successfully',
            ]);

        } catch (ValidationException $e) {
            log_message('error', 'Validation exception: ' . $e->getMessage());

            return $this->response->setStatusCode(400)
                                ->setJSON(['error' => $e->getMessage()]);
        }

    }

    public function edit($uid)
    {
        $this->data['user']  = auth()->getProvider()->findByID($uid);
        
        $user = $this->data['user'];
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
            ['name' => 'Users', 'is_active' => false, 'url' => '/sadmin/user-management'],
            ['name' => $user->first_name . ' ' .$user->last_name , 'is_active' => true, 'url' => '#'],
        ];





        $this->data['js'] = view('admin/user/review.js.php', ['user' => $user ]); 
        $this->data['breadcrumbs'] = $breadcrumbs; 
        $this->data['title'] = $user->first_name . ' '. $user->last_name;

        $this->data['content'] = view('admin/user/review', $this->data); 
        return view('template/index', $this->data);
    }

    public function update($uid)
    {

        $userData = $this->request->getPost('user');
        
        $this->updateEntity($this->users, $uid, $userData);

        $user = $this->users->find($uid);

        $groups = $userData['groups'] ?? null; 
        
        if($groups)
        {
            $array = [];
            foreach($groups as $key => $value)
            {
                $array[] = $value; 
            }

            $str = implode(', ', $array); 

            $user->syncGroups(...$array);
        }

        // Password update (Shield-specific)
        if (!empty($userData['password'])) {
            $user->setPassword($userData['password']); 
            $this->users->save($user);  
        }

        // Update passwords if provided
        $passwords = $this->request->getPost('passwords');
        if ($passwords) {
            echo '<pre>';
            $loginModel = new LoginsModel();
            foreach ($passwords as $pwd) {
                
                $login = $loginModel->where('id', $pwd['id'] )->findAll()[0];

                if ($login) {
                    $allowedFields = array_flip($loginModel->getAllowedFields());
                    $filteredData = array_intersect_key($pwd, $allowedFields);
                    foreach ($filteredData as $key => $value) {
                        $login->$key = $value;
                    }

                    $dirty = $login->getDirty();
                    if (!empty($dirty)) {
                        db_connect()->table('tbl_logins')->where('id', $pwd['id'])->update($dirty);
                    }
                }
            }
        }
        return redirect()->to('sadmin/user/edit/' . $uid);
    }

    /**
     * Generic model updater
     */
    protected function updateEntity($model, $id, $data)
    {
        $entity = $model->find($id);
        if (!$entity || !$data) return;

        $allowedFields = array_flip($model->getAllowedFields());
        $filteredData = array_intersect_key($data, $allowedFields);

        foreach ($filteredData as $key => $value) {
            $entity->$key = $value;
        }

        $dirty = $entity->getDirty();
        if (!empty($dirty)) {
            $model->save($entity);
        }
    }

    public function create_guest()
    {
        $users = auth()->getProvider();
        
        $user = new CustomUser([
            'username'      => 'guest',
            'email'         => 'guest@atap.com',
            'password'      => 'ENaseuAK',
        ]);

        $users->save($user); 

        $user = $users->findById($users->getInsertID()); 

        $user->addGroup('guest');

    }


}
