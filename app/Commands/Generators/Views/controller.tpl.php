<@php 

namespace {namespace};

use {useStatement};
use CodeIgniter\HTTP\ResponseInterface;

class {class} extends {extends}
{

    private $cards = [
        [
            'name' => "", 
            'description' =>  '',
            'url' => '', 
            'btn_text' => '', 
            'icon' => '',
            'color' => '', 
        ],
    ];

    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $data = [
            'site_name' => '{siteName}', 
            'breadcrumbs' => [
                {breadCrumbs}
            ],
            'title' => '{pageTitle}', 
            'content' => view('{viewPath}'),
            'js' => view('{jsPath}'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        
    }
}