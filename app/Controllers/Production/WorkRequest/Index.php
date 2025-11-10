<?php 

namespace App\Controllers\Purchasing\WorkRequest;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WorkRequestModel; 
use App\Models\WorkRequestHistoryModel; 
use App\Commands\RefreshWorkRequest; 

class Index extends BaseController
{

    private $cards = [
        [
            'name' => "", 
            'description' =>  '',
            'url' => '', 
            'btn_text' => '', 
            'icon' => '',
            'color' => '', 
        ],
    ];

    private $demand_types;
    private $inspection_levels;

    public function __construct()
    {
        $db = \Config\Database::connect(); 
        $this->demand_types = $db->table('work_request_demand_type')->select()->get()->getResult(); 
        $this->inspection_levels = $db->table('work_request_inspection_level')->select()->get()->getResult(); 
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Purchasing', 'is_active' => false, 'url' => 'purchasing'],
				['name' => 'Work Request', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Work Request', 
            'content' => view('purchasing/work_request/index',['cards' => $this->cards, 'demand_types' => $this->demand_types, 'inspection_levels' => $this->inspection_levels]),
            'js' => view('purchasing/work_request/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $workRequest = new WorkRequestModel(); 
        // $result = command('refresh:workrequest'); 
        // return; 
        $data = $workRequest->findAll(); 

        if( $data )
        {
            return $this->response->setJSON(
                [
                    'data' => $data, 
                    'success' => true,
                    'message' => 'Retrieved Data',
                ]
            );
        }
        return $this->response->setJSON(
            [
                'success' => false, 
                'message' => 'Failed to get data', 
            ]
        );  
    }

    public function get_request()
    {
        $workRequest = new WorkRequestModel();
        $workRequestHistory = new WorkRequestHistoryModel(); 

        $post = $this->request->getPost(); 
        $data = $workRequest->find($post['id']);
        $history = $workRequestHistory->where('work_request_id', $data->request_id )->findAll(); 

        if( $history )
        {
            $data->history = $history; 
        }

        if( $data )
        {
            return $this->response->setJSON(
                [
                    'title' => 'Data Received', 
                    'data' => view('purchasing/work_request/modal', ['data' => $data, 'demand_types' => $this->demand_types, 'inspection_levels' => $this->inspection_levels]), 
                    'success' => true,
                    'message' => 'Retrieved Data',
                ]
            );
        }
        return $this->response->setJSON(
            [
                'title' => 'Failed!',
                'success' => false, 
                'message' => "There was an error retrieving the Work Request : {$post['id']}", 
            ]
        );  
    }

    public function update_request()
    {
        $post = $this->request->getPost();
        $workRequest = new WorkRequestModel();
        $workRequestHistory = new WorkRequestHistoryModel(); 

        $user = auth()->user(); 

        $columns = [
            'id', 
            'work_order', 
            'mfg_email', 
            'request_id', 
            'request_by_email', 
            'qty', 
            'part_id', 
            'due_date', 
            'demand_type', 
            'demand_id', 
            'qar', 
            'coc', 
            'dpas_rating', 
            'contract', 
            'end_user', 
            'notes'
        ];

        $select = implode(',',$columns); 

        $currentData = $workRequest->select($select)->where('id', $post['id'])->get()->getResult('array');

        $currentRecord = $currentData[0] ?? [];

        $differance = array_diff($currentRecord, $post);
        
        if(count($differance) > 0 )
        {
            $fields = []; 
            foreach($differance as $field => $value) 
            {
                $backupData[$field] = $currentRecord[$field];
                $saveData[$field] = $post[$field];  
                $fields[] = $field; 
            }
            $saveData['id'] = $post['id'];

            if( $workRequest->save($saveData))
            {
                unset($saveData['id']);
                $update = [
                    'work_request_id' => $post['request_id'],
                    'updated_by'            => $user->first_name . ' ' . $user->last_name,  
                    'updated_by_email'      => $user->email,
                    'part_id'         => $post['part_id'], 
                    'due_date'        => $post['due_date'],
                    'updated_fields'  => json_encode($backupData),
                ];

                if( $workRequestHistory->save($update))
                {
                    return $this->response->setJSON(
                        [
                            'title' => 'Data Saved', 
                            'success' => true,
                            'message' => 'The work request was successfully updated.',
                        ]
                    );
                }

                return $this->response->setJSON(
                    [
                        'title' => 'Failed!',
                        'success' => false, 
                        'message' => "There was an error updating the Work Request : {$post['id']}", 
                    ]
                );  
            }
        }

        return $this->response->setJSON(
            [
                'title' => 'Warning',
                'success' => false, 
                'message' => "The submitted data has not changed. So, now changes where saved.", 
            ]
        );  

    }

    public function close_request()
    {
        $post = $this->request->getPost(); 
        $workRequest = new WorkRequestModel();
        $workRequestHistory = new WorkRequestHistoryModel(); 

        $user = auth()->user(); 

        $workRequest->delete($post['id']); 

        $workRequestHistory->save([
            'work_request_id' => $post['request_id'],
            'updated_by'            => $user->first_name . ' ' . $user->last_name,  
            'updated_by_email'      => $user->email,
            'part_id'         => null, 
            'due_date'        => null,
            'updated_fields'  => json_encode(['work_request' => 'closed']),
        ]);

        return $this->response->setJSON([
            'data' => null, 
            'title' => 'Closed', 
            'message' => 'Work Request was successfully closed.', 
            'success' => true, 
        ]);

    }

    public function retore_request()
    {
        $workRequest = new WorkRequestModel();
        
        $user = auth()->user(); 

        $workRequest->update($post['id'], ['deleted_at' => null]);
    
        $workRequestHistory->save([
            'work_request_id' => $post['request_id'],
            'updated_by'            => $user->first_name . ' ' . $user->last_name,  
            'updated_by_email'      => $user->email,
            'part_id'         => null, 
            'due_date'        => null,
            'updated_fields'  => json_encode(['work_request' => 're-opened']),
        ]);

        $data = $workRequest->find($post['id']);
        
        return $this->response->setJSON([
            'data' => $data, 
            'success' => true, 
            'message'   => 'Work Request was successfully restored.', 
        ]);

    }
}