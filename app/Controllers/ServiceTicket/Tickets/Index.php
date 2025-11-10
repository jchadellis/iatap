<?php

namespace App\Controllers\ServiceTicket\Tickets;

use App\Controllers\BaseController;
use App\Models\ServiceTicketModel;
use App\Models\UserModel; 
use App\Models\DeptModel; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{
    private $serviceTypes = [
        'it' => [
            'dept' => '0',
            'title' => 'IT Support', 
            'route' => 'it', 
            'view' => 'service/tickets/index', 
            'email_to' => 'jeremy.ellis@atap.com', 
            //'email_to' => 'patrick.porteous@atap.com,stuart.meek@atap.com,jeremy.ellis@atap.com',
            'new_subject' => 'IT Support Ticket # %s - NEW', 
            'new_message' => 'A new IT Support Ticket # %s has been submitted on %s at %s. Please review the details and respond as needed.',

            'update_subject' => 'IT Support Ticket # %s - UPDATED', 
            'update_message' => 'There has been an update to a IT Support Ticket # %s at %s.',

            'closed_subject' => 'IT Support Ticket # %s - CLOSED', 
            'closed_message' => 'The IT Support Ticket # %s was closed on %s at %s', 
        ],
        'maintenance' => [
            'dept' => '0',
            'title' => 'Maintenace Request', 
            'route' => 'maintenance', 
            'view'  => 'service/tickets/index-maintenance', 
            'email_to' => 'notifications+atap@onupkeep.com',

            'new_subject' => 'Maintenance Ticket # %s - NEW',
            'new_message' => 'A new Maintenance Ticket has been created on %s at %s. Please check the ticket and take appropriate action.',
            
            'update_subject' => 'Maintenance Ticket # %s - UPDATED', 
            'update_message' => 'An update to a Maintenace Ticket # %s has been made on %s at %s.',

            'closed_subject' => 'Maintenance Ticket # %s - CLOSED', 
            'closed_message' => 'The Maintenance Ticket # %s has been closed on %s at %s.',

        ],
        'woodshop' => [
            'dept' => '0',
            'title' => 'Woodshop Request', 
            'route' => 'maintenance', 
            'view' => 'service/tickets/index', 
            'email_to' => 'building4@atap.com',

            'new_subject' => 'Woodshop Ticket # %s - NEW', 
            'new_message' => 'A new Woodshop Ticket # %s has been submitted on %s at %s. Please review the ticket and follow up as necessary.',

            'update_subject' => 'Woodshop Ticket # %s - UPDATED', 
            'update_message' => 'An update to a Woodshop Ticket # %s has been made on %s at %s.',

            'closed_subject' => 'Woodshop Ticket # %s - CLOSED', 
            'closed_message' => 'The Woodshop Ticket # %s has been closed on %s at %s.',

        ],
        'engineering' => [
            'dept' => '9',
            'title' => 'Engineering Request', 
            'route' => 'engineering', 
            'view' => 'service/tickets/index', 
            'email_to' => 'chad.campbell@atap.com',

            'new_subject' => 'Engineering Ticket # %s - NEW' , 
            'new_message' => 'A new Engineering Ticket # %s has been submitted on %s at %s. Please review the ticket and respond as needed.',

            'update_subject' => 'Engineering Ticket %s - UPDATED', 
            'update_message' => 'An update to Engineering Ticket # %s has been submitted on %s at %s.',

            'closed_subject' => 'Engineering Ticket # %s - CLOSED', 
            'closed_message' => 'The Engineering Ticket # %s has been closed at %s', 
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
        'none' => ['color' => 'text-dark', 'bg_color' => 'bg-info'], 
        'low' => [ 'color' => 'text-white', 'bg_color' => 'bg-success'], 
        'medium' => ['color' => 'text-white', 'bg_color' => 'bg-warning'], 
        'high' => ['color' => 'text-dark', 'bg_color' => 'bg-danger'],
    ];

    public function index($type = 'it')
    {
        $user_model = new UserModel(); 
        $dept_model = new DeptModel(); 
        $this->setServiceConfig($type); 

        $dept_users = $user_model->where('dept_id', $this->serviceConfig['dept'])->findAll(); 
        $depts = $dept_model->findAll(); 

        
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

        $content = view($this->serviceConfig['view'], [
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
            'dept_users'    => $dept_users,
            'depts'         => $depts,
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

    public function get_raw_data($type = 'it')
    {
        $model = new ServiceTicketModel();
        // $user_model = new UserModel(); 

        // $user = $user_model->find(5) ;

        // print_array($user); 

        // return; 
        $inGroup = $this->inGroup($type); 

        $data = ($inGroup) 
            ? $model->orderBy('created_at', 'asc')->where('type', $type)->withDeleted()->findAll()
            : $model->orderBy('created_at', 'asc')->where('type', $type)->findAll();

        return $this->response->setJSON([
            'data' =>   $data,
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
        $user_model = new UserModel(); 
        
        $inGroup = $this->inGroup($data['type']); 

        $ticketData = ($inGroup) 
            ? $model->where('id', $data['id'])->withDeleted()->findAll()
            : $model->where('id', $data['id'])->findAll();

        // Only one ticket, so optimize prep_data for single
        $ticket = $this->prep_data($ticketData);
        $user = $user_model->find($ticketData[0]->assigned_to); 
        if(!$ticket)
        {
            return $this->response->setJSON([
                'success' => false, 
            ]);
        }
        $dept_model = new DeptModel(); 
        $depts = $dept_model->findAll(); 
        return $this->response->setJSON([
            'data' => view('service/tickets/modal', ['ticket' => $ticket[0], 'user' => $user , 'depts' => $depts ]), 
            'success' => true, 
            'message' => 'Retreived Service Ticket Modal', 
        ]);
    }

    public function new_ticket()
    {
        $rules = [
            'user' => [
                'rules'  => 'required|regex_match[/^[A-Za-z]+ [A-Za-z]+$/]',
                'label' => 'Your Name', 
                'errors' => [
                    'regex_match' => 'Please enter your first and last name (e.g. John Doe).'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email', 
                'label' => 'Email Address', 
                'errors' => [
                    'required' => ' is required.', 
                    'valid_email' => ' must be a valid address.',
                ],
            ],
            'title' => [
                'rules' => 'required', 
                'label' => 'Ticket Name', 
                'errors' => ['required' => ' is required.']
            ],
            'dept_id' => [
                'rules' => 'required', 
                'label' => 'Department', 
                'errors' => ['required' => ' enter the Department you are in.'],
            ], 
            'description' => [
                'rules' => 'required', 
                'label' => 'Description', 
                'errors' => ['rquired' => ' is required for the ticket.']
            ],
            'need_date' => [
                'rules' => 'required', 
                'label' => 'Need By Date',
                'errors' => ['required' => ' is required.'], 
            ],
        ];

        if(!$this->validate($rules))
        {
            $errors = $this->validator->getErrors();

            $messages = [];
            foreach ($errors as $field => $error) {
                $rule = $rules[$field];    
                $label = $rule['label'];       
                $messages[] = "<b>" . $label . "</b>: " . $error;
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
            $data['first_name'] = ucfirst(strtolower($name[0]));
            $data['last_name'] =  ucfirst(strtolower($name[1]));
        }

        $data['title'] = ucwords(strtolower($data['title']));

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
        $data["updated_by"] = auth()->user()->id ?? 0; 

        $model = new ServiceTicketModel();     

        if($model->save($data))
        {

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

            $ticket = $this->prep_data($data); 

            $this->send_email($ticket[0], $user, 'update_subject', 'update_message' ); 

            return $this->response->setJSON([
                'success' => true, 
                'message' => "Ticket {$ticket[0]->title} was updated!",  
                'data' => $ticket[0], 
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
            'work_performed' => $post['work_performed'],
            'updated_by' => auth()->user()->id ?? 0,
        ];

        $service_ticket = $model->find($post['id']); 

        $model->save($data); 

        $model->delete($post['id']); 

        $ticket = $this->prep_data($model->withDeleted()->where('id' , $post['id'])->findAll()); 
        $user = auth()->user() ?? null; 


        if( $this->send_email($ticket[0], $user, 'closed_subject', 'closed_message' ) )
        {
            return $this->response->setJSON([
                'success' => true, 
                'message' => "Ticket was successfully closed!",  
                'data' => $ticket[0], 
                'icon' => 'success', 
                'title' => 'Ticket Closed', 
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => "Ticket Closed! Error sending email",  
                'data' => $ticket[0], 
                'icon' => 'warning', 
                'title' => 'Ticket Closed', 
            ]);
        }


    }

    private function prep_data($data, $id = null )
    {
        $model = new ServiceTicketModel();
        $dept_model = new DeptModel(); 
        $user_model = new UserModel(); 

        if(empty($data)){
            return []; 
        }

        // Optimization: If only one ticket, fetch user directly
        if (count($data) === 1) 
        {
            $service_ticket = $data[0];
            //$user_model = new UserModel();
            $user = $user_model->find($service_ticket->user_id) ?? (object)[];
            $assigned_user = $user_model->find($service_ticket->assigned_to) ?? (object)[];
            $service_ticket->user = $user;
            $service_ticket->assigned_to_user = $assigned_user; 
            if ((int)$service_ticket->user_id == 0 || (int)$service_ticket->user_id == 5) 
            {
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

            $service_ticket->badge_color = $this->badges[$service_ticket->priority]['bg_color'];
            $service_ticket->cell_font_color = $this->badges[$service_ticket->priority]['color'];
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

            if ($service_ticket->deleted_at) 
            {
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
            $service_ticket->reference_id = ($service_ticket->reference_id) ? $service_ticket->reference_id :  $service_ticket->id; 
            // Return as array for consistency
            return [$service_ticket];
        }

        // Collect all user_ids from tickets
        $user_ids = [];
        $assigned_user_ids = []; 
        foreach ($data as $ticket) 
        {
            $user_ids[] = $ticket->user_id;
            if( !is_null($ticket->assigned_to))
            {
                $assigned_user_ids[] = $ticket->assigned_to; 
            }
        }
        $user_ids = array_unique($user_ids);
        $assigned_user_ids = array_unique($assigned_user_ids); 

        // Bulk fetch users
        $users = [];
        $assigned_users = []; 

        if (!empty($user_ids)) {
            foreach ($user_model->whereIn('id', $user_ids)->findAll() as $user) 
            {
                $users[$user->id] = $user;
            }
        }

        if (!empty($assigned_user_ids)) {
            foreach ($user_model->whereIn('id', $assigned_user_ids)->findAll() as $user) 
            {
                $assigned_users[$user->id] = $user;
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
            $service_ticket->array = $user_ids; 
            $assigned_user = $assigned_users[$service_ticket->assigned_to] ?? (object)[]; 
            $service_ticket->user = $user; 
            $service_ticket->assigned_to_user = $assigned_user; 
            $first_name = $service_ticket->first_name; 
            $last_name = $service_ticket->last_name; 

            $service_ticket->title = $service_ticket->title;
            $row_color = ''; 
            $status = ''; 
            $status_color = ''; 

            $service_ticket->badge_color = $this->badges[$service_ticket->priority]['bg_color'];
            $service_ticket->cell_font_color = $this->badges[$service_ticket->priority]['color'];
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
            $service_ticket->reference_id = ($service_ticket->reference_id) ? $service_ticket->reference_id :  $service_ticket->id; 
            $tickets[]  = $service_ticket; 
        }
        return $tickets; 
    }

    public function send_email($ticket, $user, $subject = 'new_subject', $message = 'new_message' )
    {
        $user_model = new UserModel(); 
        $dept_model = new DeptModel(); 

        $assigned_to_user = $user_model->find($ticket->assigned_to) ?? null ; 

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

        $email->setCC($ticket->email); 

        $ticket->dept = $dept_model->find($ticket->dept_id);

        $subject = sprintf($config[$subject], $ticket->id);
        $email->setSubject($subject);
        $email->setMessage(view('service/tickets/email-body', [
            'message' => sprintf($config[$message], $ticket->id, date('m-d-Y'), date('h:i:s')), 
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

    public function get_performance($type = 'engineering')
    {
        $model = new ServiceTicketModel();

        $performance = $model->getPerformance($type);

        print_array($performance);
    }

    public function get_spreadsheet($type = 'engineering')
    {
        $model = new ServiceTicketModel();
        $session = session(); 
        $spreadsheet = new Spreadsheet();

        $data = $model->getTicketsRange($type);

        if( $session->has('performance_start_date') )
        {
            $start = $session->get('performance_start_date');
            $end = $session->get('performance_end_date');       
            $data = $model->getTicketsRange($type, $start, $end);
        }

        $start = isset($start)
            ? new \DateTime($start) 
            : (new \DateTime())->modify('-90 Days'); 


        $end = isset($end)
            ? new \DateTime($end) 
            : new \DateTime(); 
 
        //Setup Headers
        $headers = [
            'TICKET ID', 
            'TITLE',
            'NEED DATE',
            'NAME',
            'ON TIME',
            'LATE', 
        ];

        // Style title
        $titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FF000000']
            ],
        ];

        // Style headers
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF471396'], 
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF757575'],
                ],
            ],

        ];

        //Alternate Row Style
        $alternateRowStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFccbce5'] 
            ],
        ];

        //Totals Row Style
        $totalsRowStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF96ff9d']
            ],
        ];

        //Set the default style for the spreadsheet
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(12);

        $sheet = $spreadsheet->getActiveSheet();
        
        //Get the end column index
        $endColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));

        // Set sheet title
        $title = 'Engineering Performance Report'; 
        $sheet->setTitle($title);

        $formatted_start = $start->format('Y-m-d'); 
        $formatted_end = $end->format('Y-m-d'); 
        $sheet->setCellValue('A1', 'Engineering Performance - ' . $formatted_start . ' / ' .$formatted_end);
        $sheet->getStyle('A1:'.$endColumn .'1')->applyFromArray($titleStyle);
        $spreadsheet->getActiveSheet()->mergeCells('A1:'. $endColumn .'1');

        // Set headers
        $sheet->fromArray([$headers], null, 'A2');       
        $headerRange = 'A2:' . $endColumn . '2';
        $sheet->getStyle($headerRange)->applyFromArray($headerStyle);

        $row = 3;

        foreach($data['tickets'] as $item) {

            $first_name = $item->first_name ?? '';
            $last_name = $item->last_name ?? ''; 
            $rowData = [
                $item->id ?? '',
                $item->title ?? '',
                $item->need_date ? (new \DateTime($item->need_date))->format('Y-m-d') : '', 
                $first_name . ' ' . $last_name, 
                $item->on_time ? 'ON TIME' : '',
                !$item->on_time ? 'LATE' : '',
                $item->total_late ?? '', 
            ];
            
            // Add the rest of the row data starting from column B
            $sheet->fromArray([$rowData], null, 'A' . $row);
            $rowRange = 'A' . $row . ':' . $endColumn . $row;
            if( $row % 2 == 0){
                $sheet->getStyle($rowRange)->applyFromArray($alternateRowStyle);
            }

            $row++;
        }


        //Write totals to last row. 
        $totals = [
            'TOTAL LINES:',
            $data['totals']['total_lines'],
            $data['totals']['total_on_time'] . ' ( ' . $data['totals']['on_time_percentage'] . ' )', 
            $data['totals']['total_late'] . ' ( ' . $data['totals']['late_percentage'] . ' )',
        ];
        $rowRange = 'C' . $row . ':' . $endColumn . $row; 
        $sheet->fromArray([$totals], null, 'C' . $row);
        //$sheet->getStyle($rowRange)->applyFromArray($totalsRowStyle);
        // $rowRange = 'B' . $row . ':' . $endColumn . $row; 
        // $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle( $rowRange)->getFont()->setBold(true);

        // Auto-size columns
        for($col = 1; $col <= count($headers); $col++) {
            $sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }

        $sheet->getStyle('F:G')
            ->getNumberFormat()
            ->setFormatCode('0.00%');

        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $filename = "Engineering-Performance.xlsx";
        
        // Create temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);
        
        // Read and return file content
        $fileContent = file_get_contents($tempFile);
        unlink($tempFile);
        
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($fileContent);


    }

}