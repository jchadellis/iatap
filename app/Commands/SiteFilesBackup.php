<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SiteFilesBackup extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'site:backup';
    protected $description = 'Backup iATAP server files';

    public function run(array $params)
    {
        set_time_limit(300);
        $backupPath = WRITEPATH . 'backups/site_files/';
        $date = date('Ymd_his'); 
        $exclude_list = '/var/www/iatap/public/assets/scripts/exclude-list.txt';
        $fileName   = "iatap_backup_{$date}.tar.gz";
        $filePath   = $backupPath . $fileName;
        $filesToBackup = '/var/www/iatap'; 
        $returnVar = 0; 

        if (! is_dir($backupPath)) {
            mkdir($backupPath, 0770, true);
        }
       
        $command = 'sudo tar -czvf ' . $filePath. '  -X '. $exclude_list . ' ' . $filesToBackup; 

        exec($command . " 2>&1", $output, $returnVar);

        if ($returnVar === 0) {
            CLI::write(1);
        } else {
            CLI::write(0);
        }
    }
}