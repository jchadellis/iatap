<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\WorkRequestModel; 
use App\Models\WorkRequestHistoryModel; 
use App\Models\SqlbaseModel; 

class RefreshWorkRequest extends BaseCommand
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
    protected $name = 'refresh:workrequest';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'refresh the work request caches';

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
        $workRequestModel = new WorkRequestModel();
        $workRequestHistoryModel = new WorkRequestHistoryModel(); 
        $remoteModel = new SqlbaseModel(); 

        $existingIds = array_column($workRequestModel->select('request_id')->findAll(), 'request_id'); 

        //Fetch closed and canceled work orders from sqlbase create an array of IDs to be used to filter if the work request is still open
        $workorders = $remoteModel->getData('http://vatap/mvc/public/api/getcompletedworkorders'); 
        $workOrderIds = array_column($workorders, 'base_id'); 

        //Fetch work request from old atatpweb table
        $db = \Config\Database::connect('atapweb');
        $builder = $db->table('work_request'); 
        $workRequest = $builder->where('request_status', 'R')->get()->getResult(); 

        $db = \Config\Database::connect(); 
        $builder = $db->table('work_request'); 
        $history_builder = $db->table('work_request_history'); 

        $completed = [];
        foreach($workRequest as $request)
        {
            if(in_array($request->work_order, $workOrderIds))
            {
                $completed[] = $request->request_id;
            }
        }
        
        $data = [];

        foreach($workRequest as $request )
        {
            //explode the update history into parts before parse and separated and inserting into work_request_update_history
            $request->history = explode('|', $request->update_history);            
            foreach($request->history as $key => $line)
            {
                if(empty(trim($line)))
                {
                    unset($request->history[$key]); 
                }
                $request->history = array_values($request->history); 
            }

            $request->history_parts = [];
            foreach($request->history as $historyLine) {
                // Updated pattern to handle any email domain and part numbers with dashes
                if (preg_match('/Modified:\s*([^-]+)-([^-]+@[^-]+\.[^-]+)-P\/N:\s*(.+?)-Due:\s*(.+)/', $historyLine, $matches)) {

                    $email = strtolower(trim($matches[2])); 

                    $emailParts = explode('@', $email);

                    $nameParts = explode('.', $emailParts[0]); 

                    $name = ucfirst($nameParts[0]) . ' ' . ucfirst($nameParts[1]);

                    $request->history_parts[] = [
                        'work_request_id'  => $request->request_id, 
                        'created_at' => (new \DateTime(trim($matches[1])))->format('Y-m-d'),
                        'updated_at' => (new \DateTime(trim($matches[1])))->format('Y-m-d'),
                        'updated_by' => $name, 
                        'updated_by_email' => strtolower(trim($matches[2])),
                        'part_id' => trim($matches[3]),
                        'due_date' => (new \DateTime(trim($matches[4])))->format('Y-m-d'),
                    ];
                }
            }
            
            //determine if the request_id is in the completed or cancel array from sqlbase work_orders. If so set the deleted_at date
            $key = array_search($request->work_order, $workOrderIds);

            if($key !== false)
            {
                
                $completed_date = $workorders[$key]->close_date;
                $request->deleted_at = $completed_date 
                                        ? (new \DateTime($completed_date))->format('Y-m-d H:i:s')
                                        : (new \DateTime())->format('Y-m-d H:i:s');
            }

            $demand_type_parts = explode('-', $request->demand_type);

            $last_history_key = end($request->history_parts); 
            
            $demand_type_id = ($demand_type_parts[0] == 'C/O') ? 1 : 2;  

            $data[] = [
                'request_id'        => $request->request_id, 
                'request_by_email'  => strtolower($request->request_email), 
                'part_id'           => $request->part_id, 
                'qty'               => $request->req_qty, 
                'due_date'          => $request->due_date, 
                'demand_id'         => ($demand_type_id == 2 ) ? null : $request->demand_id, 
                'demand_type'       => $demand_type_id,
                'qar'               => $request->qar, 
                'coc'               => $request->coc, 
                'contract'          => $request->contract, 
                'end_user'          => $request->end_user, 
                'dpas_rating'       => $request->dpas_rating, 
                'notes'             => $request->notes, 
                'work_order'        => $request->work_order, 
                'status'            => $request->request_status, 
                'mfg_email'         => strtolower($request->mfg_email),
                'updates'           => $request->history_parts, 
                'created_at'        => $request->request_date 
                                        ? ( new \DateTime( $request->request_date ))->format('Y-m-d 00:00:00') 
                                        : ( new \DateTime())->format('Y-m-d H:i:s'),
                'updated_at'        => $last_history_key
                                        ? ( new \DateTime($last_history_key['created_at']))->format('Y-m-d 00:00:00') 
                                        : ( new \DateTime())->format('Y-m-d H:i:s'), 
                'deleted_at'        => $request->deleted_at ?? null,
                //'is_applicable' => $demand_type_parts[1],
                // 'gov_signature'      => $request->gov_sign, 
                // 'customer_signature' => $request->cust_sign, 
                // 'atap_requirements'           => $request->atap_req, 
                // 'fmc_requirements'            => $request->fmc_req, 
                // 'test_rep_requiremnts'        => $request->test_rep_req,
                // 'fai_requirements'            => $request->fai_req, 
                // 'drawing_level' => $request->drawing_level,
                //'history'       => $request->history, 
            ];


        }

        CLI::write('Total Received Request = '.count($data) ); 

        foreach( $data as $row )
        {
            if( in_array($row['request_id'], $existingIds))
            {
                $work_request = $workRequestModel->where('request_id', $row['request_id'])->first(); 
                //print_r($work_request);
            }else{
                $updates = $row['updates'];
                unset($row['updates']);
                $builder->insert($row); 

                if($updates)
                {
                    foreach($updates as $update)
                    {   
                        $history_builder->insert($update);
                    }
                }
            }
        }

        CLI::write('Total After Insert = '. count( $workRequestModel->findAll() ) ); 

    }
}
