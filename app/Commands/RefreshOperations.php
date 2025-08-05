<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RefreshOperations extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'refresh:operations';
    protected $description = 'Triggers host workorder cache refresh via HTTP.';

    public function run(array $params)
    {
        $url = 'http://vatap/mvc/public/api/getoperations';
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

        $db->table('operations_cache')->truncate(); 
        foreach($data as $row)
        {
            $db->table('operations_cache')->insert($row); 
        }
        CLI::write('Operations cache updated: ' . count($data) . ' rows.', 'green');
    }
}