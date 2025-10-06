<?php 

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController; 


class Index extends BaseController
{
    private $groups = ['purchasing'];

    private $tool_cards = [
            [
                'name' => "Work Orders Purchase Report", 
                'description' =>  'View work orders with purchase requirements, for parts, paint, material, chemical, fabricated and wire',
                'url' => 'purchasing/orders', 
                'btn_text' => 'View', 
                'icon' => 'components/icon/clipboard-document-icon',
                'color' => 'text-dark', 
                'btn-data' => 'data-bs-toggle="modal" data-bs-target="#po_count_modal"',
            ],
            [
                'name' => "Fabrication Purchasing", 
                'description' =>  'Fabrication Purchasing Report: Part Needs, Associated Work Orders',
                'url' => 'purchasing/fabrication-report', 
                'btn_text' => 'View Report', 
                'icon' => 'components/icon/wallet',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Paint Purchasing", 
                'description' =>  'Paint Purchasing Report: Need Dates, Work Orders, Vendors, Order Amounts, and Inventory Levels',
                'url' => 'purchasing/paint-report', 
                'btn_text' => 'View Report', 
                'icon' => 'components/icon/wallet',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Work Request Manager", 
                'description' =>  'View, edit and close Internal Work Request',
                'url' => 'purchasing/work-request', 
                'btn_text' => 'View Report', 
                'icon' => 'components/icon/inbox-arrow-down-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Vendor Tools", 
                'description' =>  'Tools related to vendors. List Vendors, Get Performance, See JCP Expirations',
                'url' => 'vendors/tools', 
                'btn_text' => 'View Tools', 
                'icon' => 'components/icon/building-storefront',
                'color' => 'text-dark', 
            ],
            [
                'name' => "PO Related Tools", 
                'description' =>  'View PO Bookings, Comformations, Count',
                'url' => 'purchasing/tools', 
                'btn_text' => 'Open Tools', 
                'icon' => 'components/icon/toolbox',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Safety Stock", 
                'description' =>  'Inventory Safety Stock Overview',
                'url' => 'purchasing/safety-stock', 
                'btn_text' => 'View Report', 
                'icon' => 'components/icon/warning-octagon',
                'color' => 'text-dark', 
            ],
    ]; 

    private $secured_cards = [
            [
                'name' => "Part Number Generator", 
                'description' =>  'Generate Material Part Numbers and Descriptions',
                'url' => 'purchasing/part/name/generator', 
                'btn_text' => 'Open', 
                'icon' => 'components/icon/tag-icon',
                'color' => 'text-dark', 
            ],
        ]; 

    private   $documents = [
        [
            'name' => 'DoD Export Control Form', 
            'url' => 'assets/documents/purchasing/ecda.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
            
        ],
        [
            'name' => 'Product Return Form', 
            'url' => 'assets/documents/purchasing/return-form.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
        ],
        [
            'name' => 'Product Return Process', 
            'url' => 'assets/documents/purchasing/return-process.pdf',
            'btn_text' => 'Download', 
            'icon' => 'components/icon/pdf-icon',
            'color' => 'text-dark',  
        ], 
    ];

    public function index($id = null): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => true, 'url' => '#'],
        ];

        $this->data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'Purchasing', 
            'js' => view('purchasing/index.js.php'),
            'content' => view('template/dept-index', [
                'tool_cards' => $this->tool_cards, 
                'documents' => $this->documents,
                'secured_cards' => $this->secured_cards,
                'groups' => $this->groups, 
                'user' => auth()->user(),
                'title' => 'Purchasing Dept.', 
            ])
        ];
        return view('template/index', $this->data);
    }

}