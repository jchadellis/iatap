<?php 

namespace App\Controllers\AS9100\Performance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 
use App\Models\ServiceTicketModel; 

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
				['name' => 'AS9100', 'is_active' => false, 'url' => 'as9100'],
				['name' => 'Performance & Compliance', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Performance & Compliance', 
            'content' => view('as9100/performance/index',['data' => $this->get_data()]),
           'js' => view('as9100/performance/index.js.php'), 
        ];
        return view('template/index', $data); 
    }

    public function get_data()
    {

        $session = session(); 
        $performanceModel = new ServiceTicketModel(); 
        $model = new SqlbaseModel(); 
        $start = isset($post['start_date']) ? $post['start_date'] : (new \DateTime())->modify('-90 days')->format('Y-m-d') ;
        $end = isset($post['end_date']) ? $post['end_date'] :  (new \DateTime())->format('Y-m-d');
        
        $salesUrl = "http://vatap/mvc/public/api/getsalesperformance/1"; 
        $vendorUrl = "http://vatap/mvc/public/api/vendor_performance/1";
        $countsUrl = "http://vatap/mvc/public/api/get_counts/";

        $session->setTempdata('performance_start_date', $start);
        $session->setTempdata('performance_end_date', $end); 

        $engineeringData = $performanceModel->getPerformance('engineering', $start, $end, true);

        if( $this->request->getMethod() === 'POST')
        {
            $post = $this->request->getJSON(); 


            $start = $post->start;
            $end = $post->end;

            $session->setTempdata('performance_start_date', $start);
            $session->setTempdata('performance_end_date', $end); 

            if( $start === '' || $end === '')
            {
                return $this->response->setJSON([
                    'success' => false, 
                    'icon' => 'warning', 
                    'html' => '<p>Please enter a valid date</p>',
                    'title' => 'Error',
                ]);
            }

            $salesUrl = "http://vatap/mvc/public/api/getsalesperformance/1/{$start}/{$end}";
            $vendorUrl = "http://vatap/mvc/public/api/vendor_performance/1/{$start}/{$end}";
            $countsUrl = "http://vatap/mvc/public/api/get_counts/{$start}/{$end}";
            $engineeringData = $performanceModel->getPerformance('engineering', $start, $end, true);

            $salesData = $model->getData($salesUrl); 
            $vendorData = $model->getData($vendorUrl); 
            $countsData = $model->getData($countsUrl);
                
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => [$salesData[0], $engineeringData, $vendorData[0], $countsData[0]], 
                    'title' => 'Success', 
                    'html' => '<p>Retrieve Data</p>',
                    'icon' => 'success',
            ]);
        }

        $salesData = $model->getData($salesUrl); 
        $vendorData = $model->getData($vendorUrl); 
        $countsData = $model->getData($countsUrl);

     
        return [$salesData[0], $engineeringData, $vendorData[0], $countsData] ;
        
    }

    public function reset_period()
    {
        $session = session();

        if($session->has('performance_start_date'))
        {
            $session->remove('performance_start_date'); 
            $session->remove('performance_end_date'); 
        }

        return redirect()->to('as9100/performance-charts');
    }

}