<?php

namespace App\Controllers\IT;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceTicketModel; 

class Index extends BaseController
{
    public function index()
    {
        $model = new ServiceTicketModel(); 
        
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'IT Dept', 'is_active' => true, 'url' => '#'],
        ];

        $tool_cards = [
            [
                'name' => 'IT Support Request', 
                'description' => 'Submit a IT Support Request Tickets', 
                'btn_text' => 'Create Ticket', 
                'icon' => 'components/icon/ticket-icon',
                'url'   => 'service-tickets/it',
                'color' => 'text-dark',  
            ],
        ];

        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'it Dept.', 'content' => view('it/index', [
            'performanceData' => $model->getPerformance('it'), 
            'ticketData' => $model->getTotalTickets('it'),
            'tool_cards' => $tool_cards,  
        ]), 'js' => view('it/index.js.php')];

        return view('template/index', $data);
    }
}
