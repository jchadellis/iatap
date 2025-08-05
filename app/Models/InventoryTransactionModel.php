<?php
namespace App\Models; 

use CodeIgniter\Model; 

class InventoryTransactionModel extends Model
{
    protected $table      = 'printed_inventory_transactions';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $skipValidation = true; 
    protected $allowedFields = ['transaction_id', 'printed', 'delivered_to'];
}