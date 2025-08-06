<@php 

namespace {namespace};

use {useStatement};
use CodeIgniter\HTTP\ResponseInterface;

class {class} extends {extends}
{
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
    }
}