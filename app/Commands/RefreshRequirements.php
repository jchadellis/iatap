<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RefreshRequirements extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'refresh:requirements';
    protected $description = 'Triggers host workorder requirements cache refresh via HTTP.';

    public function run( array $params)
    {
        $url = 'http://vatap/mvc/public/api/getrequirements/';
        $response = file_get_contents($url); 

        if( $response === false)
        {
            CLI::error('Failed to fetch data from SQLBase Server'); 
            return; 
        }

        $data = json_decode($response, true); 

        if(!is_array($data)){
            CLI::error('Invalid JSON received'); 
            return;
        }

        $db = db_connect('visual_cache'); 

        $db->table('requirements_cache')->truncate(); 
        foreach($data as $row)
        {
            $db->table('requirements_cache')->insert($row); 
        }
        CLI::write('Requirements cache updated: ' . count($data) . ' rows.', 'green');
    }
}