<?php

namespace App\Models;

use CodeIgniter\Model;

class EdeReportModel extends Model
{
    protected $DBGroup = 'visual_cache';
    protected $table            = 'ede_report';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'order_clin', 'order_no_mod', 'requisition_no', 'nsn_no', 'order_qty', 'unit_price', 'order_date', 'due_date', 'recovery_date', 'ship_date', 'deliver_loc', 'shipment', 'tracking_no', 'comments', 'noun', 'part_no', 'vendor_name', 'vendor_cage_code', 'vendor_bus_size', 'qty_shipped', 'invoice_no', 'finacial_impact', 'mitig_strat_b'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
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
