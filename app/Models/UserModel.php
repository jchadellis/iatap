<?php
declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $returnType = \App\Entities\CustomUser::class;
    protected $skipValidation = true; 

    protected function initialize(): void
    {
        parent::initialize();
        
        $this->allowedFields = [
            $this->allowedFields[0], 
            'first_name', 
            'last_name',
            'employee_id',  
            'date_of_birth', 
            'extension', 
            'extension_ip', 
            'personal_email', 
            'email', 
            'street', 
            'street_2', 
            'city', 
            'state', 
            'zip', 
            'avatar',
            'avatar', 
            'emergency_contact', 
            'emergency_contact_relationship', 
            'emergency_contact_cell', 
            'emergency_contact_work', 
            'emergency_contact_home',
            'primary_number', 
            'secondary_number', 
            'host_id', 
            'dept_id', 
            'bldg_id',  
        ];
    }

    public function getAllowedFields(): array
    {
        return $this->allowedFields;
    }

}