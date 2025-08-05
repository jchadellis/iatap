<?php

namespace App\Controllers\Production\Spreadsheet;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    protected $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
                ['name' => 'Production', 'is_active' => false, 'url' => 'production'],
                ['name' => 'Spreadsheets', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Production', 
            'tool_cards' => [
                [
                    'name' => 'Rampmaster 5K Trucks', 
                    'description' => '5K Truck List', 
                    'url' => 'production/spreadsheet/trucks/5k', 
                    'btn_text' => 'Open', 
                    'icon' => 'components/icon/table-icon',
                    'color' => 'text-dark', 
                ],
                [
                    'name' => 'Rampmaster 7K Trucks', 
                    'description' => '7K Truck List', 
                    'url' => 'production/spreadsheet/trucks/7k', 
                    'btn_text' => 'Open', 
                    'icon' => 'components/icon/table-icon',
                    'color' => 'text-dark', 
                ],
                [
                    'name' => 'Hydrant Trucks', 
                    'description' => 'Hydrant List', 
                    'url' => 'production/spreadsheet/trucks/dhc', 
                    'btn_text' => 'Open', 
                    'icon' => 'components/icon/table-icon',
                    'color' => 'text-dark', 
                ],
            ],
            'js' => '', 
    ]; 


    public function index()
    {
        
        $this->data['content'] = view('production/spreadsheets/index', $this->data);

        return view('template/index', $this->data);


    }
}
