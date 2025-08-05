<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RefreshPurchaseOrders extends BaseCommand
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
    protected $name = 'refresh:purchase_orders';

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

        $url = 'http://vatap/mvc/public/api/getpurchaseorders/';
        $response = file_get_contents($url); 

        if ($response === false) {
            CLI::error('Failed to fetch data from SQLBase Server'); 
            return; 
        }

        $data = json_decode($response, true); 

        if(!is_array($data))
        {
            CLI::error('Invalid JSON received'); 
            return; 
        }

        $db = db_connect('visual_cache'); 
        $builder = $db->table('purchase_orders'); 

        $existingIDs = $builder->select('id')->get()->getResultArray(); 
        $existingIDs = array_column($existingIDs,'id'); 

        $today = (new \DateTime()); 

        $incomingIDs = []; 
    
        foreach($data as $row){
            $row = (object) $row; 

            if( !isset($row->id))
            {
                CLI::error('Missing `id` in data row, skipping...'); 
                continue; 
            }


            $incomingIDs[] = $row->id;

            if(in_array($row->id, $existingIDs)){
                $row->updated_at = (new \DateTime())->format('Y-m-d h:i:s'); 
                $builder->upsert($row); 
                continue; 
            }

            $promise = new \DateTime($row->true_promise);
            $today = (new \DateTime()); 

            $milestones = [
                //new \DateTime(), 
                new \DateTime($row->followup_25_target_date),
                new \DateTime($row->followup_50_target_date),
                new \DateTime($row->followup_90_target_date)
            ];

            //Filter dates only want the ones before today
            $futureDates = array_filter($milestones, function($date) use($today){
                return $date > $today; 
            });
            
            usort($futureDates, function($a, $b){
                return $a <=> $b; 
            });

            
            $row->next_vendor_update_at = (isset($futureDates[0])) ? $futureDates[0]->format('Y-m-d h:i:s') : null; 
            //CLI::write( ($row->next_vendor_update_at) ?? 'NULL', 'blue') ;
            $row->created_at = (new \DateTime())->format('Y-m-d h:i:s'); 
     
            $builder->insert($row); 

        }

        if(!empty($incomingIDs))
        {   
            $builder->whereNotIn('id', $incomingIDs)->delete(); 
        }

        CLI::write('Purchase Orders cache updated. New inserts: '. (count($incomingIDs)) . ' -  Existing Rows: ' . (count($existingIDs)), 'green'); 

    }
}
