<?php 

namespace App\Controllers\Shipping\RMAs;

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
        $urls = [
            'data' => base_url('shipping/rmas/data'), 
        ];
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Shipping', 'is_active' => false, 'url' => 'shipping'],
				['name' => 'RMAs', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'RMAs', 
            'content' => view('shipping/rmas/index',['urls' => $urls ]),
            'js' => view('shipping/rmas/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
            $session = session(); 
            $model = new SqlbaseModel(); 

            $url = "http://vatap/mvc/public/api/shipping_rmas/";

            $date = new \DateTime();
            $start = (clone $date)->modify('- 90 days')->format('Y-m-d');
            $end = $date->format('Y-m-d'); 

            if( $this->request->getMethod() === 'POST')
            {
                $post = $this->request->getPost(); 
                $start = $post['start_date'];
                $end = $post['end_date'];
                $url = "http://vatap/mvc/public/api/shipping_rmas/{$start}/{$end}";
            }

            if( $session->has('performance_start_date') )
            {
                $start = $session->getTempdata('performance_start_date'); 
                $end = $session->getTempdata('performance_end_date'); 
                $url = "http://vatap/mvc/public/api/shipping_rmas/{$start}/{$end}";           
            }

            $results = $model->getData($url); 

            foreach($results as $result)
            {
                $date = new \DateTime($result->rma_date);
                $result->rma_date = $date->format('Y-m-d');
            }

            if( $results )
            {
            return $this->response->setJSON([
                    'success' => true, 
                    'title' => 'Success', 
                    'html' => "<p>RMAs for the period of</p><p><strong>{$start} - {$end}</strong></p>",
                    'icon' => 'info', 
                    'data' => $results,
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'title' => 'ERROR', 
                'html' => '<p>There was an error fetching NCPs</p>', 
                'icon' => 'warning', 
            ]);        
    }
}