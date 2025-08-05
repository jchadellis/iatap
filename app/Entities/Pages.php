<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Pages extends Entity
{
   protected $casts = [
        'access_level'      => 'json-array', 
   ];
}