<?php 

namespace App\Controllers\Sales\Customers\Orders\Open;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{


    public function __construct()
    {
        $this->remote = new SqlbaseModel(); 
    }

    public function index()
    {
        $urls = [
            'data' => base_url('sales/customers/orders/open/data'),
        ];
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
				['name' => 'Customers', 'is_active' => false, 'url' => 'sales/customers'],
				['name' => 'Open Orders', 'is_active' => true, 'url' => '#'],
            ],
            'title' => 'Open Orders', 
            'content' => view('sales/customers/orders/open/index',[]),
            'js' => view('sales/customers/orders/open/index.js.php', ['urls' => $urls]), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data()
    {
        $url = 'http://192.168.1.39/mvc/public/api/getcustomerorderswithqty/';
        $data = $this->remote->getData($url); 

        if( $data )
        {
            return $this->response->setJSON(
                [
                    'data' => $data, 
                    'success' => true,
                    'message' => 'Retrieved Data',
                ]
            );
        }
        return $this->response->setJSON(
            [
                'success' => false, 
                'message' => 'Failed to get data', 
            ]
        );  
    }
}