<?php 

namespace App\Controllers\Quality\CorrectiveActions;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CorrectiveActionModel; 
use App\Models\EmployeeModel; 

class Index extends BaseController
{


    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $urls = [
            'data' => base_url('quality/corrective-actions/data'),
        ];
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Quality', 'is_active' => false, 'url' => 'quality'],
				['name' => 'Corrective Actions', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Corrective Actions', 
            'content' => view('quality/correctiveactions/index',['urls' => $urls]),
            'js' => view('quality/correctiveactions/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $session = session(); 
        $model = new CorrectiveActionModel(); 
        $employees = new EmployeeModel(); 
        $date = new \DateTime(); 

        $ids = $employees->select('employee_id, first_name, last_name')->findAll(); 
        $id_array = array_column($ids, null, 'employee_id'); 

        $results = $model
                ->orderBy('finding_date')
                ->findAll();

        foreach($results as $result)
        {
            $id = $result->primary_auditor; 

            if( array_key_exists($id, $id_array)){
                $result->name  = $id_array[$result->primary_auditor]->first_name . ' '. $id_array[$result->primary_auditor]->last_name;
            }else{
                $result->name = 'ETHAN WOODWARD';
            }

            $result->is_late = false; 
            
            if($result->status != 'Closed')
            {
                if($result->status === 'Review')
                {
                    $result->is_late = $this->check_late_status($result->target_date); 
                }

                if($result->status === 'Awaiting Review')
                {
                    $result->is_late = $this->check_late_status($result->review_date);
                }
            }
            $result->form_type = ucwords($result->form_type);
            $result->finding_date = $this->format_date($result->finding_date); 
            $result->review_date = $this->format_date($result->review_date); 
            $result->target_completion = $this->format_date($result->target_completion); 
        }

        if( $results )
        {
          return $this->response->setJSON([
                'success' => true, 
                'title' => 'Success', 
                'html' => "<p>Corrective Actions</p><p><strong>All Records</strong></p>",
                'icon' => 'info', 
                'data' => $results,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'title' => 'ERROR', 
            'html' => '<p>There was an error fetching NCPs</p>', 
            'icon' => 'warning', 
        ]);        
    }

    private function format_date($date)
    {
        $date = new \DateTime($date);
        $date = $date->format('m/d/Y'); 
        return $date;
    }

    private function check_late_status($date)
    {
        $today = new \DateTime(); 
        $date = new \DateTime($date);
        if($date < $today)
        {
            return true;
        }
        return false;
    }
}