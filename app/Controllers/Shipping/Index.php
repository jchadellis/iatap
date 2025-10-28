<?php 

namespace App\Controllers\Shipping;

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
				['name' => 'Shipping', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Shipping', 
            'content' => view('shipping/index',['cards' => $this->cards]),
            'js' => view('shipping/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        
    }
}