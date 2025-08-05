<?php

namespace Config;

use CodeIgniter\Config\BaseCommand;
use App\Commands\RefreshWorkorders;

class Commands extends BaseCommand
{
    public function commands()
    {
        return [
            'refresh:workorders' => RefreshWorkorders::class,
        ];
    }
}