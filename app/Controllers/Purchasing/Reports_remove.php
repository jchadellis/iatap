<?php

namespace App\Controllers\Purchase;

use App\Controllers\BaseController; 
use App\Models\SqlbaseModel; 

class Reports extends BaseController
{

    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
    }

    public function get_paint_report()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Paint Report', 'is_active' => true, 'url' => '#'],
        ];

        $data = $remote_model->getData('http://vatap/mvc/public/api/getpaintreport'); 
        
        $data['data'] = $data; 
        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Paint Report', 'content' => view('purchase/paint-report', $data) ];
        $this->data['js'] = view('purchase/paint-report.js.php'); 

        return view('template/index', $this->data);
    }

    public function get_fabrication_report()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Fabrication Report', 'is_active' => true, 'url' => '#'],
        ];

        $data = $this->remote_model->getData('http://vatap/mvc/public/api/getfabreport'); 

        $data['data'] = $data; 

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Fabrication Report', 'content' =>  view('purchase/fabrication-report', $data) ];
        $this->data['js'] = view('purchase/fabrication-report.js.php'); 

        return view('template/index-full', $this->data);
    }

}