<?php

namespace App\Cells\Alerts;

use CodeIgniter\View\Cells\Cell;

class MessageCell extends Cell
{
   public function render():string
   {
        return $this->view('message'); 
   }
}