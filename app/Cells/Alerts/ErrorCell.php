<?php

namespace App\Cells\Alerts;

use CodeIgniter\View\Cells\Cell;

class ErrorCell extends Cell
{
   public function render():string
   {
        return $this->view('error'); 
   }
}