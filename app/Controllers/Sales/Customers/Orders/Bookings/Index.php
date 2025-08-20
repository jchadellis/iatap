<?php 

namespace App\Controllers\Sales\Customers\Orders\Bookings;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{

    private $cards = [
        [
            'name' => "", 
            'description' =>  '',
            'url' => '', 
            'btn_text' => '', 
            'icon' => '',
            'color' => '', 
        ],
    ];

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
				['name' => 'Customers', 'is_active' => false, 'url' => 'sales/customers'],
				['name' => 'Orders', 'is_active' => false, 'url' => 'sales/customers/orders'],
				['name' => 'Bookings', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Customer Orders - Bookings', 
            'content' => view('sales/customers/orders/bookings/index'),
            'js' => view('sales/customers/orders/bookings/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        
    }
}