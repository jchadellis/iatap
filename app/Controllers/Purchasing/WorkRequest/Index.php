<?php 

namespace App\Controllers\Purchasing\WorkRequest;

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
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'WorkRequest', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Work Request', 
            'content' => view('purchasing/workrequest/index',['cards' => $this->cards]),
            'js' => view('purchasing/workrequest/index.js.php'), 
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