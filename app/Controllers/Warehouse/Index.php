<?php

namespace App\Controllers\Warehouse;
use App\Controllers\BaseController; 
use App\Models\UserModel; 


class Index extends BaseController
{
    public function index(): string
    {   
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Warehouse', 'is_active' => true, 'url' => '#'],
        ];

        $tool_cards = [
            [
                'name' => 'Inventory Pick List', 
                'description' => 'View Inventory Transactions and Print Pick List', 
                'url' => 'warehouse/transactions', 
                'btn_text' => 'View List', 
                'icon' => 'components/icon/list-icon',
                'color' => 'text-dark', 
            ],
            [
                'name' => 'Warehouse Receipts', 
                'description' => 'View Inventory Transactions and Print Pick List', 
                'url' => 'warehouse/receipts', 
                'btn_text' => 'View List', 
                'icon' => 'components/icon/list-icon',
                'color' => 'text-dark', 
            ],
        ];

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Warehouse', 'content' => view('warehouse/index', ['tool_cards' => $tool_cards]) ];
        return view('template/index',$this->data); 
    }

}