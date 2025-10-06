<?php

namespace App\Controllers\ServiceTicket;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceTicketModel; 

class Index extends BaseController
{
    private  $tool_cards = [
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
        ],
        [
            'name' => 'IT Dept. Request', 
            'description' => 'Submit requests for technical support, software installations, hardware troubleshooting, network issues, and other IT-related services.',
            'btn_text' => 'Create Ticket', 
            'icon' => 'components/icon/ticket-icon',
            'url'   => 'service/tickets/it',
            'color' => 'text-dark',  
        ],
        [
            'name' => 'Engineering Request', 
            'description' => 'Request engineering support for product design, process improvements, technical drawings, equipment modifications, and other engineering-related projects.',
            'btn_text' => 'Create Ticket', 
            'icon' => 'components/icon/ticket-icon',
            'url'   => 'service/tickets/engineering',
            'color' => 'text-dark',  
        ]
    ];

    public function index()
    {
        $model = new ServiceTicketModel(); 
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Service Tickets', 'is_active' => true, 'url' => '#'],
        ];

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'Maintenance Dept.', 
            'content' => view('service/index', [ 'tool_cards' => $this->tool_cards]), 
            'js' => view('service/index.js.php')
        ];
        return view('template/index', $data);
    }
}
