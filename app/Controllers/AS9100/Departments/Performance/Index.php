<?php 

namespace App\Controllers\AS9100\Departments\Performance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceTicketModel; 

class Index extends BaseController
{

    public function index()
    {

        $post = $this->request->getPost() ?? null; 

        $model = new ServiceTicketModel(); 
    
        $start = isset($post['start_date']) ? $post['start_date'] : (new \DateTime())->modify('-90 days')->format('Y-m-d') ;
        $end = isset($post['end_date']) ? $post['end_date'] :  (new \DateTime())->format('Y-m-d');

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'AS9100', 'is_active' => false, 'url' => 'as9100'],
				['name' => 'Engineering Performance', 'is_active' => true, 'url' => '#'],
            ],
            'title' => 'Department Performance', 
            'content' => view('as9100/departments/performance/index',[
                'engineering_data' => $model->getPerformance('engineering', $start, $end, true),
            ]),
            'js' => view('as9100/departments/performance//index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        
    }
}