<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Enitites\WorkorderEnitity; 

class WorkOrderModel extends Model
{
    protected $DBGroup = 'visual_cache';
    protected $table            = 'workorder_cache';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\WorkorderEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['type', 'base_id', 'sub_id', 'seq_no', 'resource_id', 'status', 'part_id', 'desired_qty', 'received_qty', 'created_date', 'want_date', 'setup_hrs', 'run', 'run_hrs', 'service_id', 'description', 'qty_on_hand', 'qty_on_order'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [

    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = true;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
