<?php

namespace App\Cells\Template;

use CodeIgniter\View\Cells\Cell;
use App\Models\PagesModel; 
use App\Models\GuestModel; 

class SideBarCell extends Cell
{
    public function render():string
    {
        $user = auth()->user(); 

        if(is_null($user))
        {
            $user = new GuestModel(); 
        }

        $pages = new PagesModel();
        return $this->view('side_bar', ['pages' => $pages->orderBy('name')->findAll(), 'user'  => $user ]);
    }
}