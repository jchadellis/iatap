<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\VendorPerformanceModel; 
use App\Models\SqlbaseModel; 
use App\Models\PurchaseOrdersModel; 

class Index extends BaseController
{
    public function __construct()
    {
        $this->model = new VendorPerformanceModel(); 
        $this->remote = new SqlbaseModel(); 
        $this->po_model = new PurchaseOrdersModel(); 
        $this->validation = \Config\Services::validation();

        $this->data = $this->remote->getData("http://vatap/mvc/public/api/getvendors/0/0");
    }
    public function index()
    {

        foreach($this->data as $row)
        {
            $row->open_date = new \DateTime($row->open_date); 
            $row->modify_date = new \DateTime($row->modify_date); 
        }

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Puchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Vendors',  'is_active' => true, 'url' => '#']
        ];

        $content = view('vendors/index', ['data' => $this->data]); 
        $js = view('vendors/index.js.php'); 

        return view('template/index', ['content' => $content, 'title' => 'Vendors', 'js' => $js , 'breadcrumbs' => $breadcrumbs]);
    }

    public function get_data()
    {
        $data = $this->remote->getData("http://vatap/mvc/public/api/getvendors/0/0"); 
        return $this->response->setJSON(['data' => $data] ); 
    }
    // public function get_performance($vendor_id)
    // {
    //     $model = new SqlbaseModel(); 

    //     $data = $model->getData("http://vatap/mvc/public/api/getvendorperformance/$vendor_id");
      
    //     if( count($data) >= 1) 
    //     {
    //         return view('vendors/progress', ['data' => $data[0]]);
    //     }
        
    //     return view('vendors/no-data', ['vendor' => $vendor_id ]); 
    // }


    public function get_performance($vendor_id)
    {
        return view('vendors/index_vendor_modal'); 
    }

    public function email_confirmation()
    {
        $get = (object ) $this->request->getGet(); 

        $email = \Config\Services::email();

        $email->setFrom('jeremy.ellis@atap.com'); 

        $data = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$get->vendor_id/$get->purchase_order_id"); 

        $email_address = ($get->email_to) ? $get->email_to : ''; 
        $email_address = 'jeremy.ellis@atap.com'; 

        $rules = [
            'email' => 'required|valid_email'
        ];
        
        $validation_data = ['email' => $email_address];
        
        if (!$this->validation->setRules($rules)->run($validation_data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email could not be sent. The recipient\'s email address appears to be invalid. Please verify the address and try again.',
                'errors'  => $this->validation->getErrors()
            ]);
        }

        $data[0]->true_promise = $get->promise_date; 

        $data[0]->todays_date = date('m-d-Y');

        $email->setTo($email_address);

        $email->setSubject('ATAP, Inc. - Purchase Order Update Request'); 

        $email->setMessage(view('vendors/email_confirmation_body', ['data' => $data[0]]));

        $email->setMailType('html'); 


        if( ! $email->send())
        {
            log_message('error', 'Email Failed: ' . $email->printDebugger(['headers']));
            return $this->response->setJSON(['success' => false, 'message' => 'Email Failed']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Email has been successfully sent to the recipient.']);

    }

    public function email_delivery_update()
    {
        $get = (object ) $this->request->getGet(); 

        $email = \Config\Services::email();

        $email->setFrom('jeremy.ellis@atap.com'); 

        $data = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$get->vendor_id/$get->purchase_order_id"); 

        $email_address = ($get->email_to) ? $get->email_to : ''; 
        $email_address = 'jeremy.ellis@atap.com'; 

        $rules = [
            'email' => 'required|valid_email'
        ];
        
        $validation_data = ['email' => $email_address];
        
        if (!$this->validation->setRules($rules)->run($validation_data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email could not be sent. The recipient\'s email address appears to be invalid. Please verify the address and try again.',
                'errors'  => $this->validation->getErrors()
            ]);
        }

        $data[0]->true_promise = $get->promise_date; 

        $data[0]->todays_date = date('m-d-Y');

        $email->setTo($email_address);

        $email->setSubject('ATAP, Inc. - Purchase Order Delivery Update Request'); 

        $email->setMessage(view('vendors/email_delivery_update_body', ['data' => $data[0]]));

        $email->setMailType('html'); 

        if( ! $email->send())
        {
            log_message('error', 'Email Failed: ' . $email->printDebugger(['headers']));
            return $this->response->setJSON(['success' => false, 'message' => 'Email Failed']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Email has been successfully sent to the recipient.']);

    }
}
