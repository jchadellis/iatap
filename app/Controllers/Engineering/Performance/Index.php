<?php 

namespace App\Controllers\Engineering\Performance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceTicket; 

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
				['name' => 'Engineering', 'is_active' => false, 'url' => 'engineering'],
				['name' => 'Performance', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Engineering Performance', 
            'content' => view('engineering/performance/index',[]),
            'js' => view('engineering/performance/index.js.php'), 
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