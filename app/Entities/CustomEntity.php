<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CustomEntity extends Entity
{

    public function getDirty()
    {
       $dirty = [];

        foreach ($this->toRawArray() as $key => $val) {
            if ($this->hasChanged($key)) {
                $dirty[$key] = $val;
            }
        } 

        return $dirty; 
    }
}