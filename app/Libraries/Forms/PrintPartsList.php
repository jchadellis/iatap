<?php

namespace App\Libraries\Forms; 

use setasign\Fpdf\Fpdf; 
use setasign\Fpdi\Fpdi; 


class PrintPartsList extends Fpdi 
{ 
    //protected Fpdi $pdf;

    protected $wo  ; 

    public function __construct()
    {
        //$this->pdf = new Fpdi();
        parent::__construct();
    }

    public function Header()
    {
        // Set font and add a header
        $this->SetFont('Arial', 'B', 11);
        $headerY = $this->GetY(); 
        
        $this->Cell(192, 10, 'Workorder: '. $this->wo .' /  Sub ID: '. $this->sub_id . ' / Seq No.: ' . $this->seq_no  . ' / Resource ID: ' . $this->resource_id . ' / Dept: ' . $this->dept , 0,1 , 'L');
        $this->SetXY(8,$headerY);
        $this->Cell(192, 10, 'Page '.$this->PageNo().' of {nb}', 0, 1, 'R');
    }




    public function print($output, $data, $dept)
    {

        // Load CI4 helper functions
        helper('number');
        helper('text'); 

        // Set work order for use in the document
        $this->wo = $data->base_id;
        $this->sub_id = $data->sub_id; 
        $this->seq_no = $data->sequence_no; 
        $this->resource_id = $data->resource_id;  
        $this->dept = $dept; 

        // Initialize PDF document
        $this->AddPage();
        $this->AliasNbPages();

        $colWidth = ( $this->GetPageWidth() - $this->lMargin - $this->rMargin ) / 12;
        $columns = [
            'col_1'   => $colWidth * 1, 
            'col_2'   => $colWidth * 2, 
            'col_3'   => $colWidth * 3, 
            'col_4'   => $colWidth * 4, 
            'col_5'   => $colWidth * 5, 
            'col_6'   => $colWidth * 6,
            'col_7'   => $colWidth * 7, 
            'col_8'   => $colWidth * 8, 
            'col_9'   => $colWidth * 9, 
            'col_10'  => $colWidth * 10,
            'col_11'  => $colWidth * 11, 
            'col_12'  => $colWidth * 12, 
        ];

        $col = (object) $columns; 

        $y = $this->GetY(); 
        $x = $this->GetX();


        $this->SetXY($x, $y);
        $this->Cell($col->col_3-15, 9, 'Part ID', 1, 0, 'C');
        $this->Cell($col->col_4+15, 9, 'Description', 1, 0, 'C');
        $this->Cell($col->col_2, 9,  'Required QTY', 1, 0, 'C');
        $this->Cell($col->col_2, 9, 'Requested QTY', 1, 0, 'C');
        $this->Cell($col->col_1, 9, 'Issued', 1, 1, 'C');


        foreach($data->requirements as $row)
        {
            $this->SetFont('Arial', 'B', 10);
            $rowHeight = 11;
            if ($this->GetY() + $rowHeight > $this->PageBreakTrigger) {
                $this->AddPage();
            }
            $y = $this->GetY();
            $x = $this->GetX();
            $this->SetXY($x, $y);

            $this->SetFont('Arial', '', 9);

            if($row->print){
                $this->Cell($col->col_3-15, 9, $row->part_id, 1, 0, 'C');
                $this->Cell($col->col_4+15, 9, $row->description, 1, 0, 'C');
                $this->Cell($col->col_2, 9, $row->calc_qty, 1, 0, 'C');
                $this->Cell($col->col_2, 9, $row->request_qty, 1, 0, 'C');
                $this->Cell($col->col_1, 9, ($row->issued) ? 'Yes' : 'No', 1, 1, 'C');
            }

        }

        // Footer section with printed timestamp and signature lines
        $this->SetXY($this->GetX(), $this->GetY() + 10);
        $this->Cell($col->col_12, 9, 'Printed : ' . date('m/d/Y h:i A'), 0, 'L', 2);
        $this->Cell($col->col_12, 9, " Delivered To: $data->deliver_to    Received By: __________________________________ ", 0);

        // Output file to disk
        $this->Output('F', WRITEPATH . 'uploads/' . $output);
    }

    public function textTruncate($text, $cellWidth, $ending = '...') {
        $ellipsisWidth = $this->GetStringWidth($ending);
        $textWidth = $this->GetStringWidth($text);

        if ($textWidth <= $cellWidth) {
            return $text; // Fits already
        }

        while ($this->GetStringWidth($text . $ending) > $cellWidth && mb_strlen($text) > 0) {
            $text = mb_substr($text, 0, -1); // Remove last character
        }

        return $text . $ending;
    }



}