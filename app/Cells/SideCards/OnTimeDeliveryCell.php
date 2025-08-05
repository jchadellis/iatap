<?php
namespace App\Cells\SideCards;

use CodeIgniter\View\Cells\Cell;

class OnTimeDeliveryCell extends Cell
{
    //public $breadcrumbs = []; 

    public function render():string
    {
       return $this->view('on_time_delivery');
    }
}