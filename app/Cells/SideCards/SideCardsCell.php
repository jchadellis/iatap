<?php
namespace App\Cells\SideCards;

use CodeIgniter\View\Cells\Cell;

class SideCardsCell extends Cell
{
    //public $breadcrumbs = []; 

    public function render():string
    {
       return $this->view('side_cards');
    }
}