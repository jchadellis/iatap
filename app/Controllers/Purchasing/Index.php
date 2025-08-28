<?php 

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController; 


class Index extends BaseController
{
    public function index($id = null): string
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Purchasing', 'is_active' => true, 'url' => '#'],
        ];

        $tool_cards = [
            [
                'name' => "Fabrication Purchasing", 
                'description' =>  'Fabrication Purchasing Report: Part Needs, Associated Work Orders',
                'url' => 'purchasing/fabrication-report', 
                'btn_text' => 'View Report', 
                'icon' => 'components/icon/dollar-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Paint Purchasing", 
                'description' =>  'Paint Purchasing Report: Need Dates, Work Orders, Vendors, Order Amounts, and Inventory Levels',
                'url' => 'purchasing/paint-report', 
                'btn_text' => 'View Report', 
                'icon' => 'components/icon/dollar-icon',
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
                'icon' => 'components/icon/tool-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => "Safety Stock", 
                'description' =>  'Inventory Safety Stock Overview',
                'url' => 'purchasing/safety-stock', 
                'btn_text' => 'View Report', 
                'icon' => 'components/icon/safety-icon',
                'color' => 'text-dark', 
            ],
        ]; 

        $documents = [
            [
                'name' => 'DoD Export Control Form', 
                'url' => 'assets/documents/purchasing/ecda.pdf',
                'btn_text' => 'Download', 
                'icon' => 'components/icon/pdf-icon',
                'color' => 'text-dark',  
                
            ],
            [
                'name' => 'Product Reture Form', 
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

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Purchasing', 'content' => view('purchase/index', ['tool_cards' => $tool_cards, 'documents' => $documents ]) ];
        return view('template/index', $this->data);
    }

}