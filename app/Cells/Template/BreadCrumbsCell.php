<?php

namespace App\Cells\Template;

use CodeIgniter\View\Cells\Cell;
use App\Modules\Breadcrumbs\Breadcrumbs;


class BreadCrumbsCell extends Cell
{
        public $breadcrumbs = []; 
        public $pervious = ''; 
        public $page = '';
}