<?php

namespace App\Controllers\Production;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class Index extends BaseController
{
    private $tool_cards = [];

    private $groups = ['production'];

    private $secured_cards = [
        [
            'name' => 'Open Work Orders', 
            'description' => 'Review All Currently Open Work Orders, Categorized According to the Department Responsible for Their Completion', 
            'url' => 'workorders/36', 
            'btn_text' => 'View Workorders', 
            'icon' => 'components/icon/briefcase',
            'color' => 'text-dark', 
        ],
        [
            'name' => "Work Request Manager", 
            'description' =>  'View, edit and close Internal Work Request',
            'url' => 'purchasing/work-request', 
            'btn_text' => 'View Request', 
            'icon' => 'components/icon/inbox-arrow-down-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'Truck Spreadsheets', 
            'description' => 'View Rampmaster 5K, 7K and Hydrant Trucks speadsheets, Request parts', 
            'url' => 'production/spreadsheets', 
            'btn_text' => 'View Spreadsheets', 
            'icon' => 'components/icon/truck-icon',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'Production Schedule', 
            'description' => 'View Production Schedule, by department and / or launch shop view.', 
            'url' => 'production/schedule', 
            'btn_text' => 'View Schedule', 
            'icon' => 'components/icon/calendar-dots',
            'color' => 'text-dark', 
        ],
        [
            'name' => 'Paint Requirement / Operations', 
            'description' => 'List of Paint operations with requirements not complete but has stock', 
            'url' => 'production/requirements/paint', 
            'btn_text' => 'View List', 
            'icon' => 'components/icon/clipboard-document-icon',
            'color' => 'text-dark', 
        ],
    ];

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Production', 'is_active' => true, 'url' => '#'],
        ];

        $this->data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'Production', 
            'content' => view('template/dept-index', [
                'secured_cards' => $this->secured_cards, 
                'groups' => $this->groups,
                'tool_cards' => $this->tool_cards,
                'user' => auth()->user(),
                'title' => 'Production',
            ]), 
            'js' => '' 
        ];
        return view('template/index', $this->data);
    }


    
}
