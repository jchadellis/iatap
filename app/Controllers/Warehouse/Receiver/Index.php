<?php

namespace App\Controllers\Warehouse\Receiver;
use App\Controllers\BaseController; 
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    protected $remoteModel;

    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Warehouse', 'is_active' => false, 'url' => 'warehouse'],
            ['name' => 'Recieved Receipts', 'is_active' => true, 'url' => '']
        ];

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Received Receipts', 'content' => view('warehouse/receiver/index')];
        $this->data['js'] = view('warehouse/receiver/index.js.php'); 
        return view('template/index', $this->data);
    }

    public function get_purchase_order($po_number)
    {
        
        $url = "http://vatap/mvc/public/api/getpurchaseorder/$po_number";
        $data['data'] = $this->remote_model->getData($url); 
        return print_array($data); 
        return view('warehouse/receiver/purchase_order', $data); 
    }
}