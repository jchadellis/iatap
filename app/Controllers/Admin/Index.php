<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController; 
use App\Models\PagesModel; 

class Index extends BaseController
{

    protected $tool_card = [
        [
            'name' => 'Server Manager', 
            'description' => 'Web-based server management tool. Manage the web server through a simple web interface with easy-to-use features.', 
            'url' => '', 
            'btn_text' => 'Open Manager', 
            'icon' => 'components/icon/server-stack-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'Database Manager', 
            'description' => 'Web-based Postgres DB management. ', 
            'url' => 'pgadmin4', 
            'btn_text' => 'Open Manager', 
            'icon' => 'components/icon/database-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'User Manager', 
            'description' => 'Used to manage iATAP site users and logins. Add, Edit and Delete users.', 
            'url' => 'sadmin/user-management', 
            'btn_text' => 'Open Manager', 
            'icon' => 'components/icon/users-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'Login Manager', 
            'description' => 'Used to manage logins. Add, Edit and Delete Logins', 
            'url' => 'sadmin/login-manager', 
            'btn_text' => 'Open Manager', 
            'icon' => 'components/icon/cloud-arrow-up-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'Asset Manager', 
            'description' => 'Used to manage Network Assets switches, workstations, printers, etc...', 
            'url' => 'sadmin/assets-manager', 
            'btn_text' => 'Open Manager', 
            'icon' => 'components/icon/computer-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'Page Logs', 
            'description' => 'Used to manage Network Assets switches, workstations, printers, etc...', 
            'url' => 'sadmin/page-logs', 
            'btn_text' => 'Open Manager', 
            'icon' => 'components/icon/page-icon',
            'color' => 'text-dark', 
        ],

    ];

    public function index($id = null): string
    {
        $pages = new PagesModel(); 
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => true, 'url' => '#'],
        ];

        $data['pages'] = $pages->findAll(); 
        $data['tool_cards'] = $this->tool_card; 

        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Control Panel', 'content' => view('admin/index', $data) , 'js' => ''];
        return view('template/index', $data);
    }

}
