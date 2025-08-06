<?php

namespace App\Controllers\Production\Schedule;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel;

class Index extends BaseController
{
    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
    }
    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Production', 'is_active' => false, 'url' => 'production'],
                ['name' => 'Schedule', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Production Schedule', 
            'content' => view('production/schedule/index'),
            'js' => view('production/schedule/index.js.php'), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data($dept = 'all')
    {
        $this->data = $this->remote_model->getData("http://vatap/mvc/public/api/getschedule/$dept"); 
        return $this->response->setJSON( ['data' => $this->data ] );
    }
    
    public function shop_view($dept = 'all')
    {
        $data = $this->remote_model->getData("http://vatap/mvc/public/api/getschedule/$dept"); 
        $data['content'] = view('production/schedule/shopview/index', ['data' => $data ]); 
        return view('template/index-shopview', $data ); 
    }

    public function set_operation_complete()
    {

        $user = auth()->user(); 
        
        $hasPermission =  $user->hasPermission('schedule.edit') || $user->inGroup('sadmin'); 

        if( !$hasPermission )
        {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Only users with schedule editing permissions can mark operations complete.', 
            ]);
        }

        $postData = $this->request->getPost();
        $wo_base_id = $postData['wo_base_id'];
        $wo_sub_id = $postData['wo_sub_id'];
        $seq_no = $postData['seq_no'];


        $result = $this->remote_model->getData("http://vatap/mvc/public/api/setcompletedworkorder/$wo_base_id/$wo_sub_id/$seq_no");

        $message = ($result) ? "Successfully marked WO: $wo_base_id / LEG: $wo_sub_id / SEQ NO: $seq_no complete" : "Failed to mark WO: $wo_base_id / LEG: $wo_sub_id / SEQ NO: $seq_no complete";
  
        return $this->response->setJSON([
            'success' => $result, 
            'message' => $message, 
        ]);
    }
}
