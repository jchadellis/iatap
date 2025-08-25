<?php 

namespace App\Controllers\Production\Requirements\Paint;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RequirementsModel; 

class Index extends BaseController
{

    private $cards = [
        [
            'name' => "", 
            'description' =>  '',
            'url' => '', 
            'btn_text' => '', 
            'icon' => '',
            'color' => '', 
        ],
    ];

    public function __construct()
    {
        $this->requirements = new RequirementsModel(); 
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Production', 'is_active' => false, 'url' => 'production'],
				['name' => 'Paint Requirements', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Paint Requirements', 
            'content' => view('production/requirements/paint/index'),
            'js' => view('production/requirements/paint/index.js.php'), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data()
    {   
        $depts = ['RM232', 'S232', 'RM240', 'S240', 'SERVICE', 'RM102', 'S102', 'RM230', 'S230'];
        $depts = ['S232', 'S240', 'SERVICE', 'S102', 'S230'];
        $db = \Config\Database::connect('visual_cache');
        $builder = $db->table('operations_cache as o'); 
        $builder->join('requirements_cache as r', 'r.base_id = o.base_id AND r.sub_id = o.sub_id AND r.seq_no = o.sequence_no');
        $builder->where('r.status', 'R'); 
        $builder->whereIn('r.resource_id', $depts);
        $builder->where('r.planner_id IS NULL'); 
        $builder->where('r.issued_qty < r.calc_qty'); 
        $builder->where('r.qty_on_hand >= r.calc_qty'); 
        //$builder->distinct();
        $builder->orderBy('o.base_id'); 
        $builder->orderBy('o.sub_id', 'asc'); 
        $builder->orderBy('o.sequence_no', 'desc'); 
        $builder->orderBy('r.resource_id', 'asc'); 
        $query = $builder->get(); 

        return $this->response->setJSON(
            [
                'success' => true, 
                'data' => $query->getResult(), 
                'message' => 'Retrieved Data', 
            ]
        );
    }
}