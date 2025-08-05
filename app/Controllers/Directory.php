<?php

namespace App\Controllers;

use App\Models\DirectoryModel;

class Directory extends BaseController
{
    public function index(): string
    {
        $model = new DirectoryModel(); 
        
        $result = $model->findAll();

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Directory', 'is_active' => true, 'url' => '/directory'],
        ];

        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Dashboard', 'content' => view('directory/index', array('contacts' => $result)), 'js' => view('directory/index.js.php')];
        
        return view('template/index', $data);
    }

    public function search($search_text = 'Jeremy')
    {
        $search_text = $_POST['search'];
        $db = db_connect(); 
        $result = $db->table('tbl_directory dir')
        ->select('dir.name, dir.fname, dir.lname, dir.extension, dir.ip_address, dept.name as department, cat.name as category, bldg.name as building')
        ->join('tbl_depts dept', 'dept.id = dir.dept_id')
        ->join('tbl_phone_categories cat', 'cat.id = dir.category_id')
        ->join('tbl_buildings as bldg', 'bldg.id = dir.location_id')
        ->where('dir.category_id = 1')
        ->where("dir.fname ILIKE '" .$search_text. "%'")
        ->orWhere("dir.lname ILIKE '" . $search_text . "%'");
        $result = $result->get()->getResult(); 
        $data = ['contacts' => $result ];

        return view('directory/card', $data); 
    }

    public function edit($id)
    {
        //$
    }

}

