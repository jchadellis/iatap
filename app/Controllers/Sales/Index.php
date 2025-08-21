<?php 

namespace App\Controllers\Sales;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    private $cards = [
        [
            'name' => "Customer List", 
            'description' =>  'Exportable list of current customers',
            'url' => 'sales/customers', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/table-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => "Customer Order Bookings", 
            'description' =>  'List of Customer Orders',
            'url' => 'sales/customers/bookings', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/table-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => "EDE Items Report", 
            'description' =>  'View and download EDE Report spreadsheet',
            'url' => 'sales/ede/report/', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/table-icon',
            'color' => 'text-dark', 
            'permission' => 'edereport.view', 
        ],
    ];
    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Sales', 
            'content' => view('sales/index', ['cards' => $this->cards]),
            'js' => view('sales/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}