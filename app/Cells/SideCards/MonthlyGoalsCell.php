<?php
namespace App\Cells\SideCards;

use CodeIgniter\View\Cells\Cell;

class MonthlyGoalsCell extends Cell
{
    //public $breadcrumbs = []; 

    public function render():string
    {
       return $this->view('monthly_goals');
    }
}