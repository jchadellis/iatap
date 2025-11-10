<?php 

namespace App\Controllers\Purchasing\Paint\Issued;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{


    public function __construct()
    {

    }

    public function index()
    {
        $urls = [
            'data' => base_url('purchasing/paint-issued/data'), 
        ]; 

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'Paint', 'is_active' => false, 'url' => 'purchasing/paint'],
				['name' => 'Issued', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Paint Issued', 
            'content' => view('purchasing/paint/issued/index',['urls' => $urls]),
            'js' => view('purchasing/paint/issued/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $model = new SqlbaseModel(); 
        $url = "http://vatap/mvc/public/api/paint_issued";

        $data = $model->getData($url); 

        if( $data )
        {
            return $this->response->setJSON(
                [
                    'data' => $data, 
                    'success' => true,
                    'icon' => 'success', 
                    'title' => 'Transactions Received', 
                    'html' => '<p>This weeks transaction for paint have been loaded</p>',
                ]
            );
        }
        return $this->response->setJSON(
            [
                'success' => false, 
                'message' => '',
                'data' => ['id' => '', 'qty' => '', 'stock_um' => ''],  
                'title' => 'No Materials Found', 
                'icon' => 'warning',
                'html' => "<p>Nothing to show just yet! No paint materials have been issued for this week, but check back soon.</p>",
            ]
        );  
    }
}