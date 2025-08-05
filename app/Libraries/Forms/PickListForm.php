<?php

namespace App\Libraries\Forms; 

use setasign\Fpdf\Fpdf; 
use setasign\Fpdi\Fpdi; 


class PickListForm extends Fpdi 
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
        
        $this->Cell(192, 10, 'Inventory Transactions - WO# '. $this->wo .' - ' . date('m/d/Y'), 0,1 , 'L');
        $this->SetXY(8,$headerY);
        $this->Cell(192, 10, 'Page '.$this->PageNo().' of {nb}', 0, 1, 'R');
    }




    public function print($output, $data)
    {
        // Load CI4 helper functions
        helper('number');
        helper('text'); 

        // Set work order for use in the document
        $this->wo = ($data[0]->trans_base_id) ?? 0; 

        // Initialize PDF document
        $this->AddPage();
        $this->AliasNbPages();

        // Configure base font and layout
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->SetAutoPageBreak(true, 10);

        // Print table header
        $y = 25; 
        $x = 8;
        $this->SetXY($x, $y);
        $this->Cell(20, 11, 'Trans ID', 1, 0, 'C');
        $this->Cell(40, 5.5, 'WO# / SUB ID', 1, 2, 'C');
        $this->Cell(40, 5.5, 'SEQ / PIECE#', 1, 2, 'C');
        $x = 68;
        $this->SetXY($x, $y);
        $this->Cell(92, 5.5, 'Part ID', 1, 2, 'C');
        $this->Cell(92, 5.5, 'Description', 1, 1, 'C');
        $this->SetXY($x+92,$y);
        $this->Cell(10, 11, 'ISS', 1, 0, 'C');
        $this->Cell(20, 11, 'Location', 1, 0, 'C');
        $this->MultiCell(10, 5.5, 'Loc. QTY', 1, 'C');

        // Loop through all data rows
        foreach ($data as $row)
        {
            $this->SetFont('Arial', '', 10);

            // Check if there's enough space left on the page
            $rowHeight = 24;
            if ($this->GetY() + $rowHeight > $this->PageBreakTrigger) {
                $this->AddPage();
            }

            $y = $this->GetY() + 2;
            $x = 8;
            $this->SetXY($x, $y);
            $this->Cell(20, 11, $row->trans_id, 1, 0, 'C');
            $this->Cell(40, 5.5, "$row->trans_base_id / $row->trans_sub_id", 1, 2, 'C');
            $this->Cell(40, 5.5, "$row->trans_seq_no / $row->trans_piece_no", 1, 2, 'C');

            // Print Part ID
            $x = 68;
            $this->SetXY($x, $y);
            $partID = $this->textTruncate($row->part_id, 24);
            $this->Cell(92, 5.5, $row->part_id, 1, 2, 'C');
            $this->Cell(92, 5.5, $row->part_description, 1,1, 'C');

            // // Conditionally wrap part description
            // $descStartX = $this->GetX();
            // $descStartY = $this->GetY();
            // $descWidth = $this->GetStringWidth($row->part_description);
            // if ($descWidth > 65) {
            //     $this->MultiCell(65, 5.5, $row->part_description, 1, 'C');
            //     $this->SetXY($descStartX + 65, $descStartY);
            // } else {
            //     $this->Cell(65, 11, $row->part_description, 1, 0, 'C');
            // }
            $this->SetXY($x+92, $y);
            $this->Cell(10, 11, $row->trans_qty, 1, 0, 'C');
            $locID = $this->textTruncate($row->trans_loc_id, 17);
            $this->Cell(20, 11, $locID, 1, 0, 'C');
            $this->Cell(10, 11, $row->part_loc_qty, 1, 1, 'C');

            // Deliver To section
            $deliverY = $this->GetY(); 
            $this->SetXY(8, $deliverY);
            $this->Cell(192, 9, '   Deliver To: ' . $row->trans_description, 1, 1, 'L');

            // Price display
            $this->SetFont('Arial', 'B', 10);
            $this->SetXY(8, $deliverY);
            $this->Cell(192, 9, 
                number_to_currency(round($row->trans_material_cost / $row->trans_qty, 2), 'USD', 'en_US', 2) .
                ' EA / ' . number_to_currency($row->trans_material_cost, 'USD', 'en_US', 2) . ' EXT',
                1, 1, 'R'
            );
        }

        // Footer section with printed timestamp and signature lines
        $this->SetXY(8, $this->GetY() + 10);
        $this->Cell(192, 9, 'Printed : ' . date('m/d/Y h:i A'), 0, 'L', 2);
        $this->Cell(192, 9, 'Delivered To:___________________________________    Received By: ___________________________________ ', 0);

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