<?php 

namespace App\Controllers\Warehouse\CycleCounts;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{

    protected $remote; 

    public function __construct()
    {
        $this->remote = new SqlbaseModel(); 
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Warehouse', 'is_active' => false, 'url' => 'warehouse'],
				['name' => 'Inventory Location Qtys', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Inventory Loc. Qtys', 
            'content' => view('warehouse/cyclecounts/index',[]),
            'js' => view('warehouse/cyclecounts/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $data = $this->request->getPost(); 

        $start = urlencode(strtoupper($data['start'])); 
        $finish = urlencode(strtoupper($data['finish'])); 

        $rules  = [
            'start' => [
                'rules' => 'required', 
                'label' => 'Start Location', 
                'errors' => [
                    'required' => 'Start Location is required', 
                ]
            ],
            'finish' => [
                'rules' => 'required', 
                'label' => 'End Location', 
                'errors' => [
                    'required' => 'End Location is required',
                ],
            ]
        ];

        if(!$this->validate($rules))
        {
            $message = ''; 

            foreach($this->validator->getErrors() as $error )
            {
                $message .= $error . "<br>"; 
            }

            return $this->response->setJSON([
                'success' => false, 
                'icon' => 'warning', 
                'html' => $message,
                'title' => 'Error', 
            ]);
        } 

        $url = "http://vatap/mvc/public/api/getcyclecounts/$start/$finish";

        $data = $this->remote->getData($url); 

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
                'html' => '<b>Failed to get data</b>', 
                'data' => $url, 
                'icon' => 'warning', 
                'title' => 'Error', 
            ]
        );  
    }
}