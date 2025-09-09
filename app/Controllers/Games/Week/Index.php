<?php 

namespace App\Controllers\Games\Week;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\CollegeFootballService; 

class Index extends BaseController
{


    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index($week)
    {
        $cfbService = new CollegeFootballService();
        
        $games = $cfbService->getGames(date('Y'), 'sec', $week);
        $teams = $cfbService->getTeams();
        $records = $cfbService->getRecords(); 
        $week = $week ?? $cfbService->getWeek(); 

        // Create a lookup array for teams by ID for O(1) access
        $teamLookup = array_column($teams, null, 'id');

        $recordsLookup = array_column($records, null, 'teamId'); 

        $games = array_map(function($game) use ($teamLookup, $recordsLookup) {
            $game['homeLogo'] = "http://a.espncdn.com/i/teamlogos/ncaa/500/{$game['homeId']}.png";
            $game['awayLogo'] = "http://a.espncdn.com/i/teamlogos/ncaa/500-dark/{$game['awayId']}.png";
            
            // Add team colors using the lookup array
            $game['homeColor'] = $teamLookup[$game['homeId']]['alternateColor'] ?? '#FFFFFF';
            $game['awayColor'] = $teamLookup[$game['awayId']]['color'] ?? '#000000';
            $game['homeName']  = $teamLookup[$game['homeId']]['abbreviation'];
            $game['awayName']  = $teamLookup[$game['awayId']]['abbreviation'];
            $game['homeRank']  = $teamLookup[$game['homeId']]['ranks']['ap'] ?? ''; 
            $game['awayRank']  = $teamLookup[$game['awayId']]['ranks']['ap'] ?? ''; 
            
            $game['homeTeamWins'] = $recordsLookup[$game['homeId']]['total']['wins'] ?? '0'; 
            $game['homeTeamLosses'] = $recordsLookup[$game['homeId']]['total']['losses'] ?? '0'; 
            $game['homeTeamConfWins'] = $recordsLookup[$game['homeId']]['conferenceGames']['wins'] ?? '0'; 
            $game['homeTeamConfLosses'] = $recordsLookup[$game['homeId']]['conferenceGames']['losses'] ?? '0';

            $game['awayTeamWins'] = $recordsLookup[$game['awayId']]['total']['wins'] ?? '0'; 
            $game['awayTeamLosses'] = $recordsLookup[$game['awayId']]['total']['losses'] ?? '0'; 
            $game['awayTeamConfWins'] = $recordsLookup[$game['awayId']]['conferenceGames']['wins'] ?? '0'; 
            $game['awayTeamConfLosses'] = $recordsLookup[$game['awayId']]['conferenceGames']['losses'] ?? '0';

            return $game;
        }, $games);

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'College Football', 'is_active' => false, 'url' => 'cfb-football'],
            ['name' => "Week {$week}", 'is_active' => true, 'url' => '#'],
        ];
        $content = view('components/game-cards', ['games' => $games, 'week' => $week]);
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => "Week {$week}", 
            'content' => $content, 
            'js' => ''
        ];
        return view('template/index', $data); 
    }

}