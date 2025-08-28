<?php

namespace App\Controllers;

use App\Services\CollegeFootballService; 

class Dashboard extends BaseController
{
    public function index(): string
    {
        $cfbService = new CollegeFootballService();
        $week = $cfbService->getWeek();

        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => true, 'url' => '/dashboard'],
        ];

        $games = $this->get_games(); 
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => $breadcrumbs, 
            'title' => 'Dashboard', 
            'content' => view('dashboard/index', ['games' => '', 'week' => $week]), 
            'js' => ''
        ];
        return view('template/index', $data);
    }

    public function get_games()
    {
        $cfbService = new CollegeFootballService();
        
        $games = $cfbService->getGames(date('Y'), 'sec');
        $teams = $cfbService->getTeams();
        $records = $cfbService->getRecords(); 
        $week = $cfbService->getWeek(); 

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


    public function force_refresh_games()
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
        
        echo '<pre>'; 
        print_r($games); 
        echo '</pre>'; 
    }


}
