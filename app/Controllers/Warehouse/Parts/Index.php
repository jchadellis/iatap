<?php 

namespace App\Controllers\Warehouse\Parts;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{

    private $cards = [
        [
            'name' => "Parts Search", 
            'description' =>  'Search Part Maintenance by part number, description and user defines',
            'url' => 'warehouse/parts/part-lookup', 
            'btn_text' => 'Search', 
            'icon' => 'components/icon/magnifying-glass',
            'color' => 'text-dark', 
        ],
    ];

    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Warehouse', 'is_active' => false, 'url' => 'warehouse'],
				['name' => 'Part Maintenance', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Part Maintenance', 
            'content' => view('warehouse/parts/index',['cards' => $this->cards]),
            'js' => view('warehouse/parts/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        
    }
}