<?php

namespace App\Models;

use CodeIgniter\Model;

class BuildingModel extends Model
{
    protected $table = 'tbl_buildings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
    protected $returnType = 'object';
}