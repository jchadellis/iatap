<?php 

namespace App\Controllers\Sales;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    private $groups = ['sales'];

    private $secured_cards = [];

    public function index()
    {
        $model = new SqlbaseModel();
        $url = "http://vatap/mvc/public/api/salesbymonth"; 
        
        $total_sales = $model->getData($url); 

        $url = "http://vatap/mvc/public/api/getsalesperformance/1"; 

        $sales_performance = $model->getData($url); 

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Sales', 
            'content' => view('sales/index', [
                'total_sales' => $total_sales[0], 
                'sales_performance' => $sales_performance[0],
                'groups' => $this->groups, 
                'user' => auth()->user() ?? null, 
                'title' => 'Sales Dept.'
            ]),
            'js' => view('sales/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}