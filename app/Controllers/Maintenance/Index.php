<?php

namespace App\Controllers\Maintenance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceTicketModel; 

class Index extends BaseController
{

    private $documents = [
        [
            'name' => 'Paint Booth Filter Procedure', 
            'url' => 'assets/documents/maintenance/paint-booth-filter-procedure.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
        ], 
        [
            'name' => 'Records and Stamping', 
            'url' => 'assets/documents/maintenance/stamp-records.pdf' ,
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
            
        ]
    ];

    private $tool_cards = [
        [
            'name' => 'Maintenace Service Request', 
            'description' => 'Submit new maintenance requests for facility issues, equipment repairs, or routine maintenance needs.',
            'btn_text' => 'Create Ticket', 
            'icon' => 'components/icon/ticket-icon',
            'url'   => 'service/tickets/maintenance',
            'color' => 'text-dark',  
        ],
        [
            'name' => 'Woodshop Request', 
            'description' => 'Request fabrication of shipping containers, display shelving, custom storage solutions, and specialized wood projects.',
            'btn_text' => 'Create Ticket', 
            'icon' => 'components/icon/ticket-icon',
            'url'   => 'service/tickets/woodshop',
            'color' => 'text-dark',  
        ]
    ];

    private $secured_cards = []; 

    private $groups = ['maintenance']; 

    public function index()
    {
        $model = new ServiceTicketModel(); 
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Maintenance', 'is_active' => true, 'url' => '#'],
        ];


        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'Maintenance Dept.', 
            'content' => view('template/dept-index', [
                'maintenanceData' => $model->getPerformance('maintenance'), 
                'maintenanceTickets' => $model->getTotalTickets(),  
                'woodshopData' => $model->getPerformance('woodshop'), 
                'woodshopTickets' => $model->getTotalTickets('woodshop'),
                'documents' => $this->documents,
                'tool_cards' => $this->tool_cards,
                'groups' => $this->groups, 
                'title' => 'Maintenance Dept',
                'secured_cards' => $this->secured_cards, 
                'user' => auth()->user() ?? null,  
        ]), 'js' => view('maintenance/index.js.php')];
        return view('template/index', $data);
    }
}
