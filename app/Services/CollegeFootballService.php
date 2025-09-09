<?php

namespace App\Services;

class CollegeFootballService
{
    protected $client;
    protected $cache;
    protected $apiKey = '4V/OWYH7xAKp58viZsRxZWROtaUFjXQWiTMZnXT4JbLIvP0uuHRqGW4ImxnxLgVu';

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
        $this->cache = \Config\Services::cache();
    }

    public function getGames(int $year = null, string $conference = 'sec', $week = null ): array
    {
        $year = $year ?? date('Y');
        $week = $week ?? $this->getWeek(); 
        $cacheKey = "cfb_games_{$year}_{$week}_{$conference}";
        $games = $this->cache->get($cacheKey);
        if (!$games) {
            $games = $this->fetchGames($year, $week, $conference);
            if ($games) {
                $this->cache->save($cacheKey, $games, 86400); // 24 hours
            }
        }
        
        return $games ?: [];
    }

    public function getTeams(int $year = null): array
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_teams_{$year}";
        
        $teams = $this->cache->get($cacheKey);
        
        if (!$teams) {
            $teams = $this->fetchTeams($year);
            if ($teams) {
                $this->cache->save($cacheKey, $teams, 86400); // 24 hours
            }
        }

        foreach($teams as &$team)
        {
            $team['ranks'] =  $this->getRank($team['school']);
        }
        
        return $teams ?: [];
    }

    public function getTeam(int $teamId = null): array
    {
        $year = $year ?? date('Y');

        $cacheKey = "cfb_team_{$teamId}";

        $this->clearTeamCache($teamId);

        $team = $this->cache->get($cacheKey);
        
        if (!$team) {
            $team = $this->fetchTeam($teamId);
            if ($team) {
                $this->cache->save($cacheKey, $team, 86400); // 24 hours
            }
        }
        
        return $team ?: [];
    }

    public function getTeamStats(string $teamName = null): array
    {
        $year = $year ?? date('Y');

        $cache_name = implode('_', explode(' ', $teamName)); 

        $cacheKey = "cfb_team_stats{$year}_{$cache_name}";

        $team = $this->cache->get($cacheKey);
        
        if (!$team) {
            $team = $this->fetchTeamStats($year, $teamName);
            if ($team) {
                $this->cache->save($cacheKey, $team, 86400); // 24 hours
            }
        }
        
        return $team ?: [];
    }

    public function getRecords(int $year = null, $conference = null, $team = null ): array
    {
        $year = $year ?? date('Y'); 
        $cacheKey = "cfb_records_{$year}"; 

        $records = $this->cache->get($cacheKey); 
        
        if(!$records)
        {
            $records = $this->fetchRecords($year, $conference, $team); 
            if($records)
            {
                $this->cache->save($cacheKey, $records, '43200'); 
            }
        }

        return $records ?: []; 
    }

    public function getRankings(int $year = null, int $week = null ): array
    {
        $year = $year ?? date('Y'); 
        $cacheKey = "cfb_rankings_{$year}"; 
        $week = $this->getWeek(); 

        $records = $this->cache->get($cacheKey); 
        
        if(!$records)
        {
            $records = $this->fetchRankings($year, $week); 
            if($records)
            {
                $this->cache->save($cacheKey, $records, '43200'); 
            }
        }

        return $records ?: []; 
    }

    public function getCalendar(int $year = null): array
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_calendar_{$year}";
        
        $calendar = $this->cache->get($cacheKey);
        
        if (!$calendar) {
            $calendar = $this->fetchCalendar($year);
            if ($calendar) {
                $this->cache->save($cacheKey, $calendar, 604800); // 7 days (1 week)
            }
        }
        
        return $calendar ?: [];
    }

    public function getWeeks(): array
    {
        $calendar = $this->getCalendar(); 
        $calendarLookup = array_column($calendar, null, 'startDate'); 
        $weeks = null; 

        foreach($calendarLookup as $key => $value)
        {
            $startDate = new \DateTime($key); 
            $endDate = new \DateTime($value['endDate']); 
            $todaysDate = new \DateTime(); 

            if ( $startDate <= $todaysDate) 
            {
                $weeks[] = $value['week']; 
            }
        }

        return $weeks; 
    }

    public function getWeek(): string
    {
        $calendar = $this->getCalendar(); 
        $calendarLookup = array_column($calendar, null, 'startDate'); 

        $week = null;
        foreach ($calendarLookup as $key => $value) {
            $startDate = new \DateTime($key); 
            $endDate = new \DateTime($value['endDate']);
            $todaysDate = new \DateTime();

            if ($startDate <= $todaysDate && $endDate >= $todaysDate) 
            {
                $week = $value['week'];
                break; 
            }
        }

        return $week; 
    }

    public function getRank($team): array
    {

        $rankings = $this->getRankings();

        $polls = $rankings[0]['polls']; 

        foreach($polls as $poll)
        {
            if($poll['poll'] === 'Coaches Poll')
            {
                foreach($poll['ranks'] as $rank)
                {
                    if($rank['school'] === $team)
                    {
                        $coaches_rank = $rank['rank'];
                    }
                }
            } elseif($poll['poll'] === 'AP Top 25'){
                foreach($poll['ranks'] as $rank)
                {
                    if($rank['school'] === $team)
                    {
                        $ap_rank = $rank['rank'];
                    }
                } 
            }
        }

        $ap_poll = $ap_rank ?? ''; 
        $coaches_poll = $coaches_rank ?? ''; 
        return ['ap' => $ap_poll, 'coaches' => $coaches_poll];
    }

    private function fetchGames(int $year, int $week, string $conference): ?array
    {
        $url = "https://api.collegefootballdata.com/games?year={$year}&week={$week}&seasonType=regular&conference={$conference}";
        return $this->makeApiRequest($url);
    }

    private function fetchTeams(int $year): ?array
    {
        $url = "https://api.collegefootballdata.com/teams?year={$year}";
        return $this->makeApiRequest($url);
    }

    private function fetchTeam(int $teamId): ?array
    {
        $url = "https://api.collegefootballdata.com/api/team?team={$teamId}";
        return $this->makeApiRequest($url);
    }

    private function fetchTeamStats(int $year, string $teamName): ?array
    {
        $teamName = rawurlencode($teamName);; 
        $url = "https://api.collegefootballdata.com/stats/season?year={$year}&team={$teamName}";
        return $this->makeApiRequest($url);
    }

    public function fetchRecords(int $year, ?string $conference, ?string $team): ?array
    {
        $url = "https://api.collegefootballdata.com/records?year={$year}";
        
        // Build query parameters array
        $params = [];
        
        if ($conference !== null) {
            $params[] = "conference=" . urlencode($conference);
        }
        
        if ($team !== null) {
            $params[] = "team=" . urlencode($team);
        }
        
        // Append parameters if any exist
        if (!empty($params)) {
            $url .= "&" . implode("&", $params);
        }
        
        return $this->makeApiRequest($url);
        
    }

    public function fetchRankings(int $year, int $week): ?array
    {
        $url = "https://api.collegefootballdata.com/rankings?year={$year}&week={$week}";
        return $this->makeApiRequest($url);
    }

    public function fetchCalendar(int $year):array
    {
        $url = "https://api.collegefootballdata.com/calendar?year={$year}";
        return $this->makeApiRequest($url);
    }

    public function clearGamesCache(int $year = null, string $conference = 'sec'): bool
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_games_{$year}_{$conference}";
        return $this->cache->delete($cacheKey);
    }

    public function clearTeamsCache(int $year = null): bool
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_teams_{$year}";
        return $this->cache->delete($cacheKey);
    }

    public function clearTeamCache(int $teamId = null): bool
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_team_{$teamId}";
        return $this->cache->delete($cacheKey);
    }

    public function clearTeamStatsCache(int $year = null, string $teamName = null) : bool
    {
        $cacheKey = "cfb_team_stats{$year}_{$teamName}";
        return $this->cache->delete($cacheKey);
    }

    public function clearRecordsCache(int $year = null): bool
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_records_{$year}";
        return $this->cache->delete($cacheKey);
    }

    public function clearRankingsCache(int $year = null): bool
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_rankings_{$year}";
        return $this->cache->delete($cacheKey);
    }

    public function clearCalendarCache(int $year = null): bool
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_calendar_{$year}";
        return $this->cache->delete($cacheKey);
    }

    public function clearAllCollegeFootballCache(): bool
    {
        // Clear current year caches
        $this->clearGamesCache();
        $this->clearTeamsCache();
        $this->clearRecordsCache();
        $this->clearCalendarCache();
        $this->clearTeamCache(); 
        $this->clearTeamStatsCache(); 
        $this->clearRankingsCache(); 
        return true;
    }

    private function makeApiRequest(string $url): ?array
    {
        try {
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'User-Agent'    => 'iATAP/1.0',
                    'Accept'        => 'application/json',
                    'Authorization' => "Bearer {$this->apiKey}",
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Request failed with status: ' . $response->getStatusCode());
            }

            return json_decode($response->getBody(), true);
            
        } catch (\Exception $e) {
            log_message('error', 'College Football API request failed: ' . $e->getMessage());
            return null;
        }
    }
}