<?php 

namespace App\Controllers\Shipping\OrderBoard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{


    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        // $data = [
        //     'site_name' => 'iATAP', 
        //     'breadcrumbs' => [
        //         ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
		// 		['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
		// 		['name' => 'OrderBoard', 'is_active' => true, 'url' => '#']
        //     ],
        //     'title' => 'Order Board', 
        //     'content' => view('sales/orderboard/shopview/index',[]),
        //     'js' => '', 
        // ];
        $urls = [
            'data' => base_url('shipping/order-board/data'), 
        ];
        $data['content'] = view('shipping/orderboard/shopview/index', ['urls' => $urls]); 
        return view('template/index-shopview', $data ); 

    }

    public function get_data()
    {
        $model = new SqlbaseModel();
        $url = "http://vatap/mvc/public/api/order_board"; 

        $results = $model->getData($url); 

        return $this->response->setJSON([
            'data' => $results
        ]);
    }
}