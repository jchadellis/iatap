<?php 

namespace App\Controllers\Filemanager; 
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response; 

class Files extends Controller
{
    public function get_file(string $path, string $filename)
    {
        $basepath  = WRITEPATH .'uploads/'. trim($path, '/') . '/';
        $filename  = basename($filename); // Prevents directory traversal
        $filePath  = $basepath . $filename;

        if (!is_file($filePath) || !file_exists($filePath)) {
            return $this->response->setStatusCode(404, 'File Not Found');
        }

        return $this->response->download($filePath, null)->setFileName($filename);
    }

}