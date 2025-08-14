<?php 

namespace App\Controllers\Purchasing\Fabrication;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel;

class Index extends BaseController
{

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Fabrication Report', 'is_active' => true, 'url' => '#'],
        ];

        $this->content = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Fabrication Report', 'content' =>  view('purchasing/fabrication/index') ];
        $this->content['js'] = view('purchasing/fabrication/index.js.php'); 

        return view('template/index-full', $this->content);
    }

    public function get_data()
    {
        $this->remote_model = new SqlbaseModel(); 
        $this->data = $this->remote_model->getData('http://vatap/mvc/public/api/getfabreport'); 
        return $this->response->setJSON(['data' => $this->data]);
    }
}