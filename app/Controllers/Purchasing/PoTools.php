<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 
use App\Models\PurchaseOrdersModel; 

class PoTools extends BaseController
{

    public function __construct()
    {
        $this->remote = new SqlbaseModel(); 
        $this->po_model = new PurchaseOrdersModel(); 
    }

    public function index()
    {   

        $cards = [
            [
                'name' => "Purchase Order Bookings", 
                'description' =>  'View / Update PO status',
                'url' => 'purchasing/po-tools/bookings', 
                'btn_text' => 'View', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Purchase Order Confirmations", 
                'description' =>  'View Confirmation',
                'url' => 'purchasing/po-tools/confirmations', 
                'btn_text' => 'View', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Purchase Counts", 
                'description' =>  'View Confirmation',
                'url' => '#', 
                'btn_text' => 'View', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
                'btn-data' => 'data-bs-toggle="modal" data-bs-target="#po_count_modal"',
            ],
        ];
        $date = (new \DateTime())->format('Y-m-d'); 
        $data = $this->remote->getData("http://vatap/mvc/public/api/getpocounts/$date/0"); 

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'PO Tools', 'is_active' => true, 'url' => '#'],
        ];
        $js = view('purchase/po-tools/index.js.php'); 

        $data = ['content' => view('purchase/po-tools/index', ['data' => $data[0], 'cards' => $cards]), 'breadcrumbs' => $breadcrumbs, 'js' => $js, 'title' => 'Purchase Order Tools'];
        return view('template/index', $data); 
    }

    public function bookings()
    {

        $purchaseOrders = new PurchaseOrdersModel();

        $data = $purchaseOrders->where('is_late', 't')->orderBy('desired_recv_date', 'asc')->findAll();  

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Puchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'PO Tools',  'is_active' => false, 'url' => 'purchasing/po-tools'],
            ['name' => 'Bookings',  'is_active' => true, 'url' => '#']
        ];
        $content = view('purchase/po-tools/po-bookings', ['data' => $data ]);
        $js = view('purchase/po-tools/po-bookings.js.php'); 
        $data = ['content' => $content , 'breadcrumbs' => $breadcrumbs, 'js' => $js, 'title' => 'PO - Bookings'];
        return view('template/index-full', $data); 
    }

    public function confirmations()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Puchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'PO Tools',  'is_active' => false, 'url' => 'purchasing/po-tools'],
            ['name' => 'Confirmations',  'is_active' => true, 'url' => '#']
        ];

        $data = $this->remote->getData("http://vatap/mvc/public/api/getpurchaseorderconfirmations/"); 

        foreach($data as $row)
        {
            $row->true_promise = new \DateTime($row->true_promise); 
        }

        $content = view('purchase/po-tools/po-confirmations', ['data' => $data]);
        $js = view('purchase/po-tools/po-confirmations.js.php'); 
        $data = ['content' => $content , 'breadcrumbs' => $breadcrumbs, 'js' => $js, 'title' => 'PO - Confirmations' ];
        return view('template/index-full', $data); 
    }

    public function counts()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Puchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'PO Tools',  'is_active' => false, 'url' => 'purchasing/po-tools'],
            ['name' => 'Counts',  'is_active' => true, 'url' => '#']
        ];

        $data = ['content' => '' , 'breadcrumbs' => $breadcrumbs, 'js' => '', 'title' => 'PO - Bookings'];
        return view('template/index', $data); 
    }

    public function update_po_status($id, $percentage = null)
    {

        $purchaseOrders = new PurchaseOrdersModel();

        $po = $purchaseOrders->find($id); 

        if( $percentage === 25 )
        {
            $next_update = $po->followup_50_target_date->format('Y-m-d H:i:s'); 
        } elseif( $percentage == 50 ) {
            $next_update = $po->followup_80_target_date->format('Y-m-d H:i:s'); 
        } elseif( $percentage == 80 ) {
            $next_update = $po->followup_90_target_date->format('Y-m-d H:i:s');
        } elseif( $percentage == 90){
            $next_update = null; 
        }

        if( $percentage)
        {
            $array = [
                'id' => $id, 
                "followup_{$percentage}_updated_at" => (new \DateTime())->format('Y-m-d H:i:s'),
                "last_vendor_update_at" => (new \DateTime())->format('Y-m-d H:i:s'), 
                "next_vendor_update_at" => $next_update,
            ];
           if( $purchaseOrders->save($array) )
           {    
            echo $purchaseOrders->db->getLastQuery();
                return $this->response->setJSON(['success' => true]);
           } else {
                return $this->response->setJSON(['success' => false, 'errors' => $purchaseOrders->errors() ]); 
           }
        }
    }

    public function po_booking_review($vendor_id, $purchase_order, $promise_date = null )
    {
        $data = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor_id/$purchase_order"); 
        $data[0]->todays_date = date('m-d-Y');

        $po = $this->po_model->find($purchase_order); 

        return view('purchase/po-tools/po-booking-review', ['data' => $data[0], 'po' => $po, 'promise_date' => $promise_date ]);
    }

    public function po_confirmation_review($vendor_id, $purchase_order, $promise_date = null )
    {

        $data = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor_id/$purchase_order"); 
        $data[0]->todays_date = date('m-d-Y');

        return view('purchase/po-tools/po-confirmation-review', ['data' => $data[0],  'promise_date' => $promise_date ]);
    }

    public function po_counts()
    {
        $date = $this->request->getGet('period'); 

        $date = ($date) ? (new \DateTime())->createFromFormat('m-d-Y', $date)->format('Y-m-d') : (new \DateTime())->format('Y-m-d'); 

        $data = $this->remote->getData("http://vatap/mvc/public/api/getpocounts/$date/0"); 

        return json_encode( $data ); 

    }

    public function get_data($percentage = 'all')
    {
        $purchaseOrders = new PurchaseOrdersModel();

        if($percentage == 'all')
        {
            $purchaseOrders->orderBy('desired_recv_date', 'asc'); 
        }elseif($percentage == '-30')
        {
            $purchaseOrders
                ->where('true_promise <', date('Y-m-d', strtotime('+30 days')))
                ->whereIn('percentage_complete', [90, 100]); 
        }elseif($percentage == '30-75'){
            $purchaseOrders
                ->where('true_promise >=', date('Y-m-d', strtotime('+30 days')))
                ->where('true_promise <=', date('Y-m-d', strtotime('+75 days')))
                ->groupStart()
                    ->where('next_vendor_update_at >=', date('Y-m-d'))
                    ->where('next_vendor_update_at <=', date('Y-m-d', strtotime('+30 days')))
                    ->orWhere('next_vendor_update_at', null)
                ->groupEnd()
                ->whereIn('percentage_complete', [25, 50, 90]);

        }elseif( $percentage == '75-120' ){
            $purchaseOrders
                ->where('true_promise >', date('Y-m-d', strtotime('+75 days')))
                ->where('true_promise <=', date('Y-m-d', strtotime('+120 days')))                
                ->groupStart()
                    ->where('next_vendor_update_at >=', date('Y-m-d'))
                    ->where('next_vendor_update_at <=', date('Y-m-d', strtotime('+30 days')))
                    ->orWhere('next_vendor_update_at', null)
                ->groupEnd()
                ->whereIn('percentage_complete', [25,50]); 
        }elseif($percentage == '120') {
            $purchaseOrders
                ->where('true_promise >', date('Y-m-d', strtotime('+120 days')))
                ->groupStart()
                    ->where('next_vendor_update_at >=', date('Y-m-d'))
                    ->where('next_vendor_update_at <=', date('Y-m-d', strtotime('+30 days')))
                    ->orWhere('next_vendor_update_at', null)
                ->groupEnd()
                ->whereIn('percentage_complete', [25]);
        }
        

        return json_encode( ['data' => $purchaseOrders->findAll()]); 
    }

}
