<?php 

namespace App\Controllers\Test\Test;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'title' => 'Test', 
            'page' => 'Test', 
            'content' => view('test/test/index'),
            'js' => view('test/test/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function print_data()
    {
        $data = $this->request->getPost();
        $dates = explode(' to ', $data['date']); 

        print_array($dates);
        return; 
    }
}