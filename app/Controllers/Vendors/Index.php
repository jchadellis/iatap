<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect('visual_cache');
        $this->data = $this->db->query("SELECT * FROM vendor_cache")->getResult(); 
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Puchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Vendors',  'is_active' => true, 'url' => '#']
        ];

        $data = $this->data; 
        $content = view('vendors/index', ['data' => $data ]); 
        $js = view('vendors/index.js.php'); 

        return view('template/index', ['content' => $content, 'title' => 'Vendors', 'js' => $js , 'breadcrumbs' => $breadcrumbs]);
    }

    public function get_data()
    {
        foreach($this->data as $row)
        {
            //Convert date strings to date objects
            $row->open_date = new \DateTime($row->open_date); 
            $row->modify_date = new \DateTime($row->modify_date); 
        }

        return $this->response->setJSON(['data' => $this->data]); 
    }
}
