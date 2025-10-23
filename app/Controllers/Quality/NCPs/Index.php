<?php 

namespace App\Controllers\Quality\NCPs;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NCPModel; 
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
            'data' => base_url('quality/ncp/data'), 
        ];

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Quality', 'is_active' => false, 'url' => 'quality'],
				['name' => 'NCPs', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'NCPs', 
            'content' => view('quality/ncps/index',[ 'urls' => $urls]),
            'js' => view('quality/ncps/index.js.php'), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data()
    {
        $session = session(); 
        $model = new NCPModel(); 
        $employees = new EmployeeModel(); 
        $date = new \DateTime(); 

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
                 ->where('finding_date >=', $start)
                 ->where('finding_date <=', $end)
                 ->orWhere('status <>', 'Closed')
                 ->findAll();


        foreach($results as $result)
        {
            $id = $result->primary_auditor; 

            if( array_key_exists($id, $id_array)){
                $result->name  = $id_array[$result->primary_auditor]->first_name . ' '. $id_array[$result->primary_auditor]->last_name;
            }


        }

        if( $results )
        {
          return $this->response->setJSON([
                'success' => true, 
                'title' => 'Success', 
                'html' => "<p>NCPs for the period of</p><p><strong>{$start} - {$end}</strong></p>",
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