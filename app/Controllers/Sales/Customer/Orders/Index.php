<?php 

namespace App\Controllers\Sales\Customer\Orders;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
    }

    public function index($id = null)
    {
        $customer = $this->remote_model->getData('http://vatap/mvc/public/api/getcustomer/'.$id)[0];

        $orders = $this->remote_model->getData('http://vatap/mvc/public/api/getcustomerorders/'.$id);

        $customer_name = ucwords( strtolower( $customer->name )); 
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales/'],
				['name' => "$customer_name", 'is_active' => false, 'url' => 'sales/customer/'.$id],
				['name' => 'Orders', 'is_active' => true, 'url' => '#']
            ],
            'title' => "$customer_name - Orders", 
            'content' => view('sales/customer/orders/index', ['orders' => $orders]),
            'js' => view('sales/customer/orders/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}