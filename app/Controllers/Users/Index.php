<?php

namespace App\Controllers\Users;
use App\Controllers\BaseController; 
use CodeIgniter\Shield\Entities\User;

class Index extends BaseController
{
    public function index(): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'User Management', 'is_active' => true, 'url' => '#'],
        ];

        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'User Management', 'content' => view('users/index')];
        return view('template/index', $data);
    }

    public function form()
    {
        $db = db_connect(); 
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'User Management', 'is_active' => false, 'url' => '/user/'],
            ['name' => 'New User', 'is_active' => true, 'url' => '#'],
        ];

        $data['depts']            = $db->table('tbl_depts')->get()->getResult(); 
        $data['building']         = $db->table('tbl_buildings')->get()->getResult();
        $data['pwd_types']        = $db->table('tbl_pwd_types')->get()->getResult();
        $data['host_types']       = $db->table('tbl_net_asset_types')->get()->getResult();
        $data['switches']         = $db->table('tbl_net_assets')->where('type_id', '8')->orWhere('type_id', '9')->get()->getResult(); 
        $data['workstations']     = $db->table('tbl_net_assets')->where('type_id', '1')->orWhere('type_id', '2')->get()->getResult();
        $data['access_levels']    = $db->table('tbl_access_levels')->get()->getResult();
        $data['pages']            = $db->table('tbl_pages')->get()->getResult(); 
        $data['js']               = view('users/wizard.js.php');

        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'New User', 'content' => view('users/wizard', $data)];

        return view('template/index', $data);

    }

    public function current()
    {
        
       
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'User Management', 'is_active' => false, 'url' => '/user/'],
            ['name' => 'Current User', 'is_active' => true, 'url' => '#'],
        ];


        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'New User', 'content' => view('user/current')];

        return view('template/index', $data);
    }


}
