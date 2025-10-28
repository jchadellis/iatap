<?php 

namespace App\Controllers\Quality\InternalAudit;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InternalAudit; 
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
            'data' => base_url('quality/internal-audit/data'), 
        ];
        
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Quality', 'is_active' => false, 'url' => 'quality'],
				['name' => 'Internal Audit Interviews', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Internal Audit Interviews', 
            'content' => view('quality/internalaudit/index',['urls' => $urls]),
            'js' => view('quality/internalaudit/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $session = session(); 
        $model = new InternalAudit(); 
        $employees = new EmployeeModel(); 
        $date = new \DateTime(); 

        $audit_processed_by = [
            "-1000" => 'DESKTOP AUDIT',
            "-1001" => "PROCESS REVIEW", 
        ];

        $ids = $employees->select('employee_id, first_name, last_name')->findAll(); 
        $id_array = array_column($ids, null, 'employee_id'); 

        $start = (clone $date)->modify('- 90 days')->format('Y-m-d');
        $end = $date->format('Y-m-d'); 

        if( $this->request->getMethod() === 'POST')
        {
            $post = $this->request->getPost(); 
            $start = $post['start_date'];
            $end = $post['end_date'];
        }

        if( $session->has('performance_start_date') )
        {
            $start = $session->getTempdata('performance_start_date'); 
            $end = $session->getTempdata('performance_end_date'); 
            
        }

        $results = $model
                ->where('interview_date >=', $start)
                ->where('interview_date <=', $end)
                //->orWhere('status <>', 'Closed')
                ->findAll();

        foreach($results as $result)
        {
            $id = $result->primary_auditor; 

            if( array_key_exists($id, $id_array)){
                $result->name  = $id_array[$result->primary_auditor]->first_name . ' '. $id_array[$result->primary_auditor]->last_name;
            }

            $standards = explode('|', trim($result->standard));

            $array = []; 
            foreach($standards as $standard)
            {
                if($standard !== '')
                {
                    $array[] = trim($standard); 
                }
            }

            $result->processed = isset($audit_processed_by[$result->employee_audited]) ? $audit_processed_by[$result->employee_audited] : '';

            $str = '<p  class="m-0 p-0">';

            $str .= implode('</p><p class="m-0 p-0">', $array); 

            $str .= '</p>'; 

            $result->standards = $str; 
        }

        if( $results )
        {
          return $this->response->setJSON([
                'success' => true, 
                'title' => 'Success', 
                'html' => "<p>Internal Audits for the period of</p><p><strong>{$start} - {$end}</strong></p>",
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
}