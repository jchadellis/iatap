<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DbBackupVisualCache extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:backup-visual-cache';
    protected $description = 'Backup the PostgreSQL database using pg_dump';

    public function run(array $params)
    {
        $dbConfig = config('Database')->default;

        $dbHost = $dbConfig['hostname'];
        $dbPort = $dbConfig['port'] ?? '5432';
        $dbName = 'visual_cache';
        $dbUser = $dbConfig['username'];
        $dbPass = $dbConfig['password'];

        $backupPath = WRITEPATH . 'backups/database/visual_cache_db/';
        $fileName   = $dbName . '_' . date('Ymd_His') . '.sql';
        $filePath   = $backupPath . $fileName;

        if (! is_dir($backupPath)) {
            mkdir($backupPath, 0770, true);
        }

        $pgDump = '/usr/lib/postgresql/16/bin/pg_dump';
        $command = "sudo -u iatapadmin PGPASSWORD=\"{$dbPass}\" $pgDump --schema-only -h {$dbHost} -p {$dbPort} -U {$dbUser} {$dbName} > {$filePath}";
        exec($command . " 2>&1", $output, $returnVar);

        if ($returnVar === 0) {
            CLI::write(1);
        } else {
            CLI::write(0);
        }
    }
}