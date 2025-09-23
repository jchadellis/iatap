<?php 

namespace App\Controllers\Admin\BackupManager;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;

class Index extends BaseController
{
    protected $directory;
    protected $scriptBase;

    public function __construct()
    {
        $this->directory = WRITEPATH . 'backups/database'; 
        $this->scriptBase = '../public/assets/scripts/'; 
    }

    public function index()
    {
        helper('filesystem');
        $sitebackups = get_filenames($this->directory . '/site_db'); 
        $visualbackups = get_filenames($this->directory . '/visual_cache_db'); 
        $sitefilesbackups = get_filenames(WRITEPATH . 'backups/site_files');
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
                ['name' => 'Control Panel', 'is_active' => false, 'url' => 'sadmin/control-panel'],
                ['name' => 'Backup Manager', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Backup Manager', 
            'content' => view('admin/databasemanger/index', [
                'site_backups' => $sitebackups,
                'visual_backups' => $visualbackups,
                'site_files' => $sitefilesbackups
            ]),
            'js' => view('admin/databasemanger/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function download($subdir, $filename)
    {
        $filePath = $this->directory . '/' . $subdir . '/' . $filename; 
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        }
        return redirect()->back()->with('error', 'File not found.');
    }

    public function download_site($filename)
    {
        $filePath = WRITEPATH . 'backups/site_files/' . $filename; 
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        }
        return redirect()->back()->with('error', 'File not found.');
    }

    protected function runBackupScript($scriptName)
    {
        $scriptPath = $this->scriptBase . $scriptName;

        $output = [];
        $returnVar = 0;

        exec('sudo -u iatapadmin ' . $scriptPath, $output, $returnVar);

        // Log output for debugging
        log_message('info', "Backup script output: " . implode("\n", $output));

        if ($returnVar === 0) {
            return ['success' => true, 'message' => 'Backup Created'];
        }
        return ['success' => false, 'message' => 'Backup Failed', 'output' => $output];
    }

    public function backup_site()
    {
        $result = $this->runBackupScript('iatap_backup.sh');

        if ($result['success']) {
            return redirect()->back()->with('message', $result['message']);
        }

        return redirect()->back()->with('errors', $result['message']);
    }

    public function backup_visual()
    {
        $result = $this->runBackupScript('visual_cache_backup.sh');

        if ($result['success']) {
            return redirect()->back()->with('message', $result['message']);
        }
        return redirect()->back()->with('errors', $result['message']);
    }

    public function site_files_backup()
    {
        $result = $this->runBackupScript('site_backup.sh');

        if ($result['success']) {
            return redirect()->back()->with('message', $result['message']);
        }
        return redirect()->back()->with('errors', $result['message']);
    }
}