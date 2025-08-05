<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        //$pages = $this->db->query('SELECT * FROM tbl_pages'); 

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => true, 'url' => '/dashboard'],
        ];

        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Dashboard', 'content' => view('dashboard/index'), 'js' => ''];
        return view('template/index', $data);
    }


}
