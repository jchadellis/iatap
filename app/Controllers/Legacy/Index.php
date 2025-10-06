<?php 

namespace App\Controllers\Legacy;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{

    private $purchasing_links = [
        [
            'name' => "PO Bookings", 
            'url' => 'http://vatap/purchasing/po-bookings.php', 
        ],
        [
            'name' => "PO Confirmations", 
            'url' => 'http://vatap/purchasing/po-confirmation.php', 
        ],
    ];

    private $maintenance_links = [
        [
            'name' => 'Maintenance Queue / Request',
            'url' => 'http://vatap/singleColumn.php?page=http://vatap/maintenance/upkeep.php&tree=maintenance&sheight=754', 
        ],
        [
            'name' => 'Woodshop Queue / Request',
            'url' => 'http://vatap/singleColumn.php?page=http://vatap/woodshop/woodshop-request.php&tree=maintenance&sheight=754',
        ],
    ];

    private $engineering_links = [
        [
            'name' => 'Eng Queue / Request', 
            'url' => 'http://vatap/fullWidth.php?page=http://vatap/engineering/view-eng-requests.php&tree=engineering&sheight=754'
        ],
    ];

    private $it_links = [
        [
            'name' => 'IT Queue / Request', 
            'url' => 'http://vatap/fullWidth.php?page=http://vatap/it/view-it-requests.php&tree=it&sheight=754',
        ],
    ];

    public function index()
    {
        $links['purchasing'] = $this->purchasing_links; 
        $links['maintenace'] = $this->maintenance_links; 
        $links['engineering'] = $this->engineering_links; 
        $links['it'] = $this->it_links; 
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'VATAP Legacy Links', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Legacy VATAP Tools', 
            'content' => view('legacy/index',['links' => $links]),
            'js' => view('legacy/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        
    }
}