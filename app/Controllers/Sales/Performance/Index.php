<?php 

namespace App\Controllers\Sales\Performance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{


    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $session = session(); 
        $url = base_url('sales/performance/data');
        $range = "Customer Order Performance Last 90 Days"; 
        if( $session->has('performance_start_date') )
        {
            $start = $session->get('performance_start_date');
            $end = $session->get('performance_end_date');
            $start = (new \DateTime($start))->format('m-d-Y'); 
            $end = (new \DateTime($end))->format('m-d-Y'); 
            $range = "Customer Order Performance <strong>{$start}</strong> to <strong>{$end}</strong>"; 
        }
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
				['name' => 'Performance', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Sales Performance', 
            'content' => view('sales/performance/index', ['url' => $url, 'range' => $range ]),
            'js' => view('sales/performance/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {

        $session = session();
        $model = new SqlbaseModel(); 
        $url = "http://vatap/mvc/public/api/getsalesperformance"; 

        if( $this->request->getMethod() === 'POST') 
        {
            $post = $this->request->getPost(); 
            $start = $post['start_date'];
            $end = $post['end_date'];
            $url = "http://vatap/mvc/public/api/getsalesperformance/0/{$start}/{$end}";
            $data = $model->getData($url); 

            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Vendor Performance</p><p><strong>{$start} - {$end}</strong></p>",
                ]
            );
        }
        
        if( $session->has('performance_start_date') )
        {
            $start = $session->get('performance_start_date');
            $end = $session->get('performance_end_date');
            $url = "http://vatap/mvc/public/api/getsalesperformance/0/{$start}/{$end}";

            $data = $model->getData($url); 
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Vendor Performance</p><p><strong>{$start} - {$end}</strong></p>",
                ]
            );

        }

        $data = $model->getData($url); 
        if( $data )
        {
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Vendor Performance</p><p><strong>Last 90 Days</strong></p>",
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