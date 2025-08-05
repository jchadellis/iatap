<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomModel extends Model
{
    public function getAllowedFields(): array
    {
        return $this->allowedFields;
    }

    public function isGuest()
    {
        return false; 
    }
}