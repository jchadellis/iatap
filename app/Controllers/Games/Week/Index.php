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

        $recordsLookup = array_column($records, null, 'id'); 

        $games = array_map(function($game) use ($teamLookup, $recordsLookup) {
            $game['homeLogo'] = "http://a.espncdn.com/i/teamlogos/ncaa/500-dark/{$game['homeId']}.png";
            $game['awayLogo'] = "http://a.espncdn.com/i/teamlogos/ncaa/500/{$game['awayId']}.png";
            
            // Add team colors using the lookup array
            $game['homeColor'] = $teamLookup[$game['homeId']]['color'] ?? '#FFFFFF';
            $game['homeAlternateColor'] = $teamLookup[$game['homeId']]['alternateColor'] ?? '#FFFFFF';
            $game['awayColor'] = $teamLookup[$game['awayId']]['alternateColor'] ?? '#000000';
            // $game['homeName']  = $teamLookup[$game['homeId']]['alternateNames'][0];
            // $game['awayName']  = $teamLookup[$game['awayId']]['alternateNames'][0];
            $game['homeName']  = $teamLookup[$game['homeId']]['abbreviation'];
            $game['awayName']  = $teamLookup[$game['awayId']]['abbreviation'];
            
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
            ['name' => 'Season', 'is_active' => false, 'url' => 'games'],
            ['name' => "SEC Games Week {$week}", 'is_active' => true, 'url' => '#'],
        ];
        $content = view('components/game-cards', ['games' => $games]);
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'Dashboard', 
            'content' => $content, 
            'js' => ''
        ];
        return view('template/index', $data); 
    }

}