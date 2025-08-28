<?php 

namespace App\Controllers\Vendors\JCPReport;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\VendorsModel; 

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
    
    private $model; 

    public function __construct()
    {
        $this->model = new VendorsModel(); 
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
                ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing' ],
				['name' => 'Vendor Tools', 'is_active' => false, 'url' => 'vendors/tools'],
				['name' => 'JCP Expiration Report', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'JCP Expiration Report', 
            'content' => view('vendors/jcpreport/index',['cards' => $this->cards]),
            'js' => view('vendors/jcpreport/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $data = $this->model->where('jcp_expiration IS NOT NULL')->orderBy('jcp_expiration', 'desc')->findALL(); 

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