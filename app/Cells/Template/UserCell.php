<?php

namespace App\Cells\Template;

use CodeIgniter\View\Cells\Cell;

class UserCell extends Cell
{
   public function render():string
   {
        $db = db_connect(); 
        $count = $db->table('tbl_service_tickets')->where('deleted_at', null )->where('type', 'it')->countAllResults(); 
        return $this->view('user', ['count' => $count ]); 
   }
}