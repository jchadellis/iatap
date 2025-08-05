<?php

namespace App\Controllers\Forms; 

use App\Libraries\Forms\LeaveRequestForm;
use CodeIgniter\Controller; 

class LeaveRequest extends Controller
{
    public function getPdf()
    {
        $pdf = new LeaveRequestForm(); 
        $sourceFile = 'assets/documents/employee/leave-form.pdf'; 
        $outputFile = $_GET['employee_name'].'-leave-request-'.date('mdY').'.pdf'; 
        if(!file_exists($sourceFile))
        {
            return 'source PDF not Found'; 
        }

        $postData = $this->request->getGet(); 

        $fields = [
            'current_date'           => ['text' =>  $postDate['current_date'] ?? date('m-d-Y')],
            'event_date'             => ['text' =>  $postDate['event_date'] ?? date('m-d-Y')],
            'employee_name'          => ['text' =>  $postData['employee_name'] ?? '' ],
            'badge_number'           => ['text' =>  $postData['badge_number'] ?? '' ],
            'department'             => ['text' =>  $postData['department'] ?? 'N/A'],

            'checkbox_free_day'        => ['text' =>  ($postData['checkbox_free_day'] ?? false ) ? 'X' : ''],
            'checkbox_vacation_day'    => ['text' =>  ($postData['checkbox_vacation_day'] ?? false) ? 'X' : ''],
            'checkbox_leave_early'      => ['text' =>  ($postData['checkbox_leave_early'] ?? false) ? 'X' : ''],
            'checkbox_arrive_late'     => ['text' =>  ($postData['checkbox_arrive_late'] ?? false) ? 'X' : ''],
            'checkbox_illness_self'    => ['text' =>  ($postData['checkbox_illness_self'] ?? false) ? 'X' : ''],
            'checkbox_illness_family'  => ['text' =>  ($postData['checkbox_illness_family'] ?? false) ? 'X' : ''],
            'checkbox_doctor'          => ['text' =>  ($postData['checkbox_doctor'] ?? false) ? 'X' : ''],
            'checkbox_personal'        => ['text' =>  ($postData['checkbox_personal'] ?? false) ? 'X' : ''],
            'checkbox_jury_duty'       => ['text' =>  ($postData['checkbox_jury_duty'] ?? false) ? 'X' : ''],
            'checkbox_bereavement'     => ['text' =>  ($postData['checkbox_bereavement'] ?? false) ? 'X' : ''],
            'checkbox_other'           => ['text' =>  ($postData['checkbox_other'] ?? false) ? 'X' : ''],
        

            'clock_out_time'         => ['text' => $postData['clock_out_early'] ?? ''],
            'clock_in_time'          => ['text' => $postData['clock_in_late'] ?? '' ],
        
            'additional_comments'    => ['text' => $postData['comments'] ?? ''],
            'free_day_taken_date'    => ['text' => $postData['free_day_taken_date'] ?? '' ],
            'vacation_length'        => ['text' => $postData['vacation_length'] ?? '' ],
            'vacation_date_range'    => ['text' => $postData['vacation_date_range'] ??  ''],
            'vacation_days_remaining'=> ['text' => $postData['vacation_days_remaining'] ?? '' ],
            'todays_date'            => ['text' => $postData['current_date'] ?? date('m-d-Y')],
        ];

        
        $pdf->getLeaveForm($sourceFile, $outputFile, $fields);

        return $this->response->download(WRITEPATH . 'uploads/' . $outputFile, null ); 
    }
}