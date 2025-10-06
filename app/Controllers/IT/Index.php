<?php

namespace App\Controllers\IT;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceTicketModel; 

class Index extends BaseController
{
    private $secured_cards = []; 

    private  $tool_cards = [
        [
            'name' => 'IT Support Request', 
            'description' => 'Submit a IT Support Request Tickets', 
            'btn_text' => 'Create Ticket', 
            'icon' => 'components/icon/ticket-icon',
            'url'   => 'service/tickets/it',
            'color' => 'text-dark',  
        ],
    ];

    private $groups = ['it'];
    public function index()
    {
        $model = new ServiceTicketModel(); 
        
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'IT Dept', 'is_active' => true, 'url' => '#'],
        ];

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'it Dept.', 
            'content' => view('template/dept-index', [
                'performanceData' => $model->getPerformance('it'), 
                'ticketData' => $model->getTotalTickets('it'),
                'groups' => $this->groups, 
                'title' => 'IT Dept', 
                'user' => auth()->user() ?? null, 
                'tool_cards' => $this->tool_cards,  
                'secured_cards' => $this->secured_cards, 
        ]), 'js' => view('it/index.js.php')];

        return view('template/index', $data);
    }

    public function access_request($group)
    {
        $user = auth()->user();

        $email = service('email');

        $email->setMailType('html');
        $email->setFrom($user->email); 
        $email->setTo('jeremy.ellis@atap.com'); 
        $email->setSubject('iATAP Group Access');

        $message = view('admin/email-templates/group-access-request', ['user' => $user, 'group' => $group]); 

        $email->setMessage($message); 

        if( $email->send() )
        {
            return redirect()->back()->with('message', 'Email was sent successfully. Your request will be reviewed'); 
        }


        return redirect()->back()->with('errors', 'Email failed to send. Please try again.'); 
 
    }
}
