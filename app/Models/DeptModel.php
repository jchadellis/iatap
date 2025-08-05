<?php

namespace App\Models;

use CodeIgniter\Model;

class DeptModel extends Model
{
    protected $table = 'tbl_depts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
    protected $returnType = 'object';
}