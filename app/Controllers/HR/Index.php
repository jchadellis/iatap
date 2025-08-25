<?php 

namespace App\Controllers\HR;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{

    private $cards = [
        [
            'name' => "Employee Emgergency Contact Manager", 
            'description' =>  'Update Employee Emergency Contact Info',
            'url' => 'hr/employee/management', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/users-icon',
            'color' => 'text-dark', 
        ],
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
				['name' => 'Human Resources', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Human Resources', 
            'content' => view('hr/index', ['cards' => $this->cards]),
            'js' => view('hr/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}