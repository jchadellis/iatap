<?php 

namespace App\Controllers\Test\Test;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{

    public function index()
    {
        $model = new SqlbaseModel();
        $url = "http://vatap/mvc/public/api/total_purchase_orders"; 
        
        $totals = $model->getData($url); 

        $url = "http://vatap/mvc/public/api/vendor_performance/1"; 

        $performance = $model->getData($url); 

        $data = [
            'site_name' => 'iATAP', 
            'title' => 'Test', 
            'page' => 'Test', 
            'content' => view('test/test/index', ['totals' => $totals[0], 'performance' => $performance[0] ]),
            'js' => view('test/test/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function print_data()
    {
        $data = $this->request->getPost();
        $dates = explode(' to ', $data['date']); 

        print_array($dates);
        return; 
    }
}