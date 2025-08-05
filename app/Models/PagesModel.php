<?php


namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
    protected $table      = 'tbl_pages';
    protected $primaryKey = 'id';
    protected $returnType = \App\Entities\Pages::class; 
    protected $useSoftDeletes = false; 
    protected $skipValidation = false; 

    protected function initialize()
    {
        $this->allowedFields = [
            'name', 'description', 'controller', 'method', 'icon', 'directory', 'url', 'uri', 'access_level'
        ];
    }
}