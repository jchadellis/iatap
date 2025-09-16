<?php 

namespace App\Controllers\Purchasing\Orders;

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
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'Orders', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Orders', 
            'content' => view('purchasing/orders/index',[]),
            'js' => view('purchasing/orders/index.js.php'), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data($date = '2027-01-01')
    {
        // if(!$date)
        // {
        //     $date = date('Y-m-d');
        // }

        $data = $this->remote->getData("http://vatap/mvc/public/api/getpurchseworkorders/{$date}");

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