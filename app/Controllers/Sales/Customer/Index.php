<?php 

namespace App\Controllers\Sales\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
    }

    public function index($id)
    {
        $customer = $this->remote_model->getData('http://vatap/mvc/public/api/getcustomer/'.$id)[0];

        $cards = [
            [
                'name' => "Customer Orders", 
                'description' =>  'List of current released orders',
                'url' => 'sales/customer/orders/'.$id, 
                'btn_text' => 'View Orders', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
            ],
        ];

        $customer_name = ucwords(strtolower($customer->name)); 
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
                ['name' => 'Customers', 'is_active' => false, 'url' => 'sales/customers'],
				['name' => "$customer_name", 'is_active' => true, 'url' => '#']
            ],
            'title' => "$customer_name", 
            'content' => view('sales/customer/index', ['customer' => $customer, 'cards' => $cards ]),
            'js' => view('sales/customer/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}