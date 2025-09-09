<?php 

namespace App\Controllers\Games\Team;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\CollegeFootballService; 


class Index extends BaseController
{

    protected $cfb; 

    public function __construct()
    {
        $this->cfb = new CollegeFootballService(); 
    }

    public function index($teamId, $week)
    {
        $team = $this->get_data($teamId); 
        
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => 'dashboard' ],
                ['name' => 'College Football', 'is_active' => false, 'url' => 'cfb-football' ],
                ['name' => "Week {$week}", 'is_active' => false, 'url' => "cfb-football/week/{$week}" ],
				['name' => "{$team['school']}", 'is_active' => true, 'url' => '#']
            ],
            'title' => $team['school'], 
            'content' => view('games/team/index',['team' => $team]),
            'js' => view('games/team/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data( $teamId ) : array
    {
        $teams = $this->cfb->getTeams(); 
        $records = $this->cfb->getRecords(); 
        $week = $week ?? $this->cfb->getWeek(); 
        $games = $this->cfb->getGames(); 

        $team = [];
        foreach($teams as $row)
        {
            if($teamId == $row['id'])
            {
                $teamStats = $this->cfb->getTeamStats($row['school']) ?? []; 

                $combinedStats = []; 
                foreach($teamStats as $stat)
                {
                    $pattern = '/Opponent/';

                    if(!preg_match($pattern,$stat['statName']))
                    {
                        $combinedStats[$stat['statName']]['teamStat'] = $stat['statValue'];
                        $combinedStats[$stat['statName']]['statName'] = ucwords(preg_replace('/([a-z])([A-Z])/', '$1 $2', $stat['statName']));
                    } else {
                        $namePattern = '/(.*(?=Opponent))/'; 
                        $match = preg_match_all($namePattern, $stat['statName'], $name); 
                        $combinedStats[$name[0][0]]['opponentStat'] = $stat['statValue'];      
                    }
                } 

                 $row['stats'] = $combinedStats; 

                foreach($records as $record)
                {
                    if($record['teamId'] == $row['id'])
                    {
                        $row['record'] = $record;
                    }
                }

                $team = $row; 
            }
        }

        return $team; 
    }

}