<?php

namespace App\Controllers\Production\Spreadsheet;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Truck extends BaseController
{
    public function index($truck_num)
    {

        $db = \Config\Database::connect('visual_cache');

        $truck = $db->table('workorder_cache')->where('id', $truck_num)->get()->getResult(); 

        $session = session(); 

        $truck_type = ($session->get('truck_type')) ? $session->get('truck_type') : (previous_url()->getSegments())[0]; 
        
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Production', 'is_active' => false, 'url' => 'production'],
                ['name' => 'Spreadsheets', 'is_active' => false, 'url' => 'production/spreadsheets'],
                ['name' =>  strtoupper($truck_type). ' Trucks', 'is_active' => false, 'url' => "production/spreadsheets/trucks/".$truck_type ],
                ['name' => $truck[0]->base_id, 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Production', 
        ]; 

        $data['content'] = view('production/spreadsheets/truck', ['truck' => $truck[0]]);
        $data['js'] = view('production/spreadsheets/truck.js.php', $data); 
        return view('template/index', $data); 

    }
}
