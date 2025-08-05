<?php

namespace App\Controllers\Production\Spreadsheet;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Trucks extends BaseController
{

    public function index($prefix = 'dhc')
    {

        $session = session(); 
        $session->set('truck_type', $prefix); 

        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Production', 'is_active' => false, 'url' => 'production'],
                ['name' => 'Spreadsheets', 'is_active' => false, 'url' => 'production/spreadsheets'],
                ['name' => strtoupper($prefix) . ' Trucks', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Production', 
        ]; 

        $db = \Config\Database::connect('visual_cache'); 
        $trucks = $db 
            ->table('workorder_cache')
            ->like('base_id', strtoupper($prefix), 'after')
            ->where('sub_id', 0)
            ->get()
            ->getResult(); 
       
        $data['content'] = view('production/spreadsheets/trucks', ['trucks' => $trucks]);
        $data['js'] = view('production/spreadsheets/trucks.js.php', $data); 
        return view('template/index', $data); 

    }
}
