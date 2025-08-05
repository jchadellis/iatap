<?php


namespace App\Models;

use CodeIgniter\Model;

class DirectoryModel extends Model
{
    protected $table      = 'tbl_directory';
    protected $primaryKey = 'id';
    protected $returnType = \App\Entities\Directory::class; 
    protected $useSoftDeletes = false; 
    protected $skipValidation = false; 

    protected function initialize()
    {
        $this->allowedField = [
            'id', 'fname', 'lname', 'extension', 'ip_address', 'dept_id', 'location_id', 'category_id'
        ];
    }
}