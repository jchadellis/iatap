<?php 

namespace App\Controllers\Purchasing\Tools\Confirmations;

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

    public function __construct()
    {
        $this->model = new PurchaseOrdersModel();
        $this->remote = new SqlbaseModel(); 
        $this->validation   = \Config\Services::validation();
    }

    public function index()
    {
        $buyersResult = $this->model->select('buyer')->distinct()->findAll();

        $buyers = [];

        foreach($buyersResult as $buyer)
        {
            $buyers[] = $buyer->buyer; 
        }

        sort($buyers); 

        $confirmations =  $data = $this->remote->getData("http://vatap/mvc/public/api/getpurchaseorderconfirmations/");

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'Tools', 'is_active' => false, 'url' => 'purchasing/tools'],
				['name' => 'Confirmations', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'PO - Confirmations', 
            'content' => view('purchasing/tools/confirmations/index', ['data' => $confirmations]),
            'js' => view('purchasing/tools/confirmations/index.js.php', [ 'buyers' => $buyers ]), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data()
    {
        $confirmations =  $data = $this->remote->getData("http://vatap/mvc/public/api/getpurchaseorderconfirmations/");

        print_array($confirmations); 
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
                    'html' => view('purchasing/tools/confirmations/email-body-review', ['data' => $data ]),
                ]
            );
    }

    public function send_email_back()
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
            $input = ''; 

            foreach($errors as $field => $error )
            {
                $input = $field; 
                $message .= "{$error}</br>";
            }

            return $this->response->setJSON([
                'success' => false,
                'title' => 'Error', 
                'message' => $message,
                'field'  => $field,
            ]);
        }

        $data = []; 
        foreach( $postData['items'] as $key => $value )
        {
            $vendor = $value['vendor_id'];
            $po = $value['po_id'];
            $data[] = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor/$po"); 
        }

        $subject = "ATAP, Inc. - Purchase Order:{$po} Confirmation Update Request";

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

    public function send_email()
    {
        $postData = $this->request->getPost();

        $email_from = trim($postData['from'] ?? '');
        $email_to_raw = trim($postData['to'] ?? '');

        // Normalize separators and split addresses
        $email_to_raw = str_replace(';', ',', $email_to_raw);
        $email_to_list = array_filter(array_map('trim', explode(',', $email_to_raw)));

        // Validate 'from' address
        if (empty($email_from) || !filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'success' => false,
                'title' => 'Error',
                'message' => 'The from email address is required and must be valid.'
            ]);
        }

        // Validate each 'to' address
        $invalid_emails = [];
        foreach ($email_to_list as $address) {
            if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
                $invalid_emails[] = $address;
            }
        }
        if (empty($email_to_list)) {
            return $this->response->setJSON([
                'success' => false,
                'title' => 'Error',
                'message' => 'The recipient email address is required.'
            ]);
        }
        if (!empty($invalid_emails)) {
            return $this->response->setJSON([
                'success' => false,
                'title' => 'Error',
                'message' => 'Invalid recipient email address(es): ' . implode(', ', $invalid_emails)
            ]);
        }

        $email = \Config\Services::email();
        $email->setFrom($email_from);
        $email->setTo($email_to_list);
        $email->setCC($email_from);

        $data = [];
        foreach ($postData['items'] as $value) {
            $vendor = $value['vendor_id'];
            $po = $value['po_id'];
            $data[] = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor/$po");
        }

        $subject = "ATAP, Inc. - Purchase Order: {$po} Confirmation Update Request";
        $email->setSubject($subject);
        $email->setMessage(view('purchasing/tools/bookings/email-body-send', [
            'data' => $data,
            'start_message' => $postData['start-message'],
            'end_message' => $postData['end-message']
        ]));

        $email->setMailType('html');

        if (!$email->send()) {
            log_message('error', 'Email Failed: ' . $email->printDebugger(['headers']));
            return $this->response->setJSON([
                'success' => false,
                'title' => 'Error',
                'message' => 'There was an error sending the email message. Please refresh the page and try again.'
            ]);
        }

        $today = new \DateTime(); 
        $array = [
            'id' => $po, 
            'last_emailed_on' => $today->format('Y-m-d h:i:s'),
        ];

        $this->model->save($array); 

        return $this->response->setJSON([
            'success' => true,
            'title' => 'Success',
            'message' => 'Email has been successfully sent to the recipient.'
        ]);
    }


}