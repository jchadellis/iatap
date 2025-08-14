<?php 

namespace App\Controllers\Purchasing\Paint;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Paint Report', 'is_active' => true, 'url' => '#'],
        ];

        $this->content = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Paint Report', 'content' => view('purchasing/paint/index') ];
        $this->content['js'] = view('purchasing/paint/index.js.php'); 

        return view('template/index', $this->content);
    }

    public function get_data($raw = false)
    {
        $this->remote_model = new SqlbaseModel(); 
        $this->data = $this->remote_model->getData('http://vatap/mvc/public/api/getpaintreport', $raw); 
        return $this->response->setJSON(['data' => $this->data]);
    }
}