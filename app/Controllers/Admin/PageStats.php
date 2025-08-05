<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PageAccessLogs; 

class PageStats extends BaseController
{
    public function index()
    {

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Control Panel', 'is_active' => false, 'url' => '/sadmin/control-panel'],
            ['name' => 'Page Logs', 'is_active' => true, 'url' => '#'],
        ];

        $pagelogger = new PageAccessLogs(); 

        $entries =  $pagelogger->where('previous_url <>', 'current_url', false)->countAll();
        $distinct = $pagelogger->select('controller')->distinct()->findAll(); 
        $pages = []; 

        foreach($distinct as $page ) 
        {
            $user  =  $pagelogger->select('user_id, COUNT(*) as total')
                             ->where('controller', $page->controller)
                             ->groupBy('user_id')
                             ->orderBy('total', 'DESC')
                             ->limit(1)
                             ->first();

            $page = [
                'count' => count($pagelogger->where('controller', $page->controller)->findAll()), 
                'page' => $page->controller,
                'userCount' => $user->total,
                'userId' => $user->user_id,
                'userName' => auth()->user($user->user_id)->first_name . ' ' . auth()->user($user->user_id)->last_name , 
                'pageUrl' => $pagelogger->select('current_url')->where('controller', $page->controller)->first()->current_url,
                'lastAccess' => (new \DateTime($pagelogger->select('MAX(created_at) as last_accessed')->where('controller', $page->controller)->first()->last_accessed))->format('m-d-Y'),
            ];

            $pages[] = $page;
        }

        $log_stats = [
            'entries' => $entries, 
            'pages' => $pages,
        ];
        $data = [ 
            'title' => "Page Logs", 
            'breadcrumbs' => $breadcrumbs,
            'content' => view('admin/pagelog/index', ['data' => $pages]),
            'js' => '', 
        ];

        return view('template/index', $data);
    }
}
