<?php 

namespace App\Controllers\Vendors\Performance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect('visual_cache');
        $this->data = $this->db->query("SELECT * FROM vendor_cache")->getResult(); 
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Puchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Vendor Tools',  'is_active' => false, 'url' => '/vendors/tools'],
            ['name' => 'Performance',  'is_active' => true, 'url' => '#'],
        ];

        $data = $this->data; 
        $content = view('vendors/performance/index', ['data' => $data ]); 
        $js = view('vendors/performance/index.js.php'); 

        return view('template/index', ['content' => $content, 'title' => 'Vendor Performance', 'js' => $js , 'breadcrumbs' => $breadcrumbs]);
    }

    public function get_data()
    {
        foreach($this->data as $row)
        {
            //Convert date strings to date objects
            $row->open_date = new \DateTime($row->open_date); 
            $row->modify_date = new \DateTime($row->modify_date); 
        }

        return $this->response->setJSON(['data' => $this->data]); 
    }

    public function get_vendor()
    {
        $remote = new SqlbaseModel(); 
        $data = $this->request->getPost(); 
        $db = db_connect('visual_cache'); 
        $builder = $db->table('vendor_cache'); 

        $vendor = $builder->where("id", $data['id'] )->get()->getResult();

        $vendor = $vendor[0]; 

        $url = "http://vatap/mvc/public/api/getallvendorpurchaseorders/{$vendor->vendor_id}"; 
        try{
             $vendor->pos = $remote->getData($url); 
        }catch(Exception $e){
            return $this->response->setJSON([
                'data' => $url, 
                'success' => false, 
                'icon' => 'warning', 
                'message' => $e->getMessage(), 
            ]);      
        }

        return $this->response->setJSON([
            'data' => view('vendors/performance/modal', ['data' => $vendor ]), 
            'success' => true, 
            'icon' => 'success', 
            'message' => 'Successfully retrieved vendor details', 
        ]);
    }

    public function send_email()
    {
        $file = $this->request->getFile('file'); 

        $data = $this->request->getPost();

        $validation = service('validation');

        $rules = [
            'email_from' => [
                'label' => 'Email From', 
                'rules' => 'required|valid_email', 
                'errors' => [
                    'required' => 'A <strong>{field}</strong> address is required.',
                    'valid_email' => 'The <strong>{field}</strong> must be a valid email address', 
                ],
            ],
            'email_to' => [
                'label' => 'Email To', 
                'rules' => 'required|valid_email', 
                'errors' => [
                    'required' => 'A <strong>{field}</strong> address is required', 
                    'valid_email' => 'The <strong>{field}</strong> must be a valid email address',
                ]
            ],
            'subject' => [
                'label' => 'Email Subject', 
                'rules' => 'required', 
                'errors' => [
                    'required' => 'The <strong>{field}</strong> is required', 
                ]
            ],
            'message' => [
                'label' => 'Email Message', 
                'rules' => 'required', 
                'errors' => [
                    'required' => 'The <strong>{field}</strong> is required', 
                ]
            ],
            'file' => [
                'label' => 'Purchase Order', 
                'rules' => [
                    //'uploaded[file]',
                    'ext_in[file,pdf]',
                    'mime_in[file,application/pdf]',
                ],
                'errors' => [
                    'uploaded' => 'Please select a file to attach before sending your email.',
                    'ext_in' => 'Only PDF files are allowed as attachments.',
                    'mime_in' => 'Attachments must be in PDF format.',
                ],
            ]

        ];

        $validation->setRules($rules); 

        if(!$validation->run($data))
        {
            $errors = $validation->getErrors(); 

            $message = '<ul class="list-group">'; 

            foreach($errors as $key => $value)
            {
                $message .= '<li class="list-group-item">' . $value . '</li>'; 
            }

            $message .= '</ul>';

            return $this->response->setJSON([
                'success' => false, 
                'title' => 'Warning!', 
                'icon' => 'warning',
                'message' => $message,
            ]);
        }

        if(!$file->isValid())
        {
            return $this->response->setJSON([
                'success' => false, 
                'title' => 'Error', 
                'icon' => 'warning', 
                'message' => 'The file is not a vaild file.', 
            ]);
        }

        $fileName = $file->getName(); 
        $filePath = $file->store('', $fileName); 

        $email = service('email'); 
        $email->setFrom($data['email_from']); 
        $email->setTo($data['email_to']); 
        $email->setSubject($data['subject'] . $data['purchase_order']); 
        $email->setMessage($data['message']); 

        $email->attach(WRITEPATH.'uploads/'.$filePath); 

        if($email->send())
        {
            return $this->response->setJSON([
                'success' => true, 
                'data' => $data, 
                'title' => 'Success', 
                'icon' => 'success', 
                'message' => 'The vendor was successfully emailed', 
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false, 
            'title' => 'Error', 
            'icon' => 'warning', 
            'message' => 'There was an error sending the email!', 
        ]);
        
    }
}