<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{

    private $cards = [
        [
            'name' => "Vendor List", 
            'description' =>  'List of all vendors',
            'url' => 'vendors/list', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/list-bullet',
            'color' => 'text-dark', 
        ],
        [
            'name' => "Performance", 
            'description' =>  'List of vendors and their on-time delivery performance over last ninty days.',
            'url' => 'vendors/performance', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/chart-bar',
            'color' => 'text-dark', 
        ],
        [
            'name' => "JCP Experation Report", 
            'description' =>  'Vendors with JCP Experation',
            'url' => 'vendors/jcp-report', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/document-chart',
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
                ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing' ],
				['name' => 'Vendor Tools', 'is_active' => true, 'url' => '#'],
            ],
            'title' => 'Vendor Tools', 
            'content' => view('vendors/index',['cards' => $this->cards]),
            'js' => view('vendors/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $data = [['col-1' => 'data']]; //get data from db or remote json

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