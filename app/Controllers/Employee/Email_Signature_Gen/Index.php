<?php 

namespace App\Controllers\Employee\Email_Signature_Gen;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{


    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $page_data = []; 
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Employee', 'is_active' => false, 'url' => 'employee'],
				['name' => 'Email Signature Generator', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Email Signature Generator', 
            'content' => view('employee/email-signature-gen/index',[ 'data' => $page_data ]),
            'js' => view('employee/email-signature-gen/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}