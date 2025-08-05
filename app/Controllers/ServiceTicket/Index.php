<?php

namespace App\Controllers\ServiceTicket;

use App\Controllers\BaseController;
use App\Models\ServiceTicketModel;
use App\Models\UserModel; 

class Index extends BaseController
{
    private $serviceTypes = [
        'it' => ['title' => 'IT Support', 'route' => 'it'],
        'maintenance' => ['title' => 'Service Request', 'route' => 'maintenance'],
        'woodshop' => ['title' => 'Request', 'route' => 'maintenance'],
        'engineering' => ['title' => 'Engineering Request', 'route' => 'engineering']
    ];

    public function index($type = 'it')
    {
        if (!array_key_exists($type, $this->serviceTypes)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Service Ticket Method type not found");
        }

        $user = auth()->user();
        $serviceConfig = $this->serviceTypes[$type];
        
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => ($type =='it') ? strtoupper($type) : ucfirst($type) , 'is_active' => false, 'url' => $serviceConfig['route']],
            ['name' => $serviceConfig['title'], 'is_active' => true, 'url' => '#']
        ];

        $inGroup = $user->inGroup('super', $type) ? true : false; 
  
        $url = base_url("service-tickets/data/0/$type");

        $content = view("service_tickets/index", [
            'data'          => $this->get_data(true, $type, $inGroup), 
            'user'          => $user, 
            'inGroup'       => $inGroup,
            'type'          => $type,
            'data_url'      => base_url("service-tickets/data/0/$type"),
            'save_url'      => base_url("service-tickets/$type/save"),
            'delete_url'    => base_url("service-tickets/$type/delete"), 
            'title'         => $serviceConfig['title']
        ]);
        
        $js = view("service_tickets/index.js.php");
        
        return view('template/index', [
            'content' => $content, 
            'js' => $js, 
            'breadcrumbs' => $breadcrumbs, 
            'title' => $serviceConfig['title']
        ]);
    }

    public function get_data($raw = false, $type = 'it')
    {
        $model = new ServiceTicketModel();
        
        $user = auth()->user();

        $inGroup = $user->inGroup('super', $type) ? true : false; 

        $data = ($inGroup) 
            ? $model->where('type', $type)->withDeleted()->findAll()
            : $model->where('type', $type)->findAll();

        if (!$raw) {
            $data = $this->prep_data($data);
            return $this->response->setJSON(['data' => $data]);
        } else {
            return $this->prep_data($data);
        }
    }  

    public function save_data($type = 'it')
    {
        $model = new ServiceTicketModel();
        $post = $this->request->getPost();
        
        $post['need_date'] = (new \DateTime($post['need_date']))->format('Y-m-d H:i:s');

        $success = $model->save($post);
        
        if ($success) {
            $id = $model->getInsertID();
            
            if ($id) {
                $data = $this->prep_data([$model->find($id)]);
                $data[0]->flag = true;
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'New request has been added',
                    'type' => 'new',
                    'data' => $data[0],
                ]);
            } else {
                $data = $model->find([$post['id']]);
                $data = $this->prep_data($data);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Your request has been updated',
                    'type' => 'update',
                    'data' => $data[0],
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'There was an error with the submission. Please check your entry and try again.',
        ]);
    }

    public function delete()
    {
        $model = new ServiceTicketModel(); 
        $ticket = $this->request->getPost(); 

        $user = auth()->user();
        $inGroup = $user->inGroup('super', $ticket['type']) ? true : false; 

        $data = [
            'id' => $ticket['id'], 
            'comment' => $ticket['comments'], 
            'work_performed' => $ticket['work_performed']
        ];

        $model->delete($ticket['id']); 

        $ticket = $model->withDeleted()->where('id' , $ticket['id'])->findAll(); 

        $data = $this->prep_data($ticket); 

        return $this->response->setJSON([
            'data' => $data,
            'success' => true, 
            'message' => 'Ticket Deleted successfully', 
            'inGroup' => $inGroup, 
        ]);
    }
    private function prep_data($data)
    {
        $user_model = new UserModel(); 
        foreach ($data as $row) {
            $user = $user_model->find($row->user_id); 

            $today = new \DateTime();
            $need_date = new \DateTime($row->need_date);
            
            $seven_days_before = clone $need_date;
            $seven_days_before->modify('-7 days');
            
            $row->user = $user->first_name . ' ' . $user->last_name; 
            $row->btn_text = 'Edit';
            $row->btn_color = 'btn-primary';
            $row->btn_icon = true;

            if( $need_date === $today){
                $status = 'Due Today'; 
                $status_color = 'text-bg-warning'; 
            }elseif($seven_days_before >= $seven_days_before && $today < $need_date){
                $status = "Due Soon";
                $status_color = 'text-bg-warning';
            }elseif($today > $need_date ){
                $status = 'Late'; 
                $status_color = 'text-bg-danger'; 
            }else{
                $status = 'New'; 
                $status_color = 'text-bg-success'; 
            }

            if ($row->deleted_at) {
                $status = 'Completed';
                $status_color = 'text-bg-primary';
                $row->btn_text = 'Review';
                $row->btn_color = 'btn-light border-info';
                $row->btn_icon = false;
            }

            $row->status = $status;
            $row->status_color = $status_color;
            $row->editBtn = '';
            $row->need_date = $need_date->format('Y-m-d');
        }

        return $data;
    }

}