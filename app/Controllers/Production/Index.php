<?php

namespace App\Controllers\Production;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class Index extends BaseController
{
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Production', 'is_active' => true, 'url' => '#'],
        ];

        $tool_cards = [
            [
                'name' => 'Open Work Orders', 
                'description' => 'Review All Currently Open Work Orders, Categorized According to the Department Responsible for Their Completion', 
                'url' => 'workorders/36', 
                'btn_text' => 'View Workorders', 
                'icon' => 'components/icon/cloud-icon',
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
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
            ],

        ];

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Production', 'content' => view('production/index', ['tool_cards' => $tool_cards]), 'js' => '' ];
        return view('template/index', $this->data);
    }


    
}
