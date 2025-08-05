<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RefreshVendorPerformce extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Custom';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'refresh:vendor_performance';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $url = 'http://vatap/mvc/public/api/getvendorperformance';
        $response = file_get_contents($url); 

        if( $response === false )
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

        $db->table('vendor_performance_cache')->truncate(); 
        
        foreach($data as $row)
        {
            $db->table('vendor_performance_cache')->insert($row); 
        }
        CLI::write('Vendor Performance cache updated: ' . count($data) . ' rows.', 'green');
    }
}
