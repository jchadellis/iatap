<?php
namespace App\Cells\SideCards;

use CodeIgniter\View\Cells\Cell;
use App\Models\HolidaysModel; 

class UpcomingEventsCell extends Cell
{
    //public $breadcrumbs = []; 

    public function render():string
    {
        $model = new HolidaysModel; 
        $data = $model->orderBy('start_date', 'asc')->findAll(); 
        return $this->view('upcoming_events',  ['data' => $data]);
    }
}