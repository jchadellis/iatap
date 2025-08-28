<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkRequestModel extends Model
{
    protected $table            = 'work_request';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'request_id',
        'request_email',
        'part_id',
        'qty', 
        'due_date',
        'demand_type',
        'demand_id',
        'is_applicable', 
        'qar',
        'coc',
        'contract',
        'end_user',
        'dpas_rating',
        'notes',
        'work_order',
        'mfg_email',
        //'history',
        //'status',
        // 'gov_sign',
        // 'cust_sign',
        // 'atap_req',
        // 'fmc_req',
        // 'test_rep_req',
        // 'fai_req',
        // 'drawing_level'
    ];

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
