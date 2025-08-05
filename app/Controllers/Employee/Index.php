<?php

namespace App\Controllers\Employee;

use App\Controllers\BaseController; 
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    public function __construct()
    {
        $this->employeeModel = new SqlbaseModel(); 
    }

    protected $forms = [
        [
            'name'  => 'Sick / Leave Request', 
            'url'   => 'employee/leave/request',
            'btn_text' => 'Open', 
            'icon' => 'components/icon/form-icon',
            'color' => 'text-dark',  
        ],
        [
            'name' => 'APRA Sick Leave',
            'url' =>  'assets/documents/employee/arpa.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => '401K Change Form', 
            'url' => 'assets/documents/employee/401k-form.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark', 
        ]
    ];

    protected $documents = [
        [
            'name' => 'Quality Policy', 
            'url' => 'assets/documents/employee/qa-policy.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
        ],
        [
            'name' => 'Health Plan', 
            'url' => 'assets/documents/employee/bcbs-health-plan-2025.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
        ],
        [
            'name' => 'Dental Plan', 
            'url'  => 'assets/documents/employee/bcbs-dental-plan-2025.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',   
        ],
        [
            'name'  => 'ACA Q&A',  
            'url'   => 'assets/documents/employee/1095-questions.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',   
        ],
        [
            'name'  => 'Employee Handbook',
            'url'   => 'assets/documents/employee/employee-handbook.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
        ],
        [
            'name'  => 'Hoilday Schedule', 
            'url'   => 'assets/documents/employee/holidays.pdf', 
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',   
        ],
        [
            'name'  => 'SCA Wage Determination', 
            'url'   => 'assets/documents/employee/sca_wage.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',   
        ],
        [
            'name'  => 'Emergency Contact List', 
            'url'   => 'assets/documents/employee/emergency-list.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
        ]
    ];

    protected $resources = [
        [
            'name' => 'Employee Training Records', 
            'url'   => 'employee/training', 
            'btn_text' => 'Open', 
            'icon' => 'components/icon/globe-icon',
            'color' => 'text-dark',  
        ]
    ];

    public function index(): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Employee Resources', 'is_active' => true, 'url' => '#'],
        ];
        
       $data = [
            'title' => 'Employee Resoures', 
            'breadcrumbs' => $breadcrumbs, 
            'site_name' => 'iATAP', 
            'js' => view('employee/js'),
            'forms' => $this->forms,
            'documents' => $this->documents, 
            'resources' => $this->resources,
        ];
       $data['content'] = view('employee/index', $data); 
       return view('template/index', $data);
    }

    public function list()
    {
        $employees = $this->employeeModel->getData('http://vatap/mvc/public/api/getemployees/'); 
        return $employees; 
    }
}
