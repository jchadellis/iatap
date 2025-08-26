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

    public function getGames(int $year = null, string $conference = 'sec'): array
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_games_{$year}_{$conference}";
        
        $games = $this->cache->get($cacheKey);
        $week = $this->getWeek(); 
        
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
        
        return $teams ?: [];
    }

    public function getRecords(int $year = null, string $conference = '', string $team = 'Aurburn' ): array
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

    public function fetchRecords(int $year, string $conference, string $team): ?array
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

    public function clearRecordsCache(int $year = null): bool
    {
        $year = $year ?? date('Y');
        $cacheKey = "cfb_records_{$year}";
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