<?php

namespace App\Controllers\Warehouse;
use App\Controllers\BaseController; 
use App\Models\UserModel; 


class Index extends BaseController
{

    private  $tool_cards = [
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

    private $secured_cards = []; 

    private $groups = ['warehouse'];

    public function index(): string
    {   
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Warehouse', 'is_active' => true, 'url' => '#'],
        ];


        $this->data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'Warehouse', 
            'content' => view('template/dept-index', [
                'tool_cards' => $this->tool_cards,
                'secured_cards' => $this->secured_cards, 
                'groups' => $this->groups, 
                'title' => 'Warehouse', 
                'user' => auth()->user() ?? null, 

                ]),
            ];
        return view('template/index',$this->data); 
    }

}