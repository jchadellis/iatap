<?php 

namespace App\Controllers\HR\Employee\Management;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EmployeeModel; 

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

    private $relationships = [
        'Spouse' => 'Spouse' , 
        'Girlfriend' => 'Girlfriend', 
        'Boyfriend' => 'Boyriend' ,
        'Mother' => 'Mother', 
        'Father' => 'Father', 
        'Daughter'=> 'Daughter', 
        'Son' => 'Son', 
        'Sister' => 'Sister', 
        'Brother' => 'Brother', 
        'Grandson'  => 'Grandson',
        'Granddaugter' => 'Granddaugter',
        'Friend'        => 'Friend', 
        'Not Listed' => 'Not Listed', 
    ];

    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'HR', 'is_active' => false, 'url' => 'hr'],
				['name' => 'Emergencey Contact Manager', 'is_active' => true, 'url' => '#'],
            ],
            'title' => 'Employee Management', 
            'content' => view('hr/employee/management/index'),
            'js' => view('hr/employee/management/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $model = new EmployeeModel();

        $data = $model->findAll(); 

        return $this->response->setJSON(
            [
                'success' => true, 
                'data' => $data, 
                'message' => "Retrived All Employees", 
            ]
        );
    }

    public function get_employee()
    {
        $model = new EmployeeModel();

        $post = $this->request->getPost();

        $employee = $model->find($post['id']);

        return $this->response->setJSON(
            [
                'success' => true, 
                'data' => view('hr/employee/management/modal', ['employee' => $employee, 'relationships' => $this->relationships ]), 
                'message' => 'Some Message', 
            ]
        );
    }

    public function save_employee()
    {
        $model = new EmployeeModel(); 
        
        $post = $this->request->getPost(); 

        $post['contact_2'] = ucwords(strtolower($post['contact_2']));
        $post['contact_3'] = ucwords(strtolower($post['contact_3']));

        $employee = $model->find($post['id']); 
        if( $model->save($post) )
        {
            return $this->response->setJSON(
                [
                    'success' => true, 
                    'message' => "The emergency contact information for {$employee->first_name} {$employee->last_name} was saved.",
                    'data' => $employee,
                ]
            );
        }else{
            return $this->response->setJSON(
                [
                    'success' => false, 
                    'message' => "There was an error while saving the contact information for {$employee->first_name} {$employee->last_name}. Please verify the information was correct and try again."
                ]
            );
        }
    }
}