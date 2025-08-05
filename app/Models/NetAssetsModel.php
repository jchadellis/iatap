<?php

namespace App\Models;

use App\Models\CustomModel; 

class NetAssetsModel extends CustomModel
{
    protected $returnType = \App\Entities\NetAssets::class;
    protected $table = 'tbl_net_assets';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'display_name', 
        'network_name',
        'type_id', 
        'make', 
        'model', 
        'ram', 
        'contract_no', 
        'operating_system', 
        'processor', 
        'physical_location', 
        'switch_id', 
        'switch_port_no', 
        'dept_id', 
        'created_by_uid', 
        'ip_address',
        'ram', 
        'service_tag_no',
        'mac',
        'serial_no',
        'is_active',
        'has_web_login',
        'assigned_to'
    ];
    protected $skipValidation = true; 
    protected $useTimestamps = true; 

}