<@php 

namespace {namespace};

use {useStatement};
use CodeIgniter\HTTP\ResponseInterface;

class {class} extends {extends}
{


    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $page_data = []; 
        $data = [
            'site_name' => '{siteName}', 
            'breadcrumbs' => [
                {breadCrumbs}
            ],
            'title' => '{pageTitle}', 
            'content' => view('{viewPath}',[ 'data' => $page_data ]),
            'js' => view('{jsPath}'), 
        ];

        return view('template/index', $data); 
    }
}