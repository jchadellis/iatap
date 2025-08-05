<?php

namespace App\Libraries\Forms; 

use setasign\Fpdf\Fpdf; 
use setasign\Fpdi\Fpdi; 

class LeaveRequestForm extends Fpdi 
{ 
    protected Fpdi $pdf;

    public function __construct()
    {
        $this->pdf = new Fpdi();
    }

    public function getPdf( $sourcePdf = null, $outputPath = null, $data = [])
    {


        // Load page 1 of the existing PDF
        $pageCount = $this->pdf->setSourceFile($sourcePdf);
        $templateId = $this->pdf->importPage(1);
        $this->pdf->SetMargins(13, 20, 10);
 
        $this->pdf->AddPage();
        $this->pdf->useTemplate($templateId);

        // Set font and position
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->SetTextColor(255, 0, 0); // Red text

        //Current Date
        $y = 24.45; 
        $x = 43;
        $this->pdf->SetXY($x, $y);
        $this->pdf->Write(10, '00/00/0000' );

        $y = $y+10; 
        $x = $x + 2; 
        //Event Date
        $this->pdf->SetXY($x, $y);
        $this->pdf->Write(10, '00/00/0000');

        $y = $y+9.5; 
        $x = $x + 4; 
        //Employee Name
        $this->pdf->SetXY($x, $y);
        $this->pdf->Write(10, 'First Name, Last Name'); 

        //Badge Number
        $x = $x + 108; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'Badge Number'); 

        //Department
        $y = $y + 9.5; 
        $x = 42; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'Department'); 

        //Checkbox Illness Self
        $x = 37.15; 
        $y = 81.75; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Checkbox Illness Family
        $x = 37.10; 
        $y = $y + 9.75; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Checkbox Personal
        $x = 37.10; 
        $y = $y + 9.76; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 
        
        //Checkbox Vacation
        $x = 37.10; 
        $y = $y + 9.76; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Checkbox Other
        $x = 37.10; 
        $y = $y + 9.76; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 


        //Checkbox Bereavement
        $x = 131; 
        $y = 81.75; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Checkbox Jury Duty
        $x = 131; 
        $y = $y + 9.70; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Checkbox Dr Appt
        $x = 131; 
        $y = $y + 9.75; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Checkbox Leave Early
        $x = 131; 
        $y = $y + 9.75; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Clock Out Time
        $x = 131+42; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, '00:00'); 

        //Checkbox Arrive Late
        $x = 131; 
        $y = $y + 9.75; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Clock In Time
        $x = 131+42; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, '00:00'); 

        //Checkbox Free Day
        $x = 89.5; 
        $y = $y + 14.5; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'X'); 

        //Additional Comments
        $x = 13; 
        $y = $y + 10; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, 'Excepteur laboris Lorem commodo proident ipsum dolor sunt anim est elit aute dolore enim.ipsum dolor sunt anim est elit aute dolore enim.'); 

        //Date Free Day Taken
        $x = 38; 
        $y = $y+31.5; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, '00/00/0000'); 

        //Length of Vacation
        $x = 127; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, '5 Days'); 

        //Date Range Of Vacation
        $y = $y+9; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, '00/00/0000 - 00/00/0000'); 

        //Vacation Days Remaining 
        $x = $x + 20; 
        $y = $y+12; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, '5 Days'); 

        //Todays Date
        $x = $x + 20; 
        $y = $y+23; 
        $this->pdf->SetXY($x, $y); 
        $this->pdf->Write(10, '00/00/0000'); 

        // Save output
        $this->pdf->Output('F', WRITEPATH.'uploads/'. $outputPath);

    }

    public function getLeaveForm($sourcePdf = null, $outputPath = null, $data = [])
    {

        $fields = [
            'current_date'                  => ['x' => 43,      'y' => 24.45,  'text' => ''],
            'event_date'                    => ['x' => 45,      'y' => 34.45,  'text' => ''],
            'employee_name'                 => ['x' => 49,      'y' => 43.95,  'text' => ''],
            'badge_number'                  => ['x' => 157,     'y' => 43.95,  'text' => ''],
            'department'                    => ['x' => 42,      'y' => 53.45,  'text' => ''],

            'checkbox_free_day'             => ['x' => 89.5,    'y' => 135.2,  'text' => ''],
            'checkbox_vacation_day'         => ['x' => 37.10,   'y' => 111.02, 'text' => ''],
            'checkbox_leave_early'          => ['x' => 131,     'y' => 110.95, 'text' => ''],
            'checkbox_arrive_late'          => ['x' => 131,     'y' => 120.70, 'text' => ''],
            'checkbox_illness_self'         => ['x' => 37.15,   'y' => 81.75,  'text' => ''],
            'checkbox_illness_family'       => ['x' => 37.10,   'y' => 91.50,  'text' => ''],
            'checkbox_doctor'               => ['x' => 131,     'y' => 101.20, 'text' => ''],
            'checkbox_personal'             => ['x' => 37.10,   'y' => 101.26, 'text' => ''],
            'checkbox_jury_duty'            => ['x' => 131,     'y' => 91.45,  'text' => ''],
            'checkbox_bereavement'          => ['x' => 131,     'y' => 81.75,  'text' => ''],
            'checkbox_other'                => ['x' => 37.10,   'y' => 120.78, 'text' => ''],
            
            'clock_out_time'                => ['x' => 173,     'y' => 110.95, 'text' => ''],       
            'clock_in_time'                 => ['x' => 173,     'y' => 120.70, 'text' => ''],
        
            
            'additional_comments'           => ['x' => 13,      'y' => 145.2,  'text' => ''],
            'free_day_taken_date'           => ['x' => 38,      'y' => 176.7,  'text' => ''],
            'vacation_length'               => ['x' => 127,     'y' => 176.7,  'text' => ''],
            'vacation_date_range'           => ['x' => 127,     'y' => 185.7,  'text' => ''],
            'vacation_days_remaining'       => ['x' => 147,     'y' => 197.7,  'text' => ''],
            'todays_date'                   => ['x' => 167,     'y' => 220.7,  'text' => ''],
        ];


        if(!empty($data)) {
            foreach ($data as $key => $value) {
                if (isset($fields[$key])) {
                    $fields[$key] = array_merge($fields[$key], $value);
                } else {
                    $fields[$key] = $value;
                }
            }
        }

        // Load page 1 of the existing PDF
        $pageCount = $this->pdf->setSourceFile($sourcePdf);
        $templateId = $this->pdf->importPage(1);
        $this->pdf->SetMargins(13, 20, 10);
    
        $this->pdf->AddPage();
        $this->pdf->useTemplate($templateId);

        // Set font and position
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->SetTextColor(45,46,46); // Red text

        $this->writeFields($fields); 

        // Save output
        $this->pdf->Output('F', WRITEPATH.'uploads/'. $outputPath);

    }

    private function writeFields( $data = [], $lineHeight = 10, )
    {
        
        foreach($data as $key => $value )
        {
            if($key == 'clock_out_time' || $key == 'clock_in_time')
            {
                $date = date('Y-m-d'.$value['text']); 
                $time = new \DateTime($date); 

                $value['text'] = $time->format('h:i A');
            }

            $this->pdf->setXY( $value['x'], $value['y']);
            $this->pdf->Write($lineHeight, $value['text']);
        }
    }
}