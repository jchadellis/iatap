<?php 

namespace App\Controllers\Purchasing\Part\Name\Generator;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{


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
				['name' => 'Part', 'is_active' => false, 'url' => 'purchasing/part'],
				['name' => 'Name', 'is_active' => false, 'url' => 'purchasing/part/name'],
				['name' => 'Generator', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Generator', 
            'content' => view('purchasing/part/name/generator/index',[]),
            'js' => view('purchasing/part/name/generator/index.js.php'), 
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