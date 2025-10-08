<?php 

namespace App\Controllers\Sales;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    private $tool_cards = [
        [
            'name' => "Customer List", 
            'description' =>  'Exportable list of current customers',
            'url' => 'sales/customers', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/table-icon',
            'color' => 'text-dark',
            'enabled' => true, 
        ],
        [
            'name' => "Open Customer Orders", 
            'description' =>  'List of customer orders where there is qty on hand.',
            'url' => 'sales/customers/orders/open', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/table-icon',
            'color' => 'text-dark',
            'enabled' => false, 
        ],
        [
            'name' => "EDE Items Report", 
            'description' =>  'View and download EDE Report spreadsheet',
            'url' => 'sales/ede/report/', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/table-icon',
            'color' => 'text-dark',
            'enabled' => true, 
            'permission' => 'edereport.view', 
        ],
        [
            'name' => "Part Lookup", 
            'description' =>  'Lookup Parts and view Sale, Purchase and Quote History',
            'url' => 'warehouse/parts/part-lookup', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/magnifying-glass',
            'color' => 'text-dark',
            'enabled' => true, 
            'permission' => 'edereport.view', 
        ],
    ];

    private $groups = ['sales'];

    private $secured_cards = [];
    
    public function index()
    {

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Sales', 
            'content' => view('template/dept-index', [
                'tool_cards' => $this->tool_cards,
                'secured_cards' => $this->secured_cards, 
                'groups' => $this->groups, 
                'user' => auth()->user() ?? null, 
                'title' => 'Sales Dept.'
            ]),
            'js' => view('sales/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}