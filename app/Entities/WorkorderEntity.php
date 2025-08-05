<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WorkorderEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'want_date' => 'datetime', 
    ];
    
    public function getFormattedWantDate()
    {
        $raw = $this->attributes['want_date'] ?? null;
    
        if (!$raw) {
            return '';
        }
    
        try {
            $date = new \DateTime($raw); // expects Y-m-d or Y-m-d H:i:s
            return $date->format('m-d-Y');
        } catch (\Exception $e) {
            return '';
        }
    }

    public function getFormattedCreatedDate()
    {
        $raw = $this->attributes['created_date'] ?? null;
    
        if (!$raw) {
            return '';
        }
    
        try {
            $date = new \DateTime($raw); // expects Y-m-d or Y-m-d H:i:s
            return $date->format('m-d-Y');
        } catch (\Exception $e) {
            return '';
        }
    }

}
