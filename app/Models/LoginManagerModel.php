<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginManagerModel extends Model
{
    protected $table            = 'tbl_logins';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'login', 'type_id', 'password', 'created_by'];


    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['encryptPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['encryptPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function getTypeIdAttribute($value)
    {
        return 'NEW VALUE'; 
    }

    public function encryptPassword( array $data)
    {
        if( isset($data['data']['password']))
        {
            $encrypter = \Config\Services::encrypter(); 
            $encrypted = $encrypter->encrypt($data['data']['password']);
            // Use base64 encoding instead of pg_escape_bytea
            $data['data']['password'] = base64_encode($encrypted);
        }

        return $data; 
    }

    public function decryptPassword($encryptedPassword)
    {
        $encrypter = \Config\Services::encrypter();
        try {
            // Decode from base64 instead of pg_unescape_bytea
            $binaryData = base64_decode($encryptedPassword);
            return $encrypter->decrypt($binaryData);
        } catch (\Exception $e) {
            return null; 
        }
    }

}
