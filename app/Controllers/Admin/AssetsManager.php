<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController; 
use App\Models\NetAssetsModel; 
use App\Models\UserModel;
use App\Libraries\Forms\AssetsList; 

class AssetsManager extends BaseController
{
    private UserModel $userModel;
    private NetAssetsModel $assetsModel;  
    private array $host_types; 
    private array $dept_types;
    private array $switches; 

    public function __construct()
    {
        $db = db_connect(); 
        $this->users = new UserModel(); 

        $this->userModal = new UserModel();
        $this->assetsModel = new NetAssetsModel();  

        $this->dept_types              = $db->table('tbl_depts')->orderBy('name', 'ASC')->get()->getResult(); 
        //$this->data['building']         = $db->table('tbl_buildings')->orderBy('name', 'ASC')->get()->getResult();
        //$this->data['pwd_types']        = $db->table('tbl_pwd_types')->where('category', 'user')->get()->getResult();
        $this->host_types               = $db->table('tbl_net_asset_types')->orderBy('name', 'ASC')->get()->getResult();
        $this->switches                 = $db->table('tbl_net_assets')->where('type_id', '8')->orWhere('type_id', '9')->get()->getResult(); 
        //$this->data['assets']           = $db->table('tbl_net_assets')->get()->getResult();
    }

    public function index($id = null): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
            ['name' => 'Assets', 'is_active' => true, 'url' => ''],
        ];

        $data = [
            'title' => 'Assets Manager', 
            'breadcrumbs' => $breadcrumbs, 
            'assets' => $this->assetsModel->orderBy('ip_address')->findAll(), 
            'js' => view('admin/assets/index.js.php'),
            'host_types' => $this->host_types,
            'depts' => $this->dept_types, 
            'switches' => $this->switches,
        ];

        $data['content']  = view('admin/assets/index', $data); 
        return view('template/index', $data); 
    }




    public function print()
    {
        //$model = new NetAssetsModel(); 
        $assets = $this->assetsModel->orderBy('ip_address ASC, type_id DESC')->findAll();
        $pdf = new AssetsList(); 
        $outputFile = 'network_assets_list_' . date('mdY') . '.pdf';

        // Generate the PDF using the provided data
        $pdf->print($outputFile, $assets);
            // Return the PDF file as a new Browser Window. 
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $outputFile . '"')
            ->setBody(file_get_contents(WRITEPATH . 'uploads/assets/' . $outputFile));
    }

    public function print_details()
    {
        //$model = new NetAssetsModel(); 
        $assets  = $this->assetModel->orderBy('ip_address ASC')->where("ip_address BETWEEN '192.168.0.1' AND '192.168.0.254'")->findAll(); 

        $pdf = new AssetsList(); 

        $outputFile = 'network_assets_details_' . date('mdY') . '.pdf';

        $pdf->print_details($outputFile, $assets);


        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $outputFile . '"')
            ->setBody(file_get_contents(WRITEPATH . 'uploads/assets/' . $outputFile));
    }

    // public function delete($aid)
    // {
    //     //$assets = new NetAssetsModel(); 
    //     $this->assetsModel->delete($aid); 
    //     return $this->index(); 
    // }

    // public function create()
    // {
    //     //$assets = new NetAssetsModel();
    //     $asset = $this->request->getPost(); 
    //     $assetsModel->save($asset); 
    //     $response = $assetsModel->find($assets->getInsertId());
    //     $response->type = $response->type; 
    //     return $this->response->setJSON($response);
    // }

    // public function edit($aid)
    // {
    //     $asset = $this->assetsModel->find($aid);

    //     $breadcrumbs = [
    //         ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
    //         ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
    //         ['name' => 'Assets', 'is_active' => false, 'url' => 'sadmin/asset-manager'],
    //         ['name' => $asset->display_name, 'is_active' => true, 'url' => '#']
    //     ];

    //     if($asset->assigned_to)
    //     {
    //         //$userModel = new UserModel; 
    //         $user = $this->userModel->find($asset->assigned_to); 
    //         $data['assigned_to'] =  $user->first_name . ' ' . $user->last_name;
    //         $data['user_url'] = 'sadmin/user/edit/'.$user->id; 
    //     }

    //     $data =  [ 
    //         'asset' => $asset,
    //         'js'    => view('admin/assets/review.js.php'),
    //         'title' => $asset->ip_address, 
    //         'breadcrumbs' => $breadcrumbs, 
    //         'host_types'    => $this->host_types, 
    //         'depts'         => $this->dept_types, 
    //         'switches'      => $this->switches, 
    //     ];

    //     $data['content'] = view('admin/assets/review', $data); 
       
    //     return view('template/index', $data); 
    // }

    // public function update($aid)
    // {   

    //     //$assets  = new NetAssetsModel();
    //     $asset = $this->assetsModel->find($aid); 

    //     $postData = $this->request->getPost(); 

    //     if($asset)
    //     {
    //         foreach($postData as $key => $value )
    //         {
    //             $asset->$key = $value; 
    //         }
    //         $dirty = $asset->getDirty();    
    //     }

    //    if(!empty($dirty))
    //    {
    //       $dirty['id'] = $aid; 
    //       $this->assetsModel->save($dirty);
    //    }
    //     return redirect()->to('sadmin/asset/edit/'.$aid); 
    // }


    // public function add($uid)
    // {
    //     $host_id = $this->request->getPost('host')['host_id'];

    //     $user = ['id' => $uid, 'host_id' => $host_id ]; 

    //     $this->userModel->save($user);  

    //     $data = ['id' => $host_id, 'assigned_to' => $uid]; 

    //     $this->assetsModel->save($data); 
        
    //     return redirect()->to('sadmin/user/edit/'.$uid);
    // }

    // public function remove($uid)
    // {
    //     //$model = new UserModel(); 
    //     //$assetsModel = new NetAssetsModel();

    //     $user = $this->userModel->find($uid); 

    //     $host_id = $user->host_id; 
        
    //     if($user)
    //     {
    //         $user->host_id = 0; 
    //     }

    //     $dirty = $user->getDirty(); 

    //     if(!empty($dirty))
    //     {
    //         $data = ['id' => $host_id, 'assigned_to' => null ];
    //         $this->assetsModel->save($data); 
    //         $dirty['id'] = $uid; 
    //         $this->userModel->save($dirty);
    //     }

    //     return redirect()->to('sadmin/user/edit/'.$uid); 
    // }

}
