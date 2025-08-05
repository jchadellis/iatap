<?php

namespace App\Controllers\Employee\Training;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TrainingModel; 
use App\Models\EmployeeModel; 

class Index extends BaseController
{
    public function __construct()
    {
        $this->trainingModel = new TrainingModel(); 
        $this->employees = new \App\Controllers\Employee\Index; 
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Employee Resources', 'is_active' => false, 'url' => 'employee/resources'],
            ['name' => 'Training Records', 'is_active' => true, 'url' => '#']
        ];
        
        $data = [
            'title' => 'Training Records', 
            'breadcrumbs' => $breadcrumbs, 
            'site_name' => 'iATAP', 
            'js' =>  view('employee/training/index.js.php'),
        ];
        $data['content'] = view('employee/training/index', ['employees' => $this->employees->list()]); 
        return view('template/index', $data) ;
    }

    public function get_data()
    {
        $data = $this->trainingModel->orderBy('created_at', 'DESC' )->findAll();

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // return '';
        return $this->response->setJSON( ['data' => $data ] );
    }



    // public function get_resources()
    // {
    //     $db = \Config\Database::connect('atapweb'); 

    //     $training_resources =  $db->table('training_resources')->get()->getResult();
    //     $employees = $this->employees->list(); 
    //     $training_records = $db->table('training')->get()->getResult(); 

    //     //     echo '<pre>';
    //     //     print_r($employees);
    //     //     echo '</pre>';
    //     // return; 

    //     $emp_array = []; 
    //     unset($employees[0]);

    //     foreach($employees as $employee)
    //     {
    //         $emp_array[]  = [
    //             'employee_id' => $employee->id, 
    //             'first_name'    => $employee->first_name, 
    //             'last_name'     => $employee->last_name,
    //             'middle_initial'    => $employee->middle_initial, 
    //             'addr_1'    => $employee->addr_1, 
    //             'addr_2'    => $employee->addr_2, 
    //             'addr_3'    => $employee->addr_3,
    //             'city'      => $employee->city, 
    //             'state'     => $employee->state, 
    //             'zipcode'   => $employee->zipcode,
    //             'phone'     => $employee->phone, 
    //             'department_id' => ($employee->department_id != 'NDLA') ? $employee->department_id : 0, 
    //             'active'     => $employee->active,
    //         ];
    //     }

    //      $employeeModel = new EmployeeModel(); 

    //     foreach( $emp_array as $item )
    //     {
    //         if($item['active'] == 'Y')
    //         {
    //             $employeeModel->save($item); 
    //             echo 'YES'. '</br>';
    //         }else{
    //             echo 'NO '. '</br>';
    //             $employeeModel->save($item); 
    //             $id = $employeeModel->insertID(); 
    //             $employeeModel->delete(['id' => $id]);  
    //         }
    //     }

    //     echo '<pre>';
    //     print_r($employeeModel->findAll()); 
    //     echo '</pre>';
    //     return ; 
    //     $db = \Config\Database::connect(); 

    //     /**
    //      * USED THIS TO NORMALIZED THE RESOURCE TYPES; 
    //      */

    //     // $types = [];
    //     // $names = [];
    //     // $descriptions = [];

    //     // foreach( $training_resources as $resource )
    //     // {
    //     //     if( !in_array($resource->resource_type, $types) )
    //     //     {
               
    //     //         switch( $resource->resource_type )
    //     //         {

    //     //             case 'ORIENTATION': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'New Hire Orienation', 
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'),
    //     //                 ]; 
    //     //                 break; 
    //     //             case 'RECURRING': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'Recurring Training', 
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'),
    //     //                 ];
    //     //                 break;
    //     //             case 'CERTIFICATION': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'Certification',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'),
    //     //                 ];
    //     //                 break;
    //     //             case 'EVALUATION': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'Employee Performance Evalutation',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-M': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Maintenance',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-Q': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Quaility',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-P': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Purchasing',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-S': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Sales',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-SR': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Shipping / Receiving',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-MFG': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Manufacturing',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-E': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Engineering',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-HR': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Human Resources',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-F': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Fabrication',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;
    //     //             case 'OTJ-W': 
    //     //                 $types[$resource->resource_type] =  [
    //     //                     'name' => $resource->resource_type, 
    //     //                     'description' => 'On The Job Training - Warehouse',
    //     //                     'created_at' => (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s'), 
    //     //                 ];
    //     //                 break;

    //     //             default:
    //     //                 break;
    //     //         }
    //     //     }            
    //     // }
        
       
    //     // foreach($types as $type)
    //     // {
    //     //     $db->table('training_resource_type')->insert($type); 
    //     // }
        
       
    //     $types = $db->table('training_resource_type')->get()->getResult(); 

    //     // foreach ($training_resources as $resource)
    //     // {
            
    //     // }

    //     /** 
    //      * USED TO GATHER EXISITNG RESOURCES AND NORMALIZE THE DATA THEN INSERT INTO NEW TABLE;
    //      */

    //     // $resources = [];

    //     // foreach($training_resources as $resource )
    //     // {

    //     //     $res_type = ''; 
    //     //     switch($resource->resource_type)
    //     //     {
    //     //         case 'MAINTENANCE':
    //     //             $res_type = 'OTJ-M'; 
    //     //             $description = $resource->resource_desc; 
    //     //             break; 
    //     //         case 'REFRIGERANT RECYCLING AND SERVICE PROCEDURES':
    //     //             $res_type = 'OTJ';
    //     //             $description = $resource->resource_desc; 
    //     //             break;
    //     //         case 'CERTIFICATION-EXPORT':
    //     //             $res_type = 'CERTIFICATION';
    //     //             $description = $resource->resource_desc; 
    //     //             break; 
    //     //         case 'R100':
    //     //             $res_type = 'OTJ';
    //     //             $description = $resource->resource_type . '-' . $resource->resource_desc; 
    //     //             break; 
    //     //         case 'R104':
    //     //             $res_type = 'OTJ';
    //     //             $description = $resource->resource_type . '-' . $resource->resource_desc; 
    //     //             break;         
    //     //         case 'R110':
    //     //             $res_type = 'OTJ';
    //     //             $description = $resource->resource_type . '-' . $resource->resource_desc; 
    //     //             break; 
    //     //         case 'R210':
    //     //             $res_type = 'OTJ';
    //     //             $description = $resource->resource_type . '-' . $resource->resource_desc; 
    //     //             break; 
    //     //         case 'OTJ - P':
    //     //             $res_type = 'OTJ-P';
    //     //             $description = $resource->resource_desc; 
    //     //             break; 
    //     //         case 'OTJ - S':
    //     //             $res_type = 'OTJ-S';
    //     //             $description = $resource->resource_desc; 
    //     //             break; 
    //     //         case 'OOTJ-E':
    //     //             $res_type = 'OTJ-E';
    //     //             $description = $resource->resource_desc; 
    //     //             break; 
    //     //         default:
    //     //             $res_type  = $resource->resource_type; 
    //     //             $description = $resource->resource_desc; 
    //     //             break;
                            
    //     //     }
            

    //     //     if( $res_type != '')
    //     //     {
    //     //         $resource->resource_type = $res_type; 
    //     //     }

    //     //     foreach ($types as $type)
    //     //     {
    //     //         if( trim( $resource->resource_type ) == $type->name )
    //     //         {
    //     //             $resource->type_id = $type->id;
    //     //         }
    //     //     }


    //     //     $creator  = trim($resource->train_res_fname) . ' ' . trim($resource->train_res_lname); 

    //     //     if( $resource->train_res_id ) 
    //     //     {
    //     //         $resource->creator_id = $resource->train_res_id;
    //     //     }else{
    //     //         $resource->creator_id = 2; 
    //     //         $creator = 'SHIFT SUPERVISOR'; 
    //     //     }
    //     //     $resource->name = $description;
    //     //     $resource->description = $res_type . '-' . $description . '-' . $creator; 
    //     //     $resource->created_at = (new \DateTime($resource->resource_date))->format('Y-m-d h:i:s');
    //     //     $resource->updated_at = ( new \DateTime())->format('Y-m-d h:i:s');

    //     // }

    //     // foreach($training_resources as $resource )
    //     // {
    //     //     $resources[] = [
    //     //         'type_id' => $resource->type_id, 
    //     //         'created_by' => $resource->creator_id, 
    //     //         'name'  => $resource->name,
    //     //         'description' => $resource->description,
    //     //         'created_at' => $resource->created_at, 
    //     //         'updated_at' => $resource->updated_at, 
    //     //     ];
    //     // }


    //     //$table = $db->table('training_resource'); 

    //     // foreach( $resources as $resource )
    //     // {
    //     //     $table->insert($resource); 
    //     // }

    //     $resources = $db->table('training_resource')->get()->getResult(); 

    //     $records = []; 

    //     foreach( $training_records as $record )
    //     {   

    //         if( $record->emp_id == '')
    //         {
    //             continue; 
    //         }

    //         $trainer = trim( trim($record->trainer_fname) .' '. trim($record->trainer_lname) );

    //         if( $record->trainer_id == 'SUPERVISOR' && $record->trainer_fname == ''){
    //             $record->trainer_id = 2; 
    //         }

    //         if( trim($record->trainer_id) == 'SUPERVISOR' && ($record->trainer_fname) != 'VISUAL')
    //         {
    //             foreach($employees as $employee)
    //             {
    //                 $name = trim($employee->first_name) .' '.  trim($employee->last_name); 

    //                 if( $trainer === $name  )
    //                 {
    //                     $record->trainer_id = trim($employee->id); 
    //                 }
    //             }

    //         } elseif( trim($record->trainer_id) == 'SUPERVISOR' && trim($record->trainer_fname) == 'VISUAL' ){
    //             $record->trainer_id = 1; 
    //         } elseif  ( trim($record->trainer_id) === 'SUPERVISOR') {
    //             echo 'SUPERVISORY' . '</br>'; 
    //         }elseif( trim($record->trainer_id == '' )){
    //             $record->trainer_id = 2; 
    //         } 

    //         foreach( $resources as $resource )
    //         {
    //             if( $record->training_description == $resource->name )
    //             {
    //                 $resource_id = $resource->id; 
    //             }
    //         }

    //         $records[] = (object) [
    //             'resource_id' => $resource_id,
    //             'employee_id' => $record->emp_id,
    //             'trainer_id' => $record->trainer_id,    
    //             'created_at' => ( new \DateTime($record->training_date))->format('Y-m-d h:i:s'), 
    //             'updated_at' => ($record->last_updated) ? ( new \DateTime($record->last_updated))->format('Y-m-d h:i:s') : ( new \DateTime())->format('Y-m-d h:i:s'),

 
    //         ];
    //     }

    //     $t_records = $db->table('training_records');

    //     foreach($records as $record)
    //     {
    //         try {
    //             //$t_records->insert($record);
    //            // echo "Successfully inserted record for employee ID: " . $record->employee_id . "<br>";
    //         } catch (\Exception $e) {
    //             echo '<div style="color: red; border: 1px solid red; padding: 10px; margin: 5px;">';
    //             echo '<strong>Database Error:</strong><br>';
    //             echo '<strong>Message:</strong> ' . $e->getMessage() . '<br>';
    //             echo '<strong>Code:</strong> ' . $e->getCode() . '<br>';
    //             echo '<strong>File:</strong> ' . $e->getFile() . '<br>';
    //             echo '<strong>Line:</strong> ' . $e->getLine() . '<br>';
    //             echo '<strong>Failed Record:</strong><br>';
    //             echo '<pre>' . print_r($record, true) . '</pre>';
    //             echo '</div>';
                
    //             // Log the error
    //             log_message('error', 'Training record insert failed: ' . $e->getMessage());
                
    //             // Continue with next record instead of stopping
    //             continue;
    //         }
    //     }

    //     $model = new TrainingModel();  
    //     echo '<pre>';
    //     print_r($this->trainingModel->findAll());
    //     echo '</pre>';
    // }



}
