<?php 

namespace App\Controllers\Purchasing\Tools\Bookings;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 
use App\Models\PurchaseOrdersModel; 

class Index extends BaseController
{

    public function __construct()
    {
        $this->model = new PurchaseOrdersModel();
        $this->remote = new SqlbaseModel(); 
        $this->validation   = \Config\Services::validation();
    }

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
        $buyersResult = $this->model->select('buyer')->distinct()->findAll();

        $buyers = [];

        foreach($buyersResult as $buyer)
        {
            $buyers[] = $buyer->buyer; 
        }

        sort($buyers); 

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'Tools', 'is_active' => false, 'url' => 'purchasing/tools'],
				['name' => 'Bookings', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'PO - Bookings', 
            'content' => view('purchasing/tools/bookings/index'),
            'js' => view('purchasing/tools/bookings/index.js.php', ['buyers' => $buyers ]), 
        ];

        return view('template/index-full', $data); 
    }


    public function get_data($percentage = 'all')
    {
        $model = $this->model;
        
        // Pre-calculate common dates
        $today = date('Y-m-d');
        $thirtyDays = date('Y-m-d', strtotime('+30 days'));
        $seventyFiveDays = date('Y-m-d', strtotime('+75 days'));
        $oneHundredTwentyDays = date('Y-m-d', strtotime('+120 days'));
        
        switch($percentage) {
            case 'all':
                $model->orderBy('desired_recv_date', 'asc');
                break;
                
            case '-30':
                $model
                    ->where('true_promise <', $thirtyDays)
                    ->whereIn('percentage_complete', [90, 100]);
                break;
                
            case '30-75':
                $model
                    ->where('true_promise >=', $thirtyDays)
                    ->where('true_promise <=', $seventyFiveDays)
                    ->whereIn('percentage_complete', [25, 50, 90]);
                $this->addVendorUpdateConditions($model, $today, $thirtyDays);
                break;
                
            case '75-120':
                $model
                    ->where('true_promise >', $seventyFiveDays)
                    ->where('true_promise <=', $oneHundredTwentyDays)
                    ->whereIn('percentage_complete', [25, 50]);
                $this->addVendorUpdateConditions($model, $today, $thirtyDays);
                break;
                
            case '120':
                $model
                    ->where('true_promise >', $oneHundredTwentyDays)
                    ->whereIn('percentage_complete', [25]);
                $this->addVendorUpdateConditions($model, $today, $thirtyDays);
                break;
        }
        
        $data = $model->findAll();
        
        if($data) {
            return $this->response->setJSON([
                'data' => $data,
                'message' => 'Data fetched successfully',
                'success' => true,
            ]);
        }
    }

    /**
     * Add vendor update conditions to the model
     */
    private function addVendorUpdateConditions($model, $today, $thirtyDays)
    {
        $model->groupStart()
            ->where('next_vendor_update_at >=', $today)
            ->where('next_vendor_update_at <=', $thirtyDays)
            ->orWhere('next_vendor_update_at', null)
        ->groupEnd();
    }

    public function review_email()
    {
        $postData = $this->request->getPost();

        $data = []; 
        foreach( $postData['items'] as $key => $value )
        {
            $vendor = $value['vendor_id'];
            $po = $value['po_id'];
            $data[] = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor/$po"); 
        }

        return  $this->response->setJSON(
                [
                    'success' => true, 
                    'message' => 'Retrieved POs', 
                    'html' => view('purchasing/tools/bookings/email-body-review', ['data' => $data ]),
                ]
            );
    }

    public function send_email()
    {
        $postData = $this->request->getPost();

        $email_from = $postData['from']; 

        $email = \Config\Services::email();
        $email->setFrom($email_from);

        $email_to = $postData['to'] ?? '';
        //$email_address = 'jeremy.ellis@atap.com'; // override for now

        // Validate email
        $rules = [
            'to_email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'The recipient email address is required.',
                    'valid_email' => 'The recipient email address must be valid.'
                ]
            ],
            'from_email' => [
                'rules' => 'required|valid_email', 
                'errors' => [
                    'required' => 'The from email address is required.',
                    'valid_email' => 'The from email address must be valid.'
                ]
            ]
        ];
        if (! $this->validation->setRules($rules)->run(['to_email' => $email_to, 'from_email' => $email_from ])) {

            $errors = $this->validation->getErrors() ; 
            $message = ''; 

            foreach($errors as $field => $error )
            {
                $message .= "{$error}</br>";
            }

            return $this->response->setJSON([
                'success' => false,
                'title' => 'Error', 
                'message' => $message,
                //'errors'  => $this->validation->getErrors()
            ]);
        }

        $data = []; 
        foreach( $postData['items'] as $key => $value )
        {
            $vendor = $value['vendor_id'];
            $po = $value['po_id'];
            $data[] = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor/$po"); 
        }

        $subject = 'ATAP, Inc. - Purchase Order Confirmation Update Request';

        $email->setTo($email_to);
        $email->setCC('jeremy.ellis@atap.com');
        $email->setSubject($subject);
        $email->setMessage(view('purchasing/tools/bookings/email-body-send', ['data' => $data, 'start_message' => $postData['start-message'], 'end_message' => $postData['end-message']]));
        $email->setMailType('html');

        if (!$email->send()) {
            log_message('error', 'Email Failed: ' . $email->printDebugger(['headers']));
            return $this->response->setJSON(['success' => false, 'title' => 'Error', 'message' => 'There was an error with send the email message. Please refresh the page and try again']);
        }

        return $this->response->setJSON(
            [
                'success' => true, 
                'title' => 'Success',
                'message' => 'Email has been successfully sent to the recipient.'
            ]
        );

    }


}