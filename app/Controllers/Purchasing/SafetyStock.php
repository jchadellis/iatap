<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class SafetyStock extends BaseController
{

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Safety Stock', 'is_active' => true, 'url' => '#'],
        ];

        $this->content = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Safety Stock Report', 'content' =>  view('purchase/safety-stock') ];
        $this->content['js'] = view('purchase/safety-stock.js.php');
        
        return view('template/index-full', $this->content);
    }

    public function get_data()
    {
        $this->remote_model = new SqlbaseModel(); 
        $this->data = $this->remote_model->getData('http://vatap/mvc/public/api/getsafetystock'); 
        return $this->response->setJSON(['data' => $this->data]); 
    }
}
