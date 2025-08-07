<?php 

namespace App\Controllers\Purchasing\PO_Tools\Bookings;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 
use App\Models\PurchaseOrdersModel; 

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

    public function index()
    { 
        
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'PO Tools', 'is_active' => false, 'url' => 'purchasing/po-tools'],
				['name' => 'Bookings', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'PO - Bookings', 
            'content' => view('purchasing/po_tools/bookings/index'),
            'js' => view('purchasing/po_tools/bookings/index.js.php'), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data($percentage = 'all')
    {
        $model = new PurchaseOrdersModel();

        if($percentage == 'all')
        {
            $model->orderBy('desired_recv_date', 'asc'); 
        }elseif($percentage == '-30'){
            $model
                ->where('true_promise <', date('Y-m-d', strtotime('+30 days')))
                ->whereIn('percentage_complete', [90, 100]); 
        }elseif($percentage == '30-75'){
            $model
                ->where('true_promise >=', date('Y-m-d', strtotime('+30 days')))
                ->where('true_promise <=', date('Y-m-d', strtotime('+75 days')))
                ->groupStart()
                    ->where('next_vendor_update_at >=', date('Y-m-d'))
                    ->where('next_vendor_update_at <=', date('Y-m-d', strtotime('+30 days')))
                    ->orWhere('next_vendor_update_at', null)
                ->groupEnd()
                ->whereIn('percentage_complete', [25, 50, 90]);

        }elseif( $percentage == '75-120' ){
            $model
                ->where('true_promise >', date('Y-m-d', strtotime('+75 days')))
                ->where('true_promise <=', date('Y-m-d', strtotime('+120 days')))                
                ->groupStart()
                    ->where('next_vendor_update_at >=', date('Y-m-d'))
                    ->where('next_vendor_update_at <=', date('Y-m-d', strtotime('+30 days')))
                    ->orWhere('next_vendor_update_at', null)
                ->groupEnd()
                ->whereIn('percentage_complete', [25,50]); 
        }elseif($percentage == '120') {
            $model
                ->where('true_promise >', date('Y-m-d', strtotime('+120 days')))
                ->groupStart()
                    ->where('next_vendor_update_at >=', date('Y-m-d'))
                    ->where('next_vendor_update_at <=', date('Y-m-d', strtotime('+30 days')))
                    ->orWhere('next_vendor_update_at', null)
                ->groupEnd()
                ->whereIn('percentage_complete', [25]);
        }

        $data = $model->findAll(); 

        if($data){
            return $this->response->setJSON([
                'data' => $data, 
                'message' => 'Data fetched successfully', 
                'success' => true, 
            ]);
        }
        
    }
}