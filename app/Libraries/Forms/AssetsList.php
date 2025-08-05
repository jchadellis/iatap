<?php

namespace App\Libraries\Forms; 

use setasign\Fpdf\Fpdf; 
use setasign\Fpdi\Fpdi; 


class AssetsList extends Fpdi 
{ 
    //protected Fpdi $pdf;

    protected $wo  ; 

    public function __construct()
    {
        //$this->pdf = new Fpdi();
        parent::__construct('L', 'mm', array(279.4, 431.8));
    }

    public function Header()
    {
        // Set font and add a header
        $this->SetFont('Arial', 'B', 11);
        $headerY = $this->GetY(); 
        
        $pageWidth = $this->GetPageWidth() - $this->lMargin - $this->rMargin ; 

        $this->Cell($pageWidth, 10, 'Network Assets List'.' - ' . date('m/d/Y'), 0,1 , 'L');
        $this->SetXY(8,$headerY);
        $this->Cell($pageWidth, 10, 'Page '.$this->PageNo().' of {nb}', 0, 1, 'R');
    }

    public function print($output, $data, $orination = 'L')
    {

            $this->AddPage('Landscape');
            $this->AliasNbPages();

            $colWidth = ( $this->GetPageWidth() - $this->lMargin - $this->rMargin ) / 12;
            $columns = [
                'col_half_1' => $colWidth * .5, 
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

            // Configure base font and layout
            $this->SetFont('Arial', 'B', 9);
            $this->SetTextColor(0, 0, 0);
            $this->SetAutoPageBreak(true, 10);

            // Print table header
            $this->SetXY($this->lMargin, $this->GetY());
            $width = $this->GetPageWidth()-15; 
            $this->Cell($columns['col_half_1'], 8, 'Active', 1, 0, 'C');
            $this->Cell($columns['col_half_1'] + $columns['col_2'], 8, 'Display Name', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'Network Name', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'IP Add', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'MAC', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'Type', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'Dept', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'Make', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'Model', 1, 0, 'C');
            $this->Cell($columns['col_1'], 8, 'Room', 1, 0, 'C'); 
            $this->Cell($columns['col_1'], 8, 'OS', 1, 0, 'C'); 


            foreach ($data as $row)
            {
                $this->SetFont('Arial', '', 8);

                // Check if there's enough space left on the page
                $rowHeight = 8;
                if ($this->GetY() + $rowHeight > $this->PageBreakTrigger) {
                    $this->AddPage('L');
                }

                // Print table header
                $this->SetXY($this->lMargin, $this->GetY() + $rowHeight);
                $this->Cell($columns['col_half_1'], 8, ($row->is_active === 't') ? 'YES' : 'NO' , 1, 0, 'C');
                $this->Cell($columns['col_half_1'] + $columns['col_2'], 8, $row->display_name, 1, 0, 'C');
                $this->Cell($columns['col_1'], 8, $row->network_name, 1, 0, 'C');
                $this->Cell($columns['col_1'], 8, $row->ip_address, 1, 0, 'C');
                $this->Cell($columns['col_1'], 8, $row->mac, 1, 0, 'C');
                $this->Cell($columns['col_1'], 8, $this->textTruncate( $row->type , $columns['col_1']), 1, 0, 'C');
                
                $this->Cell($columns['col_1'], 8, $this->textTruncate( $row->department , $columns['col_1']) , 1, 0, 'C');
                $this->Cell($columns['col_1'], 8, $row->make, 1, 0, 'C');
                $this->Cell($columns['col_1'], 8, $row->model, 1, 0, 'C');
                $this->Cell($columns['col_1'], 8, $this->textTruncate( $row->physical_location , $columns['col_1']), 1, 0, 'C'); 
                $this->Cell($columns['col_1'], 8, $this->textTruncate( $row->operating_system, $columns['col_1']), 1, 0, 'C'); 
            }


        // Output file to disk
        $this->Output('F', WRITEPATH . 'uploads/assets/' . $output);
    }

    public function print_details($output, $data)
    {
        
                // Initialize PDF document
        $this->AddPage('L');
        $this->AliasNbPages();

        foreach($data as $row)
        {
            if($row->is_active === 'f')  continue; 

            if($row->type_id !== '1' && $row->type_id !== '2') continue; 

            $this->SetFont('Arial', '', 10);

            // Check if there's enough space left on the page
            $rowHeight = 24;
            if ($this->GetY() + $rowHeight > $this->PageBreakTrigger) {
                $this->AddPage('L');
            }

            $y = $this->GetY() + 9;
            $titleY = $y; 
            $x = 8;
            $this->SetXY($x, $y);
            $width = $this->GetPageWidth()-15; 
            $this->Cell($width, 9, '',  1, 2, 'C');
            $x = 8;
            $this->SetXY($x, $y);
            $this->SetFont('Arial', 'B', 10); 
            $this->Cell($width/6, 9, 'Display Name: ', 0, 0, 'C');
            $this->SetFont('Arial', '', 10); 
            $this->Cell($width/6, 9, $row->display_name, 0, 0, 'L'); 
            $this->SetFont('Arial', 'B', 10); 
            $this->Cell($width/6, 9, 'Make ', 0, 0, 'C');
            $this->SetFont('Arial', '', 10); 
            $this->Cell($width/6, 9, $row->make, 0, 0, 'L'); 
            $this->SetFont('Arial', 'B', 10); 
            $this->Cell($width/6, 9, 'Model ', 0, 0, 'C');
            $this->SetFont('Arial', '', 10); 
            $this->Cell($width/6, 9, $row->model, 0, 1, 'L'); 


            $x = 8;
            $this->SetX($x);
            $this->SetFont('Arial', 'B', 10); 
            $this->Cell($width/5, 9, 'Hostname', 1, 0, 'C');
            $this->Cell($width/5, 9, 'IP Address', 1, 0, 'C');
            $this->Cell($width/5, 9, 'MAC Address', 1, 0, 'C');
            $this->Cell($width/5, 9, 'Serial No.', 1, 0, 'C');
            $this->Cell($width/5, 9, 'Location', 1, 1, 'C');

            $x = 8;
            $this->SetX($x);
            $this->SetFont('Arial', '', 10); 
            $this->Cell($width/5, 9, strtoupper($row->network_name), 1, 0, 'C');
            $this->Cell($width/5, 9, $row->ip_address, 1, 0, 'C');
            $this->Cell($width/5, 9, strtoupper($row->mac), 1, 0, 'C');
            $this->Cell($width/5, 9, strtoupper($row->serial_no), 1, 0, 'C');
            $this->Cell($width/5, 9, $row->physical_location, 1, 1, 'C');


            $x = 8;
            $this->SetX($x);
            $this->SetFont('Arial', 'B', 10); 
            $this->Cell($width/5, 9, 'Departement', 1, 0, 'C');
            $this->Cell($width/5, 9, 'OS', 1, 0, 'C');
            $this->Cell($width/5, 9, 'RAM', 1, 0, 'C');
            $this->Cell($width/5, 9, 'Switch ID.', 1, 0, 'C');
            $this->Cell($width/5, 9, 'Port', 1, 1, 'C');

            $x = 8;
            $this->SetX($x);
            $this->SetFont('Arial', '', 10); 
            $this->Cell($width/5, 9, $row->department, 1, 0, 'C');
            $this->Cell($width/5, 9, $row->operating_system, 1, 0, 'C');
            $this->Cell($width/5, 9, strtoupper($row->ram), 1, 0, 'C');
            $this->Cell($width/5, 9, strtoupper(''), 1, 0, 'C');
            $this->Cell($width/5, 9, strtoupper(''), 1, 1, 'C');
        }

        // Configure base font and layout
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->SetAutoPageBreak(true, 10);
        $this->Output('F', WRITEPATH . 'uploads/assets/' . $output);
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


