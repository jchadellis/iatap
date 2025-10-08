<?php 

namespace App\Controllers\Purchasing\Tools\Bookings;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 
use App\Models\PurchaseOrdersModel; 

class Index extends BaseController
{
    private $last_email_days = 7; 

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
            'js' => view('purchasing/tools/bookings/index.js.php', ['buyers' => $buyers , 'last_email_days' => $this->last_email_days]), 
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
                $data = $model->findAll();

                foreach($data as $row)
                {
                    $row->formatted_date = $row->true_promise->format('Y-m-d');
                }
                return $this->response->setJSON([
                    'data' => $data,
                    'message' => 'Data fetched successfully',
                    'success' => true,
                ]);
                break; 
            case 'late': 
                $model->where('true_promise <=', $today);
                break;                 
            case '-30':
                $model
                    ->where('true_promise >', $today)
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
        $view_data = [];

        $today = new \DateTime();
        $today->setTime(0, 0, 0); // normalize to midnight

        foreach ($data as $row) 
        {
            $row->formatted_date = $row->true_promise->format('Y-m-d');

            $next_update = !empty($row->next_vendor_update_at) 
                ? new \DateTime($row->next_vendor_update_at) 
                : null; 

            $last_update = new \DateTime($row->last_vendor_update_at);
            $last_email = !empty($row->last_emailed_on)
                ? new \DateTime($row->last_email_on)
                : null; 

            $row->last_vendor_update_at = $last_update->format('Y-m-d');
            $row->next_vendor_update_at = $next_update ? $next_update->format('Y-m-d') : null;

            $skip = false;
            $thirty_days_future = (clone $last_update)->modify('+30 days'); 
            // --- Vendor update rules ---
            if ($next_update) {
                // Case 1: next update scheduled → skip if within 30 days
                $diff = $last_update->diff($next_update)->days;
                if ($last_update < $next_update && $diff <= 30) {
                    $skip = true;
                }
            } else {
                // Case 2: no next update → skip if last update was within 30 days of today
                $thirty_days_ago = (clone $today)->modify('-30 days');
                if ($last_update >= $thirty_days_ago) {
                    $skip = true;
                }
            }

            if($last_email)
            {
               $days_since = $last_email->diff($today);
               if( $days_since->days <= $this->last_email_days )
               {
                    $row->recently_emailed = true; 
               }
            }

            // --- Promise due rules ---
            $due_or_late = $row->true_promise <= $today;

            // --- Final inclusion ---
            if ($due_or_late || !$skip) {
                $view_data[] = $row;
            }
        }

        // print_array($view_data); 
        // return;

        if($view_data) {
            return $this->response->setJSON([
                'data' => $view_data,
                'message' => 'Data fetched successfully',
                'success' => true,
            ]);
        }
    }

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
            $selected_pos[] = $value['po_id'];
            $data[] = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor/$po");
        }

        $pos = implode(', ', $selected_pos); 

        $has_late = [];
        foreach($data as $item)
        {
            if( $item[0]->is_late)
            {
                $has_late[] = $item[0]->is_late; 
            }
        }


        $subject = "ATAP, Inc. - Purchase Order: {$pos} Update Request";
        if(!empty($has_late))
        {
            $subject = "ATAP, Inc. - Purchase Order: {$pos} Past Due Update Request";
        }
        
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
        foreach( $selected_pos as $selected){
            $array = [
                'id' => $selected, 
                'last_emailed_on' => $today->format('Y-m-d h:i:s'),
            ];
            $this->model->save($array); 
        }

        return $this->response->setJSON([
            'success' => true,
            'title' => 'Success',
            'message' => 'Email has been successfully sent to the recipient.'
        ]);
    }

    public function send_email_test()
    {
        //$postData = $this->request->getPost();

        $postData = [
            'items' => [['vendor_id' => 'AMAZON', 'po_id' => '260845'], ['vendor_id' => 'AMAZON', 'po_id' => '259933'], ['vendor_id' => 'AMAZON', 'po_id' => '261070']]
        ];

        $email_from = trim($postData['from'] ?? '');
        $email_to_raw = trim($postData['to'] ?? '');

        // Normalize separators and split addresses
        $email_to_raw = str_replace(';', ',', $email_to_raw);
        $email_to_list = array_filter(array_map('trim', explode(',', $email_to_raw)));

        // Validate 'from' address
        // if (empty($email_from) || !filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'title' => 'Error',
        //         'message' => 'The from email address is required and must be valid.'
        //     ]);
        // }

        // Validate each 'to' address
        // $invalid_emails = [];
        // foreach ($email_to_list as $address) {
        //     if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
        //         $invalid_emails[] = $address;
        //     }
        // }
        // if (empty($email_to_list)) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'title' => 'Error',
        //         'message' => 'The recipient email address is required.'
        //     ]);
        // }
        // if (!empty($invalid_emails)) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'title' => 'Error',
        //         'message' => 'Invalid recipient email address(es): ' . implode(', ', $invalid_emails)
        //     ]);
        // }

        // $email = \Config\Services::email();
        // $email->setFrom($email_from);
        // $email->setTo($email_to_list);
        // $email->setCC($email_from);

        $data = [];
        $has_late = []; 
        foreach ($postData['items'] as $value) {
            $vendor = $value['vendor_id'];
            $po = $value['po_id'];
            $pos[] = $value['po_id'];
            $data[] = $this->remote->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/$vendor/$po");
        }

        foreach($data as $item)
        {
            if( $item[0]->is_late)
            {
                $has_late[] = $item[0]->is_late; 
            }
        }

        $has_late = [];
        $pos = implode(', ', $pos); 

        $subject = "ATAP, Inc. - Purchase Order: {$pos} Update Request";
        if(!empty($has_late))
        {
            $subject = "ATAP, Inc. - Purchase Order: {$pos} Past Due Update Request";
        }

        echo $subject; 
        return;
        
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