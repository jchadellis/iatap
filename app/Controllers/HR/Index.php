<?php 

namespace App\Controllers\HR;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{

    private $secured_cards = [
        [
            'name' => "Employee Emergency Contact Manager", 
            'description' =>  'Update Employee Emergency Contact Info',
            'url' => 'hr/employee/management', 
            'btn_text' => 'View', 
            'icon' => 'components/icon/users-icon',
            'color' => 'text-dark', 
        ],
    ];

    private $tool_cards = [

    ];

    private $groups = [
        'hr'
    ];

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Human Resources', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Human Resources', 
            'content' => view('template/dept-index', [
                'tool_cards' => $this->tool_cards, 
                'secured_cards' => $this->secured_cards , 
                'groups' => $this->groups,
                'title' => 'Human Resources', 
                'user' => auth()->user() ?? null, 
            ]),
            'js' => view('hr/index.js.php'), 
        ];

        return view('template/index', $data); 
    }
}