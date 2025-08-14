<?php 

namespace App\Controllers\Purchasing\Tools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{
    

    private  $cards = [
            [
                'name' => "Purchase Order Bookings", 
                'description' =>  'View / Update PO status',
                'url' => 'purchasing/tools/bookings', 
                'btn_text' => 'View', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Purchase Order Confirmations", 
                'description' =>  'View Confirmation',
                'url' => 'purchasing/tools/confirmations', 
                'btn_text' => 'View', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Purchase Counts", 
                'description' =>  'View Confirmation',
                'url' => '#', 
                'btn_text' => 'View', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
                'btn-data' => 'data-bs-toggle="modal" data-bs-target="#po_count_modal"',
            ],
        ];

    public function __construct()
    {
        $this->remote = new SqlbaseModel(); 
    }

    public function index()
    {
        $date = (new \DateTime())->format('Y-m-d'); 
        $counts = $this->remote->getData("http://vatap/mvc/public/api/getpocounts/$date/0"); 


        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'Tools', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Purchasing Tools', 
            'content' => view('purchasing/tools/index', ['cards' => $this->cards, 'data' => $counts[0]]),
            'js' => view('purchasing/tools/index.js.php'), 
        ];

        return view('template/index', $data); 
    }


    public function get_data()
    {
        $date = $this->request->getGet('period'); 

        $date = ($date) ? (new \DateTime())->createFromFormat('m-d-Y', $date)->format('Y-m-d') : (new \DateTime())->format('Y-m-d'); 

        $data = $this->remote->getData("http://vatap/mvc/public/api/getpocounts/$date/0"); 

        return json_encode( $data ); 
    }



}