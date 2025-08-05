<?php

namespace App\Controllers\Engineering;

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
            ['name' => 'Engineering Dept', 'is_active' => true, 'url' => '#'],
        ];

        $tool_cards = [
            [
                'name' => 'Engineering Request', 
                'description' => 'Submit a Support Request to Engineering', 
                'btn_text' => 'Create Ticket', 
                'icon' => 'components/icon/ticket-icon',
                'url'   => 'service-tickets/engineering',
                'color' => 'text-dark',  
            ],
        ];


        $data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Engineering Dept.', 'content' => view('engineering/index', [
            'performanceData' => $model->getPerformance('engineering'), 
            'ticketData' => $model->getTotalTickets('engineering'),  
            'tool_cards' => $tool_cards,
        ]), 'js' => view('engineering/index.js.php')];
        
        return view('template/index', $data);
    }
}
