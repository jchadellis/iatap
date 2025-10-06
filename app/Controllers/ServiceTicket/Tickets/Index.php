<?php

namespace App\Controllers\ServiceTicket\Tickets;

use App\Controllers\BaseController;
use App\Models\ServiceTicketModel;
use App\Models\UserModel; 

class Index extends BaseController
{
    private $serviceTypes = [
        'it' => [
            'dept' => '0',
            'title' => 'IT Support', 
            'route' => 'it', 
            'email_to' => 'patrick.porteous@atap.com,stuart.meek@atap.com,jeremy.ellis@atap.com',
            'new_subject' => 'New IT Support Request', 
            'update_subject' => 'IT Support Request Updated', 
            'new_message' => 'A new IT support ticket has been submitted. Please review the details and respond as needed.',
            'update_message' => 'An update to a IT support ticket has been submitted.',
        ],
        'maintenance' => [
            'dept' => '0',
            'title' => 'Maintenace Request', 
            'route' => 'maintenance', 
            'email_to' => 'maintenace@atap.com',
            'new_subject' => 'New Maintenance Request', 
            'update_subject' => 'Maintenance Request Updated', 
            'new_message' => 'A new maintenance request has been created. Please check the ticket and take appropriate action.',
            'update_message' => 'An update to a maintenance request ticket has been submitted.',
        ],
        'woodshop' => [
            'dept' => '0',
            'title' => 'Woodshop Request', 
            'route' => 'maintenance', 
            'email_to' => 'building4@atap.com',
            'new_subject' => 'New Wood Shop Work Request', 
            'update_subject' => 'Wood Shop Work Request Updated', 
            'new_message' => 'A new woodshop work request has been submitted. Please review the ticket and follow up as necessary.',
            'new_message' => 'An update to a woodshop request ticket has been submitted.',
        ],
        'engineering' => [
            'dept' => '9',
            'title' => 'Engineering Request', 
            'route' => 'engineering', 
            'email_to' => 'chad.campbell@atap.com',
            'new_subject' => 'New Engineering Request', 
            'update_subject' => 'Engineering Request Updated', 
            'new_message' => 'A new engineering request has been received. Please review the ticket and provide support as needed.',
            'update_message' => 'An update to Engineering request has been submitted.',
        ]
    ];

    private $type; 


    private function setServiceConfig($type)
    {
        if (!array_key_exists($type, $this->serviceTypes)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Service Ticket Method type not found");
        }
        $this->serviceConfig = $this->serviceTypes[$type];
    }

    private $badges = [
        'none' => ['color' => 'text-bg-info'], 
        'low' => [ 'color' => 'text-bg-secondary'], 
        'medium' => ['color' => 'text-bg-primary'], 
        'high' => ['color' => 'text-bg-warning'],
    ];

    public function index($type = 'it')
    {
        $userModel = new UserModel(); 


        $this->setServiceConfig($type); 

        $dept_users = $userModel->where('dept_id', $this->serviceConfig['dept'])->findAll(); 

        
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            //['name' => ($type =='it') ? strtoupper($type) : ucfirst($type) , 'is_active' => false, 'url' => $this->serviceConfig['route']],
            ['name' => $this->serviceConfig['title'], 'is_active' => true, 'url' => '#']
        ];

        $inGroup = $this->inGroup($type);
        $user = auth()->user() ?? false;           
        $urls = [
            'all' => base_url('service/tickets/data/'.$type),
            'save' => base_url('service/tickets/save'), 
            'new' => base_url('service/tickets/new'), 
            'close' => base_url('service/tickets/close'), 
            'get' => base_url('service/tickets/get'), 
            'previous' => $this->request->getUserAgent()->getReferrer(),
        ];

        $content = view("service/tickets/index", [
            'user'          => $user, 
            'inGroup'       => $inGroup,
            'userCanClose'  => $user ? $user->can("{$type}.close") : false,
            'userCanUpdate' => (
                $type === 'engineering'
                    ? ($user && $user->inGroup('engineering') && $user->can('engineering.update'))
                    : true
            ),
            'type'          => $type,
            'title'         => $this->serviceConfig['title'], 
            'urls'          => $urls,
            'dept_users' => $dept_users,
        ]);
      
        $js = view("service/tickets/index.js.php", ['urls' => $urls]);
        
