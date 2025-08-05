<?php


namespace App\Models;

use CodeIgniter\Model;

class NetAssetsTypesModel extends Model 
{
    protected $table = 'tbl_net_asset_types';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
    protected $returnType = 'object';
}