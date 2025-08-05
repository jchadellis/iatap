<?php

namespace App\Controllers\Admin\Asset\Edit;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NetAssetsModel; 
use App\Models\UserModel;

class Index extends BaseController
{
    private UserModel $userModel;
    private NetAssetsModel $assetsModel;  
    
    public function __construct()
    {       
        $this->db = \Config\Database::connect();
        $this->userModel = new UserModel();
        $this->assetsModel = new NetAssetsModel();  
        $this->dept_types              = $this->db->table('tbl_depts')->orderBy('name', 'ASC')->get()->getResult(); 
        $this->host_types               = $this->db->table('tbl_net_asset_types')->orderBy('name', 'ASC')->get()->getResult();
        $this->switches                 = $this->db->table('tbl_net_assets')->where('type_id', '8')->orWhere('type_id', '9')->get()->getResult(); 

    }

    public function index($id)
    {
        $asset = $this->assetsModel->find($id);

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
            ['name' => 'Assets', 'is_active' => false, 'url' => 'sadmin/asset-manager'],
            ['name' => $asset->display_name, 'is_active' => true, 'url' => '#']
        ];

        if($asset->assigned_to)
        {
            $userModel = new UserModel; 
            $user = $userModel->find($asset->assigned_to); 
            $data['assigned_to'] =  $user->first_name . ' ' . $user->last_name;
            $data['user_url'] = 'sadmin/user/edit/'.$user->id; 
        }

        $data =  [ 
            'asset' => $asset,
            'js'    => view('admin/assets/review.js.php'),
            'title' => $asset->ip_address, 
            'breadcrumbs' => $breadcrumbs, 
            'host_types'    => $this->host_types, 
            'depts'         => $this->dept_types, 
            'switches'      => $this->switches, 
        ];
        
        $data['content'] = view('admin/assets/review', $data); 
       
        return view('template/index', $data);
    }

    public function save($id)
    {   
        $asset = $this->assetsModel->find($id); 

        $postData = $this->request->getPost(); 

        if($asset)
        {
            foreach($postData as $key => $value )
            {
                $asset->$key = $value; 
            }
            $dirty = $asset->getDirty();    
        }

       if(!empty($dirty))
       {
          $dirty['id'] = $id; 
          $this->assetsModel->save($dirty);
       }
        return redirect()->to('sadmin/asset/edit/'.$id); 
    }

    public function addUser($id)
    {
        
        $host_id = $this->request->getPost('host')['host_id'];

        $user = ['id' => $id, 'host_id' => $host_id ]; 

        $this->userModel->save($user);  

        $data = ['id' => $host_id, 'assigned_to' => $id]; 

        $this->assetsModel->save($data); 
        
        return redirect()->to('sadmin/user/edit/'.$id);
    }

    public function removeUser($id)
    {
        $user = $this->userModel->find($id); 

        $host_id = $user->host_id; 
        
        if($user)
        {
            $user->host_id = 0; 
        }

        $dirty = $user->getDirty(); 

        if(!empty($dirty))
        {
            $data = ['id' => $host_id, 'assigned_to' => null ];
            $this->assetsModel->save($data); 
            $dirty['id'] = $id; 
            $this->userModel->save($dirty);
        }

        return redirect()->to('sadmin/user/edit/'.$id); 
    }

    public function lookup($id)
    {
        $data['asset'] = $this->assetsModel->find($id); 
        return view('template/mobile', $data);
    }
}
