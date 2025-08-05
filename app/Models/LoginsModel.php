<?php


namespace App\Models;

use CodeIgniter\Model;

class LoginsModel extends CustomModel
{
    protected $table      = 'tbl_logins';
    protected $primaryKey = 'user_id';
    protected $returnType = \App\Entities\Logins::class; 
    protected $useSoftDeletes = false; 
    protected $skipValidation = true; 
    protected $useTimestamps = true; 
    protected $validationRules = [
        'username'      => 'required',
        'password'      => 'required', 
        'type_id'       => 'required|numeric',
    ];

    protected $allowedFields = [ 'id', 'user_id','username','type_id','password'];


}
