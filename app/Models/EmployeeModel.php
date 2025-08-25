<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $DBGroup = 'visual_cache';
    protected $table            = 'employees';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'employee_id', 
        'first_name', 
        'last_name', 
        'middle_initial', 
        'addr_1', 
        'addr_2', 
        'addr_3', 
        'city', 
        'state', 
        'zipcode', 
        'phone', 
        'department_id',
        'birth_date', 
        'hire_date', 
        'vac_days', 
        'free_days', 
        'last_visual_updated_at', 
        'group', 
        'work_email', 
        'personal_email', 
        'phone_2', 
        'contact_2', 
        'contact_2_relationship', 
        'contact_2_cell', 
        'contact_2_work', 
        'contact_2_home', 
        'contact_3', 
        'contact_3_relationship', 
        'contact_3_cell', 
        'contact_3_work', 
        'contact_3_home', 
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
