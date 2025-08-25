<?php 

namespace App\Controllers\Test\Test;

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
				['name' => 'Test', 'is_active' => false, 'url' => 'test'],
				['name' => 'Test', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Test', 
            'content' => view('test/test/index',['cards' => $this->cards]),
            'js' => view('test/test/index.js.php'), 
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