<?php 

namespace App\Controllers\Games;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\CollegeFootballService; 

class Index extends BaseController
{

    private $cards = [];

    public function __construct()
    {
        $this->cfbService = new CollegeFootballService();
        $this->weeks = $this->cfbService->getWeeks(); 

        foreach($this->weeks as $key => $week){
            $this->cards[] = [
                'name' => "Week {$week}", 
                'description' =>  "SEC Football Week {$week}",
                'url' => "cfb-football/week/{$week}", 
                'btn_text' => 'Open', 
                'icon' => 'components/icon/calendar-days',
                'color' => 'text-dark', 
            ];
        }
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => '2025 Season', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'SEC College Football', 
            'content' => view('games/index',['cards' => $this->cards, 'weeks' => $this->weeks]),
            'js' => view('games/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function refresh_cache()
    {
        $cfbService = new CollegeFootballService();
        
        // Clear cache first
        $cfbService->clearGamesCache(date('Y'), 'sec');
        $cfbService->clearTeamsCache();
        $cfbService->clearRecordsCache(); 
        $cfbService->clearCalendarCache();
        
        // Then fetch fresh data
        $games = $cfbService->getGames(date('Y'), 'sec');
        $teams = $cfbService->getTeams();
        $records = $cfbService->getRecords(); 
        $weeks = $cfbService->getWeeks(); 
        
        echo '<pre>'; 
        print_r($records); 
        echo '</pre>'; 
    }

    public function get_teams()
    {
        print_array($this->cfbService->getTeams());
    }

    public function get_games()
    {
        print_array($this->cfbService->getGames(date('Y'), 'sec'));
    }

    public function get_records($year)
    {
        print_array($this->cfbService->getRecords($year)); 
    }

    public function get_weeks()
    {
        print_array($this->cfbService->getWeeks()); 
    }


    public function get_rankings()
    {
        print_array($this->cfbService->getRank('Alabama'));
    }
}