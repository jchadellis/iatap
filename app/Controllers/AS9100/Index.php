<?php 

namespace App\Controllers\AS9100;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceTicketModel; 

class Index extends BaseController
{

    private $cards = [
        [
            'name' => "Performance & Compliance", 
            'description' =>  'A summary of key performance indicators supporting AS9100 compliance, including delivery performance, engineering efficiency, sales activity, audit results, and corrective actions.',
            'url' => 'as9100/performance', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/chart-bar',
            'color' => 'text-dark',
            'enabled' => true,  
        ],
        // [
        //     'name' => "Engineering Performance", 
        //     'description' =>  'List of Engineering Depts on-time  performance over last ninty days or enter a custom range.',
        //     'url' => 'as9100/engineering-performance', 
        //     'btn_text' => 'View', 
        //     'icon' => 'components/icon/chart-bar',
        //     'color' => 'text-dark',
        //     'enabled' => true,  
        // ],
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
				['name' => 'AS9100', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'AS9100', 
            'content' => view('as9100/index',[
                'cards' => $this->cards
            ]),
            'js' => view('as9100/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        
    }
}