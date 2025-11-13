<?php 

namespace App\Controllers\Production\WorkRequest;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WorkRequestModel; 
use App\Models\WorkRequestHistoryModel; 
use App\Commands\RefreshWorkRequest; 
use App\Models\UserModel; 

class Index extends BaseController
{

    private $email_list = [
        'patrick.porteous@atap.com', 
        'brad.davis@atap.com', 
        'tammy.lathem@atap.com', 
        'maverick.gidley@atap.com', 
        'robbyn.moncus@atap.com', 
        'tripp.schlereth@atap.com',
        'jason.key@atap.com'
    ];

    private $defaults = [
        'mfg_email' => 'tripp.schlereth@atap.com',
        'mfg_contact' => 'Trip Schlereth', 
    ];

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
        $urls = [
            'data' => base_url('production/work-request/data'),
            'edit' => base_url('production/work-request/get'), 
            'new' => base_url('production/work-request/new'),
            'save' => base_url('production/work-request/save'),

            'update' =>  base_url('production/work-request/update'), 
            'close' => base_url('production/work-request/close'), 
            
        ]; 
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Production', 'is_active' => false, 'url' => 'production'],
				['name' => 'Work Request', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Work Request', 
            'content' => view('production/work_request/index',[
                'cards' => $this->cards, 
                'demand_types' => $this->demand_types, 
                'inspection_levels' => $this->inspection_levels,
                'urls' => $urls, 
                'user' => auth()->user() ?? false ,
            ]
            ),
            'js' => view('production/work_request/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $workRequest = new WorkRequestModel(); 
        $history = new WorkRequestHistoryModel(); 

        $data = $workRequest->findAll(); 

        $user_model = new UserModel(); 

        if( $data )
        {

            foreach($data as $row){
                $row->created_by = ''; 
                $row->updated_by = ''; 

                if(!is_null($row->created_by_id)){
                    $user = $user_model->find($row->created_by_id); 
                    $row->created_by = ($user) ? $user->first_name . ' ' . $user->last_name : '';
                }
                 
                if(!is_null($row->updated_by_id)){
                    $user = $user_model->find($row->updated_by_id); 
                    $row->updated_by = ($user) ? $user->first_name . ' ' . $user->last_name : ''; 
                }

                $row->want_date = (new \DateTime($row->want_date))->format('Y-m-d'); 
                $row->created_at = (new \DateTime($row->created_at))->format('Y-m-d'); 
                foreach($this->demand_types as $type){
                    $row->demand_type = ($type->id === $row->demand_type) ? $type->name : $row->demand_type; 
                }
                $row->work_order = ($row->work_order === '' ) ? "<div class=\"d-flex justify-content-center\"><span class=\"badge text-bg-success\">New Request</span></div>" : $row->work_order; 

                $row->update_history = $history->where('work_request_id', $row->id)->findAll(); 
            }



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

    public function get()
    {
        $model = new WorkRequestModel();
        $history_model = new WorkRequestHistoryModel(); 
        $user_model = new UserModel(); 

        $json = $this->request->getJSON(); 
        $data = $model->find($json->id );

        $history = $history_model->where('work_request_id', $data->id )->findAll(); 

        if( $history )
        {
            foreach($history as $row){
                $user = $user_model->find($row->user_id); 
                $row->user = $user->first_name . ' ' . $user->last_name; 
                $row->email = $user->email; 
            }   

            $data->history = $history; 
        }

        $data->fields = $model->allowedFields;

        if( $data )
        {
            return $this->response->setJSON(
                [
                    'title' => 'Data Received', 
                    'body' => view('production/work_request/modal-body', ['data' => $data, 'demand_types' => $this->demand_types, 'inspection_levels' => $this->inspection_levels]), 
                    'success' => true,
                    'message' => 'Retrieved Data',
                ]
            );
        }
        return $this->response->setJSON(
            [
                'title' => 'Failed!',
                'success' => false, 
                'html' => "There was an error retrieving the Work Request : {$json->id}", 
            ]
        );  
    }

    public function new()
    {
        return $this->response->setJSON([
            'success' => true, 
            'body' => view('production/work_request/modal-body',
                [
                    'demand_types' => $this->demand_types, 
                    'inspection_levels' => $this->inspection_levels
                ]
            ),
        ]);
    }

    public function save(){
        $model = new WorkRequestModel(); 
        $history = new WorkRequestHistoryModel(); 
        $user_model = new UserModel(); 
        $validation = service('validation');
        $json = $this->request->getJSON();

        $rules = [
                'part_id' => [
                    'rules' => 'required', 
                    'label' => 'Part ID', 
                    'errors' => [
                        'required' => 'A <strong>{field}</strong> Part ID is required.', 
                    ]
                ],
                'demand_type' => [
                    'rules' => 'required', 
                    'label' => 'Demand Type', 
                    'errors' => ['required' => 'Please select a <strong>{$field}</strong> .' ], 
                ], 
                'demand_id' => [
                    'label' => 'Demand ID', 
                    'rules' => [ static function ($value, array $data): bool {
                        if (($data['demand_type'] ?? '') === '2') {
                            return ! empty($value);
                        }
                        return true;
                    }],
                    'errors' => [
                        0 => '<strong>Customer Order</strong> selected. A <strong>{field}</strong> is required.',
                    ]
                ],
                'want_date' => [
                    'label' => 'Due Date', 
                    'rules' => [
                        static function($value, $data) : bool {
                            $today = new \DateTime('today'); // normalize to midnight
                            $date = new \DateTime($value);
                            
                            // If this is an UPDATE (id exists), allow any date
                            if( isset($data['id']) ){
                                return true;
                            } 
                            
                            // If this is a NEW record (no id), date must be today or future
                            return $date >= $today;
                        }
                    ],
                    'errors' => [
                        0 => '<strong>{field}</strong> can not be in the past. Must be today or later.',
                    ]
                ]
        ];

        $validation->setRules($rules); 

        if( !$validation->run((array) $json) ){
            $errors = $validation->listErrors('list'); 
 
            return $this->response->setJSON(
                [
                    'success' => false,
                    'icon' => 'warning', 
                    'title' => 'Error', 
                    'html' => $errors, 
                    'data' => $json, 
                ]
            );
        }

        $old_data = isset($json->id) ? (array) $model->find($json->id) : null; 

        $user = auth()->user() ?? null; 

        $array = [
            'qty' => $json->qty ?? 0, 
            'part_id' => $json->part_id, 
            'want_date' => ( new \DateTime($json->want_date))->format('Y-m-d').' 00:00:00', 
            'demand_type' => $json->demand_type == '' ? : (int) $json->demand_type,   
            'demand_id' => $json->demand_id ?? '',
            'qar_signoff' => ( isset($json->qar_signoff) && $json->qar_signoff ) ? true : false, 
            'coc_required' => ( isset($json->coc_required) && $json->coc_required ) ? true : false, 
            'contract_no' => $json->contract_no ?? '', 
            'end_user' => $json->end_user ?? '',
            'dpas_rating' => $json->dpas_rating ?? '',
            'notes' => $json->notes, 
            'work_order' => $json->work_order ?? '', 
            'inspection_level_id' => $json->inspection_level == '' ? 1 : (int) $json->inspection_level,          
        ];

        $id = $json->id ?? null;

        if(isset($json->id)){
            $array['id'] = $json->id;
            $array['updated_by_id'] = $user->id;
        }else{
            $array['created_by_id'] = $user->id;
        }


        //Save / Update the work request 
        if( $model->save($array) ){
            if(!isset($json->id)) {
                //If the work request is new get the last insert id
                $id = $model->getInsertId();
            }
            $result = $model->find($id); 

            $new_data = (array) $result; 

            $result->has_updates = $this->update_history( $id, $old_data, $new_data); // Save any updates.

            //Format names and dates
            $result->created_by = ''; 
            $result->updated_by = ''; 

            if(!is_null($result->created_by_id)){
                $user = $user_model->find($result->created_by_id); 
                $result->created_by = ($user) ? $user->first_name . ' ' . $user->last_name : '';
            }
                
            if(!is_null($result->updated_by_id)){
                $user = $user_model->find($result->updated_by_id); 
                $result->updated_by = ($user) ? $user->first_name . ' ' . $user->last_name : ''; 
            }

            $result->want_date = (new \DateTime($result->want_date))->format('Y-m-d'); 
            $result->created_at = (new \DateTime($result->created_at))->format('Y-m-d'); 

            $result->work_order = ($result->work_order === '' ) ? "<span class=\"badge text-bg-success\">New Request</span>" : $result->work_order; 
            
            foreach($this->demand_types as $type){
                $result->demand_type = ($type->id === $result->demand_type) ? $type->name : $result->demand_type; 
            }


            return $this->response->setJSON(
                [
                    'success' => true,
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => 'The work request has been added.', 
                    'data' => $result, 
                ]
            );
        }

        return $this->response->setJSON(
            [
                'success' => false,
                'icon' => 'warning', 
                'title' => 'Error!', 
                'html' => 'The was an error saving request. Please try again.', 
                'data' => $json, 
            ]
        );

    }

    private function update_history($id, $old, $new){
        $history_model = new WorkRequestHistoryModel(); 
        $model = new WorkRequestModel(); 
        $data = array_diff_assoc($old, $new); 
        $user = auth()->user(); 

        $allowed_fields = $model->allowedFields; 

        $fields = []; 

        foreach($allowed_fields as $field )
        {
            $clean = ($field === 'demand_id') ?  $field : preg_replace('/_id$/', '', $field);

            $str = strtoupper(str_replace('_', ' ', $clean)); 

            $fields[$field] = $str; 
        }

        $changes = []; 
        $history = [];

        $field_map = [
            'qar_signoff'   => ['t' => 'YES', 'f' => 'NO'],
            'coc_required'  => ['t' => 'YES', 'f' => 'NO'],
        ];

        $updated = $data['updated_at']; 
        
        unset($data['updated_at']);

        if( count($data) > 0 )
        {
            foreach($data as $key => $item )
            {

                if (isset($field_map[$key])) {
                    $old[$key] = $field_map[$key][$old[$key]] ?? $old[$key];
                    $new[$key] = $field_map[$key][$new[$key]] ?? $new[$key];
                } elseif( $key === 'want_date') {
                    $old[$key] = date('Y-m-d', strtotime($old[$key]));
                    $new[$key] = date('Y-m-d', strtotime($new[$key]));   
                }

                $changes[] = ['field_name' => $fields[$key], 'old_value' => $old[$key] , 'new_value' => $new[$key] ]; 
            }
            $history = [
                'work_request_id' => $id, 
                'user_id' => $user->id, 
                'updated_fields' => json_encode($changes),
            ];

            $history_model->save($history); 
            return true; 
        } 

        return false; 
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

    public function restore_request()
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



    public function send_email()
    {
        $model = new WorkRequestModel(); 
        $history = new WorkRequestHistoryModel(); 

        $request = $model->find(115); 

        if(!$request) return; 
        $request->history = $history->where('work_request_id', $request->id)->findAll(); 

        foreach($this->demand_types as $type){
            if( $type->id === $request->demand_type){
                $request->demand_type = $type->name;
            } 
        }

        foreach($this->inspection_levels as $type){
            if( $type->id === $request->inspection_level){
                $request->inspection_type = $type->name; 
            }
        }


        print_array($request); 
        return; 
        
        $request->title = 'New Work Request : ' . $request->part_id; 
        $request_by = str_replace(['.', '@atap', 'com'], [' '], $request->request_by_email); 
        $request_by = ucwords(implode(' ', explode(' ', trim($request_by))));
        $request->requested_by = $request_by; 
        return view('production/work_request/email-body', ['request' => $request]); 
    }
}