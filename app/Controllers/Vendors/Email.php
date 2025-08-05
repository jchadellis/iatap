<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Email extends BaseController
{
    protected $remote_model;
    protected $validation;

    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
        $this->validation   = \Config\Services::validation();
    }

    public function confirmation()
    {
        return $this->sendEmail(
            'vendors/email_confirmation_body',
            'ATAP, Inc. - Purchase Order Confirmation Update Request'
        );
    }

    public function update_delivery()
    {
        return $this->sendEmail(
            'vendors/email_delivery_update_body',
            'ATAP, Inc. - Purchase Order Delivery Update Request'
        );
    }

    protected function sendEmail(string $view, string $subject)
    {
        $get = (object) $this->request->getGet(); 

        $email = \Config\Services::email();
        $email->setFrom('jeremy.ellis@atap.com');

        $email_address = $get->email_to ?? '';
        $email_address = 'jeremy.ellis@atap.com'; // override for now

        // Validate email
        $rules = ['email' => 'required|valid_email'];
        if (! $this->validation->setRules($rules)->run(['email' => $email_address])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email could not be sent. The recipient\'s email address appears to be invalid. Please verify the address and try again.',
                'errors'  => $this->validation->getErrors()
            ]);
        }

        $data = $this->remote_model->getData("http://vatap/mvc/public/api/getvendorpurchaseorders/{$get->vendor_id}/{$get->purchase_order_id}");

        $data[0]->true_promise = $get->promise_date;
        $data[0]->todays_date  = date('m-d-Y');

        $email->setTo($email_address);
        $email->setSubject($subject);
        $email->setMessage(view($view, ['data' => $data[0]]));
        $email->setMailType('html');

        if (! $email->send()) {
            log_message('error', 'Email Failed: ' . $email->printDebugger(['headers']));
            return $this->response->setJSON(['success' => false, 'message' => 'Email Failed']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Email has been successfully sent to the recipient.']);
    }
}
