<?php 

namespace App\Controllers\AS9100\Performance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 
use App\Models\ServiceTicketModel; 

class Index extends BaseController
{



    public function index()
    {

        $chart_data = $this->get_data(); 

        $top_chart_data = (array) $chart_data['counts'][0]->data;

        $top_cards = [
            [
                'title' => 'Shipments', 
                'counts' => $top_chart_data[0], 
                'id' => 'shipment-count', 
                'icon' => 'bi bi-truck', 
                'color' => 'primary',
                'date_range' => 'Past 90 Days',
                'url' => base_url('shipping/performance'), 
            ],
            [
                'title' => 'RMAs', 
                'counts' => $top_chart_data[1], 
                'id' => 'rma-count', 
                'icon' => 'bi bi-arrow-return-left', 
                'date_range' => 'Past 90 Days',
                'color' => 'warning',
                'url' => base_url('shipping/rmas'), 
            ],
            [
                'title' => 'NCPs', 
                'counts' => $top_chart_data[2], 
                'id' => 'ncp-count', 
                'icon' => 'bi  bi-exclamation-circle', 
                'date_range' => 'Past 90 Days',
                'color' => 'danger',
                'url' => base_url('quality/ncp'), 
            ],
            [
                'title' => 'Internal Audits', 
                'counts' => $top_chart_data[3], 
                'id' => 'audit-count', 
                'icon' => 'bi bi-flag', 
                'date_range' => 'Past 90 Days',
                'color' => 'success',
                'url' => base_url('quality/internal-audit'), 
            ],
        ];

        $chart_cards = [
            [
                'title' => 'Sales Performance',
                'chart_id' => 'sales-chart', 
                'color' => 'primary', 
                'date_range' => 'Past 90 Days',
                'report_url' => base_url('sales/performance'),
                'download_url' => base_url('sales/performance/spreadsheet'),
                'print_url' => '#!', 
            ],
            [
                'title' => 'Engineering Performance',
                'chart_id' => 'engineering-chart', 
                'color' => 'indigo', 
                'date_range' => 'Past 90 Days',
                'report_url' => base_url('service/tickets/engineering'),
                'download_url' => base_url('service/tickets/spreadsheet/engineering'),
                'print_url' => '#!', 
            ],
            [
                'title' => 'Vendor Performance',
                'chart_id' => 'vendor-chart', 
                'color' => 'success', 
                'date_range' => 'Past 90 Days',
                'report_url' => base_url('vendors/performance'),
                'download_url' => base_url('vendors/performance/spreadsheet'),
                'print_url' => '#!', 
            ],
        ];

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'AS9100', 'is_active' => false, 'url' => 'as9100'],
				['name' => 'Performance & Compliance', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Performance & Compliance', 
            'content' => view('as9100/performance/index',['data' => $chart_data , 'top_cards' => $top_cards, 'chart_cards' => $chart_cards]),
           'js' => view('as9100/performance/index.js.php'), 
        ];
        return view('template/index', $data); 
    }

    public function get_data()
    {

        $session = session(); 
        $performanceModel = new ServiceTicketModel(); 
        $model = new SqlbaseModel(); 

        $start = (new \DateTime())->modify('-90 days')->format('Y-m-d') ;
        $end = (new \DateTime())->format('Y-m-d');
        
        $salesUrl = "http://vatap/mvc/public/api/getsalesperformance/1"; 
        $vendorUrl = "http://vatap/mvc/public/api/vendor_performance/1";
        $countsUrl = "http://vatap/mvc/public/api/get_counts/";

        $session->setTempdata('performance_start_date', $start);
        $session->setTempdata('performance_end_date', $end); 

        $engineeringData = $performanceModel->getPerformance('engineering', $start, $end, true);

        if( $this->request->getMethod() === 'POST')
        {
            $post = $this->request->getJSON(); 

            $dates = explode(' to ', $post->date_range); 

            $start = $dates[0];
            $end = $dates[1];

            $session->setTempdata('performance_start_date', $start);
            $session->setTempdata('performance_end_date', $end); 

            $salesUrl = "http://vatap/mvc/public/api/getsalesperformance/1/{$start}/{$end}";
            $vendorUrl = "http://vatap/mvc/public/api/vendor_performance/1/{$start}/{$end}";
            $countsUrl = "http://vatap/mvc/public/api/get_counts/{$start}/{$end}";
            $engineeringData = $performanceModel->getPerformance('engineering', $start, $end, true);

            try {
                 $salesData = $model->getData($salesUrl);
            } catch(\Exception $e){
                $message = 'Please check the date range there was not result for this range';  
                return $this->response->setJSON([
                    'success' => false, 
                    'icon' => 'warning', 
                    'title' => 'Error', 
                    'html' => "<p>{$message}</p>", 
                ]);
            }

            try {
                 $vendorData = $model->getData($vendorUrl);
            } catch(\Exception $e){
                $message = 'Please check the date range there was not result for this range'; 
                return $this->response->setJSON([
                    'success' => false, 
                    'icon' => 'warning', 
                    'title' => 'Error', 
                    'html' => "<p>{$message}</p>", 
                ]);
            }

            try {
                 $countsData = $model->getData($countsUrl);
            } catch(\Exception $e){
                $message = 'Please check the date range there was not result for this range'; 
                return $this->response->setJSON([
                    'success' => false, 
                    'icon' => 'warning', 
                    'title' => 'Error', 
                    'html' => "<p>{$message}</p>", 
                ]);
            }
                
            $start = (new \DateTime($start))->format('m-d-Y'); 
            $end = (new \DateTime($end))->format('m-d-Y'); 
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => [ 'charts' => [ $salesData[0], $engineeringData, $vendorData[0] ], 'counts' => (array)[ $countsData[0] ], 'date_range' => "{$start} / {$end}" ], 
                    'title' => 'Success', 
                    'html' => '<p>Retrieve Data</p>',
                    'icon' => 'success',
            ]);
        }

        $salesData = $model->getData($salesUrl); 
        $vendorData = $model->getData($vendorUrl); 
        $countsData = $model->getData($countsUrl);
     
        return ['charts' => [$salesData[0], $engineeringData, $vendorData[0]], 'counts' => (array)[ $countsData[0] ]] ;
        
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