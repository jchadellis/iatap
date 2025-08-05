<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController; 
use App\Models\LoginsModel; 
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

class Logins extends BaseController
{
    protected $logins = '';  
    public function __construct()
    {
        $db = db_connect(); 
        $this->logins = new LoginsModel(); 
    }

    public function add($uid)
    {
        $login = $this->request->getPost('passwords'); 
        
        $array = array_map(function($item) use ($uid) {
            $item['user_id'] = $uid;
            return $item;
        }, $login);

        foreach($array as $newLogin)
        {
            $password = new \App\Entities\Logins();
            $login = $password->fill($newLogin);

            $this->logins->insert($login);
            
        }

        return redirect()->to('/user/edit/'.$uid);
    }

    public function delete($lid)
    {
        $model = new LoginsModel(); 

        $login = $model->where('id', $lid)->findAll($lid)[0]; 
        $uid = $login->user_id; 

        if($login)
        {
            $model->where('id', $lid)->delete(); 
        }

        return redirect()->to('/user/edit/'.$uid);
    }
}