        return view('template/index', [
            'content' => $content, 
            'js' => $js, 
            'breadcrumbs' => $breadcrumbs, 
            'title' => $this->serviceConfig['title']
        ]);
    }

    public function get_data($type = 'it')
    {
        $model = new ServiceTicketModel();
        $inGroup = $this->inGroup($type); 

        $data = ($inGroup) 
            ? $model->orderBy('created_at', 'asc')->where('type', $type)->withDeleted()->findAll()
            : $model->orderBy('created_at', 'asc')->where('type', $type)->findAll();

        $tickets  = $this->prep_data($data); 

        return $this->response->setJSON([
            'data' =>   $tickets,
       ]);
    }  

    private function inGroup($type)
    {
        $user = auth()->user(); 
        $inGroup = false; 
        if($user)
        {
            $inGroup = $user->inGroup('super', $type) ? true : false; 
        }
        return $inGroup; 
    }

    public function get_ticket()
    {
        $data = $this->request->getPost(); 
        $model = new ServiceTicketModel();
        $userModel = new UserModel(); 
        
        $inGroup = $this->inGroup($data['type']); 

        $ticketData = ($inGroup) 
            ? $model->where('id', $data['id'])->withDeleted()->findAll()
            : $model->where('id', $data['id'])->findAll();

        // Only one ticket, so optimize prep_data for single
        $ticket = $this->prep_data($ticketData);
        $user = $userModel->find($ticketData[0]->assigned_to); 
        if(!$ticket)
        {
            return $this->response->setJSON([
                'success' => false, 
            ]);
        }

        return $this->response->setJSON([
            'data' => view('service/tickets/modal', ['ticket' => $ticket[0], 'user' => $user ]), 
            'success' => true, 
            'message' => 'Retreived Service Ticket Modal', 
        ]);
    }

    public function new_ticket()
    {
        $rules = [
            'user' => [
                'rules'  => 'required|regex_match[/^[A-Za-z]+ [A-Za-z]+$/]',
                'errors' => [
                    'regex_match' => 'Please enter your first and last name (e.g. John Doe).'
                ]
            ],
            'email' => 'required|valid_email', 
            'title' => 'required', 
            'description' => 'required', 
        ];

        if(!$this->validate($rules))
        {
            $errors = $this->validator->getErrors();

            $messages = [];
            foreach ($errors as $field => $error) {
                $messages[] = "<b>" . ucfirst($field) . "</b>: " . $error;
            }

            $message = implode('<br>', $messages);

            return $this->response->setJSON([
                'success' => false,
                'message' => $message, 
                'icon' => 'warning', 
                'title' => 'Some details are missing', 
            ]);
        }


        $model = new ServiceTicketModel();

        $data = $this->request->getPost();

        $data['need_date'] = (new \DateTime($data['need_date']))->format('Y-m-d H:i:s');

        if( $data['user_id'] == 0 )
        {
            $name = explode(' ', $data['user'] );
            $data['first_name'] = $name[0];
            $data['last_name'] = $name[1];
        }

        //$user = (object) ['first_name' => $data['first_name'], 'last_name' => $data['last_name']];

        $success = $model->save($data);
        $id = $model->getInsertId(); 

        $inGroup = $this->inGroup($data['type']); 

        $data = ($inGroup) 
            ? $model->where('id', $id)->withDeleted()->findAll()
            : $model->where('id', $id)->findAll();

        $data = $this->prep_data($data);

        $fallBackUser = [
            'first_name' => $data['first_name'] ?? '', 
            'last_name' => $data['last_name'] ?? '',
            'email' => false, 
        ];

        $user = auth()->user() ?? (object) $fallBackUser; 

        if( $success ) {
            $this->send_email($data[0], $user ); 
            return $this->response->setJSON([
                'success' => true,
                'message' => 'A new ticket has been created.',
                'icon' => 'success', 
                'title' => 'New Ticket Saved', 
                'data' => $data[0],
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'There was an error with the submission. Please check your entry and try again.',
        ]);
    }

    public function save_ticket()
    {
        $data = $this->request->getPost(); 

        $data['num_of_updates']++;

        $model = new ServiceTicketModel();     

        if($model->save($data)){

            $fallBackUser = [
                'first_name' => $data['first_name'] ?? '', 
                'last_name' => $data['last_name'] ?? '',
                'email' => false, 
            ];

            $user = auth()->user() ?? (object) $fallBackUser; 

            $inGroup = $this->inGroup($data['type']); 



            $data = ($inGroup) 
                ? $model->where('id', $data['id'])->withDeleted()->findAll()
                : $model->where('id', $data['id'])->findAll();

            $data = $this->prep_data($data); 

            $this->send_email($data[0], $user, 'update_subject', 'update_message' ); 

            return $this->response->setJSON([
                'success' => true, 
                'message' => "Ticket {$data[0]->title} was updated!",  
                'data' => $data[0], 
                'icon' => 'success', 
                'title' => 'Ticket Updated', 
            ]);
        }
    }

    public function delete()
    {
        $model = new ServiceTicketModel(); 
        $post = $this->request->getPost(); 

        $data = [
            'id' => $post['id'], 
            'work_performed' => $post['work_performed']
        ];

        $service_ticket = $model->find($post['id']); 

        $model->save($data); 

        $model->delete($post['id']); 

        $ticket = $this->prep_data($model->withDeleted()->where('id' , $post['id'])->findAll()); 

        return $this->response->setJSON([
            'success' => true, 
            'message' => "Ticket was successfully closed!",  
            'data' => $ticket[0], 
            'icon' => 'success', 
            'title' => 'Ticket Closed', 
        ]);
    }

    private function prep_data($data, $id = null )
    {
        $model = new ServiceTicketModel();
        $user_model = new UserModel(); 

        if(empty($data)){
            return []; 
        }

        // Optimization: If only one ticket, fetch user directly
        if (count($data) === 1) {
            $service_ticket = $data[0];
            $user_model = new UserModel();
            $user = $user_model->find($service_ticket->user_id) ?? (object)[];
            $service_ticket->user = $user;
            if ($service_ticket->user_id == 0 || $service_ticket->user_id == 5) {
                $user->first_name = $service_ticket->first_name;
                $user->last_name = $service_ticket->last_name;
            }
            $today = new \DateTime();
            $need_date = new \DateTime($service_ticket->need_date);
            $seven_days_before = clone $need_date;
            $seven_days_before->modify('-7 days');   
            
            //GET SERVICE CONFIG AND USER THAT THE TICKET WAS CREATED BY; 
            $this->setServiceConfig($service_ticket->type); 

            $status = ''; 
            $status_color = ''; 
            $row_color = ''; 

            $service_ticket->badge_color = $this->badges[$service_ticket->priority]['color'];
            //DETERMINE THE TICKET STATUS
            if( $need_date->format('Y-m-d') === $today->format('Y-m-d')){
                $status = 'Due Today'; 
                $status_color = 'text-bg-danger'; 
                $row_color = 'table-warning'; 
            }elseif($need_date >= $seven_days_before && $today < $need_date){
                $status = 'Due Soon'; 
                $status_color = 'text-bg-warning'; 
                $row_color = 'table-light'; 
            }elseif($today > $need_date ){
                $status = 'Late'; 
                $status_color = 'text-bg-danger'; 
                $row_color = 'table-danger'; 
            }else{
                $status = 'New'; 
                $status_color = 'text-bg-success'; 
                $row_color = 'table-success'; 
            }

            //SETUP BUTTON CONFIG 
            $service_ticket->btn_text = 'Edit';
            $service_ticket->btn_color = 'btn-primary';
            $service_ticket->btn_icon = true;

            if ($service_ticket->deleted_at) {
                $status = 'Closed';
                $status_color = 'text-bg-primary';
                $row_color = '';
                $service_ticket->btn_text = 'Review';
                $service_ticket->btn_color = 'btn-light border-info';
                $service_ticket->btn_icon = false;
            }

            $service_ticket->status = $status;
            $service_ticket->row_color = $row_color; 
            $service_ticket->status_color = $status_color;
            $service_ticket->editBtn = '';
            $service_ticket->need_date = $need_date->format('Y-m-d');
            // Return as array for consistency
            return [$service_ticket];
        }

        // Collect all user_ids from tickets
        $user_ids = [];
        foreach ($data as $ticket) {
            $user_ids[] = $ticket->user_id;
        }
        $user_ids = array_unique($user_ids);

        // Bulk fetch users
        $users = [];
        if (!empty($user_ids)) {
            foreach ($user_model->whereIn('id', $user_ids)->findAll() as $user) {
                $users[$user->id] = $user;
            }
        }

        $tickets = []; 

        foreach($data as $service_ticket)
        {
            //SETUP DATES
            $today = new \DateTime();
            $need_date = new \DateTime($service_ticket->need_date);
            $seven_days_before = clone $need_date;
            $seven_days_before->modify('-7 days');   
            
            //GET SERVICE CONFIG AND USER THAT THE TICKET WAS CREATED BY; 
            $this->setServiceConfig($service_ticket->type); 

            // Use bulk-fetched user or fallback
            $user = $users[$service_ticket->user_id] ?? (object)[];
            $service_ticket->user = $user; 

            if( $service_ticket->user_id == 0 || $service_ticket->user_id == 5 )
            {
                $user->first_name = $service_ticket->first_name; 
                $user->last_name = $service_ticket->last_name;
            }
            $service_ticket->title = $service_ticket->title;
            $row_color = ''; 
            $status = ''; 
            $status_color = ''; 

            $service_ticket->badge_color = $this->badges[$service_ticket->priority]['color'];
            //DETERMINE THE TICKET STATUS
            if( $need_date->format('Y-m-d') === $today->format('Y-m-d')){
                $status = 'Due Today'; 
                $status_color = 'text-bg-danger'; 
                $row_color = 'table-warning'; 
            }elseif($need_date >= $seven_days_before && $today < $need_date){
                $status = 'Due Soon'; 
                $status_color = 'text-bg-warning'; 
                $row_color = 'table-light'; 
            }elseif($today > $need_date ){
                $status = 'Late'; 
                $status_color = 'text-bg-danger'; 
                $row_color = 'table-danger'; 
            }else{
                $status = 'New'; 
                $status_color = 'text-bg-success'; 
                $row_color = 'table-success'; 
            }

            //SETUP BUTTON CONFIG 
            $service_ticket->btn_text = 'Edit';
            $service_ticket->btn_color = 'btn-primary';
            $service_ticket->btn_icon = true;

            if ($service_ticket->deleted_at) {
                $status = 'Closed';
                $status_color = 'text-bg-primary';
                $row_color = '';
                $service_ticket->btn_text = 'Review';
                $service_ticket->btn_color = 'btn-light border-info';
                $service_ticket->btn_icon = false;
            }

            $service_ticket->status = $status;
            $service_ticket->row_color = $row_color; 
            $service_ticket->status_color = $status_color;
            $service_ticket->editBtn = '';
            $service_ticket->need_date = $need_date->format('Y-m-d');
            $tickets[]  = $service_ticket; 
        }
        return $tickets; 
    }

    public function send_email($ticket, $user, $subject = 'new_subject', $message = 'new_message' )
    {
        $userModel = new UserModel(); 

        $assigned_to_user = $userModel->find($ticket->assigned_to) ?? null ; 

        $this->setServiceConfig($ticket->type);
        $config = $this->serviceConfig; 

        $email = \Config\Services::email();

        if($ticket->type === 'engineering'){
            $email->setFrom($ticket->email);
            $email->setTo($assigned_to_user->email);
        }else{
            $email->setFrom($ticket->email);
            $email->setTo($config['email_to']);
        }


        $subject = $config[$subject];
        $email->setSubject($subject);
        $email->setMessage(view('service/tickets/email-body', [
            'message' => $config[$message], 
            'user' => $user, 
            'route' => 'service/tickets/'.$config['route'],
            'ticket' => $ticket,
        ]));

        $email->setMailType('html');

        if( !$email->send())
        {
            return false; 
        }
        return true;
    }

    public function get_old($type = 'it')
    {
        $user_model = new UserModel(); 

        $users = $user_model->where('dept_id', '9')->findAll(); 

        print_array($users); 
        return; 
        $model = new ServiceTicketModel(); 
        $db = db_connect('atapweb'); 
        
        $table = $db->table($type);
        
        $results =  $table->orderBy('request_date')->get()->getResult();

        $tickets = [];

        foreach($results as $row)
        {   
            
            $address = $row->request_email; 

            $str = explode('@', $address); 

            $name = explode('.', $str[0]);

            $first_name = ucfirst(strtolower($name[0]));
            $last_name = isset($name[1])  ? ucfirst(strtolower($name[1])) : '' ;

            $today = new \DateTime(); 
            $year = $today->modify('-1 Year'); 
            $created_date = new \DateTime($row->request_date); 

            $deleted_at = $row->completion_date ? new \DateTime($row->completion_date) : null; 
            $can_delete = $deleted_at || $created_date < $year ? true : false;

            $ticket = [
                'user_id' => 5, 
                'type' => $type, 
                'reference_id' => $row->request_id ?? null, 
                'status' => $row->request_status ?? null, 
                'title' => 'Transferred From vatap', 
                'description' => $row->description, 
                'first_name' => $first_name, 
                'last_name' => $last_name, 
                'email' => strtolower($row->request_email), 
                'priority' => $row->priority ?? 'low', 
                'need_date' => $row->want_date,
                'num_of_updates' => $row->times_changed ?? 0, 
                'created_at' => (new \DateTime($row->request_date))->format('Y-m-d h:i:s'),
                'deleted_at' => $can_delete  ? (new \DateTime($row->completion_date))->format('Y-m-d h:i:s') : null, 
             ];
             $tickets[] = $ticket; 
             $model->save($ticket); 
        }

        print_array($tickets); 
    }

}