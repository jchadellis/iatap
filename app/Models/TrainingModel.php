<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingModel extends Model
{
    
    protected $table            = 'training_records';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['resource_id', 'employee_id', 'trainer_id'];

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
    protected $afterFind      = ['get_items'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    protected function get_items(array $data)
    {
        $db = \Config\Database::connect(); 
        $resources = $db->table('training_resource')->get()->getResult();
        $resource_types = $db->table('training_resource_type')->get()->getResult(); 
        
        $db = \Config\Database::connect('visual_cache'); 
        $employees = $db->table('employees')->get()->getResult(); 

        foreach($data['data'] as $row)
        {
            foreach($resources as $resource)
            {
                if( $resource->id == $row->resource_id )
                {
                    $row->resource_name = $resource->name;
                    $row->resource_description = $resource->description;
                }

                foreach($resource_types as $type )
                {
                    if( $resource->type_id == $type->id )
                    {
                        $row->resource_type = $type->name; 
                    }
                }
                
            }

            foreach($employees as $employee)
            {
                if( $employee->employee_id == $row->employee_id )
                {
                    $row->employee_name = $employee->first_name . ' ' . $employee->last_name; 
                }

                if( $employee->employee_id == $row->trainer_id )
                {
                    $row->trainer_name =  $employee->first_name . ' ' . $employee->last_name; 
                }
            }
            
            $row->training_date = (new \DateTime($row->created_at))->format('Y-m-d'); 
            
        }
        return $data; 
    }
}
