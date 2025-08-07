<?php 

namespace App\Controllers\Sales\Customers;

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

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
				['name' => 'Customers', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Customers', 
            'content' => view('sales/customers/index'),
            'js' => view('sales/customers/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $customers = $this->remote_model->getData('http://vatap/mvc/public/api/getcustomers/'); 

        if($customers){
            return $this->response->setJSON(
                [
                    'success' => true, 
                    'message' => 'Data fetched successfully', 
                    'data' => $customers,
                ]
            );
        }
    }

}