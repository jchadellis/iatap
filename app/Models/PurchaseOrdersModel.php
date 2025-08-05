<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\PurchaseOrderEntity; 

class PurchaseOrdersModel extends Model
{
    protected $DBGroup = 'visual_cache';
    protected $table            = 'purchase_orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = \App\Entities\PurchaseOrderEntity::class; 
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'id', 
        'vendor_id',
        'name',
        'order_date',
        'contract_date',
        'desired_recv_date',
        'true_promise',
        'start_date',
        'end_date',
        'terms',
        'buyer',
        'status',
        'phone',
        'email',
        'confirmed',
        'contact_first_name',
        'contact_last_name',
        'followup_25_target_date',
        'followup_50_target_date',
        'followup_80_target_date',
        'followup_90_target_date',
        'followup_25_updated_at',
        'followup_50_updated_at',
        'followup_80_updated_at',
        'followup_90_updated_at',
        'last_vendor_update_at',
        'next_vendor_update_at',
        'percentage_complete',
        'completed', 
        'past_due',
    ];

    protected $useTimestamps = true; 

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected array $casts = [
      
    ];


    
}

