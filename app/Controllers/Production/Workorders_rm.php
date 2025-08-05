<?php

namespace App\Controllers\Production;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Forms\PrintPartsList; 
use App\Services\WorkOrderService; 

class Workorders extends BaseController
{  

    protected $depts = [
        ['description' => 'all', 'id' => [] ], 
        ['description' => 'teardown' ,  'id' => ['S100', 'RM100'] ],
        ['description' => 'sandblast' ,  'id' => ['S102', 'RM102'] ],
        ['description' => 'waterblast' ,  'id' => ['S103', 'RM103'] ],
        ['description' => 'steamclean' ,  'id' => ['S104', 'RM104'] ],
        ['description' => 'engine rebuild' ,  'id' => ['S110', 'RM110'] ],
        ['description' => 'tank modification' ,  'id' => ['S120', 'RM120'] ],
        ['description' => 'mig welding' ,  'id' => ['S130', 'RM130'] ],
        ['description' => 'general welding' ,  'id' => ['S132', 'RM132'] ],
        ['description' => 'tig welding' ,  'id' => ['S135', 'RM135'] ],
        ['description' => 'transmission build' ,  'id' => ['S140', 'RM140'] ],
        ['description' => 'pumps, cylinder rebuild' ,  'id' => ['S142', 'RM142'] ],
        ['description' => 'cambox rebuild' ,  'id' => ['S145', 'RM145'] ],
        ['description' => 'electrical' ,  'id' => ['S150', 'RM150'] ],
        ['description' => 'heater rebuild' ,  'id' => ['S152', 'RM152'] ],
        ['description' => 'air harness' ,  'id' => ['S153', 'RM153'] ],
        ['description' => 'tank, hood, feeder install' ,  'id' => ['S155', 'RM155'] ],
        ['description' => 'component rebuild' ,  'id' => ['S157', 'RM157'] ],
        ['description' => 'eng & trans, install' ,  'id' => ['S160', 'RM160'] ],
        ['description' => 'deck install' ,  'id' => ['S162', 'RM162'] ],
        ['description' => 'grasshopper' ,  'id' => ['S164', 'RM164'] ],
        ['description' => 'cab overhaul & install' ,  'id' => ['S165', 'RM165'] ],
        ['description' => 'valve, installation' ,  'id' => ['S170', 'RM170'] ],
        ['description' => 'hydraulic hoses' ,  'id' => ['S175', 'RM175'] ],
        ['description' => 'bogie' ,  'id' => ['S180', 'RM180'] ],
        ['description' => 'waterjet' ,  'id' => ['S190', 'RM190'] ],
        ['description' => 'sheetmetal' ,  'id' => ['S200', 'RM200'] ],
        ['description' => 'machine shop' ,  'id' => ['S205', 'RM205'] ],
        ['description' => 'testing' ,  'id' => ['S210', 'RM210'] ],
        ['description' => 'final & shop inspection' ,  'id' => ['S220', 'RM220'] ],
        ['description' => 'sand' ,  'id' => ['S230', 'RM230'] ],
        ['description' => 'paint' ,  'id' => ['S232', 'RM232'] ],
        ['description' => 'qc inspection' ,  'id' => ['S240', 'RM240'] ],
        ['description' => 'forklift' ,  'id' => ['S270', 'RM270'] ],
        ['description' => 'master resource' ,  'id' => ['S50', 'RM50'] ], 
        ['description' => 'assembly' ,  'id' => ['S90', 'RM90'] ], 
        ['description' => 'outside service' ,  'id' => ['SERVICE'] ] ]; 

     protected $colors = [
        'Deficient'     => 'table-danger',
        'On Order'      => 'table-primary',
        'Needs Issued'  => 'table-warning',
        'Ready'         => 'table-success',
     ];

    public function index()
    {
        $service = new WorkOrderService();
        $results = $service->getOpenWorkOrders(['S90', 'RM90']);

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Production', 'is_active' => false, 'url' => '/production'],
            ['name' => 'Work Orders - Assembly', 'is_active' => true, 'url' => '#']
        ];
 
        foreach ($results as $row) {
            $row->cell_color = isset($this->colors[$row->wo_status]) ? $this->colors[$row->wo_status] : 'text-muted';
        }

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Production', 'content' => view('production/workorders', ['data' => $results]) ];
        $this->data['js'] = view('production/workorders.js.php');

        return view('template/index-full', $this->data);       
    }

    public function get_workorder( $id, $dept )
    {
        $service = new WorkOrderService();
        $results = $service->getWorkorderDetails($id, $this->depts[$dept]['id']);
        return view('production/modal', ['data' => $results ]); 
    }
    
    public function print_list()
    {
        $db = \Config\Database::connect('visual_cache');
        $post = (object) $this->request->getPost();
    
        $operations = $db->query("SELECT * FROM operations_cache WHERE base_id = '$post->base_id' AND sub_id = '$post->sub_id' AND resource_id = '$post->resource_id' AND sequence_no = '$post->seq_no' ")->getResult();
    
        foreach ($operations as &$op) {
            $op->requirements = $db->query("SELECT * FROM requirements_cache WHERE base_id = '$op->base_id' AND sub_id = '$op->sub_id' AND seq_no = '$op->sequence_no' ")->getResult();
            //$op->requirements = $remoteModel->getData('http://vatap/mvc/public/api/getrequirements/'.$item->base_id.'/'.$op->sub_id.'/'.$op->sequence_no ); 
            $count = 0;
            foreach ($op->requirements as $row) {
                $row->request_qty = $post->request_qty[$count];
                $row->print = (isset($post->print[$row->part_id]) && $post->print[$row->part_id] == '1');
                $count++;
            }
        }
    
        $pdf = new PrintPartsList();
        $outputFile = date('mdY') . '.pdf';

        $data = $operations[0];

        $pdf->print($outputFile, $operations[0]);
    
        $fullpath = WRITEPATH . 'uploads/' . $outputFile;
    
        $email = \Config\Services::email();
        $email->setTo('jeremy.ellis@atap.com');
        $email->setSubject('Parts List Request PDF');
        $body = "Attached is the parts list request form for Work Order: $data->base_id / SUB ID: $data->sub_id / SEQUENCE NO: $data->sequence_no / RESOURCE ID: $data->resource_id"; 
        $email->setMessage(str_replace('<end>', '', $body));
        $email->attach($fullpath);
    
        if (!$email->send()) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Email failed to send: ' . $email->printDebugger(['headers'])
            ]);
        }
    
        $publicURL = base_url('downloads/' . $outputFile);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "The Parts Request was sent successfully. You can <a href='" . $publicURL . "' target=\"_blank\" >download a copy here</a>."
        ]);
    }
    
}
