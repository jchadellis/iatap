<?php 

namespace App\Controllers\Sales\EDE\Report;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EdeReportModel; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{

    public function __construct()
    {
        $this->model = new EdeReportModel; 
    }

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

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
				['name' => 'EDE Report', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'EDE Report', 
            'content' => view('sales/ede/report/index'),
            'js' => view('sales/ede/report/index.js.php'), 
        ];

        return view('template/index-full', $data); 
    }

    public function get_data()
    {   
        
        $data = $this->model->findAll(); 

        foreach($data as $row)
        {
            $row->order_date = (new \DateTime($row->order_date))->format('Y-m-d'); 
            $row->due_date = (new \DateTime($row->due_date))->format('Y-m-d'); 
            $row->ship_date = ($row->ship_date != '' ) ? (new \DateTime($row->ship_date))->format('Y-m-d') : ''; 
            $row->recovery_date = ($row->recovery_date != '' ) ? (new \DateTime($row->recovery_date))->format('Y-m-d') : ''; 
        }
        return $this->response->setJSON(
            [
                'success' => true, 
                'data' => $data,
                'message' => 'Retrieved EDE Report', 
            ]
            );
    }

    public function get_spreadsheet()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(12);

        $sheet = $spreadsheet->getActiveSheet();
        
        // Set sheet title
        $title = 'EDE Item Report - '. date('mdY'); 
        $sheet->setTitle($title);
        
        // Get data from model
        $data = $this->model->findAll();
        
        // Headers
        $headers = array(
            'ORDER CLIN',
            'ORDER NUMBER & MOD',
            'REQUISITION NR',
            'NSN',
            'QTY',
            'UNIT $',
            'ORDER DATE',
            'DUE DATE',
            'RECOVERY DATE',
            'SHIP DATE',
            'DELIVERY LOC.',
            'TRACKING NUMBER',
            'COMMENTS',
            'NOUN',
            'P/N',
            'VENDOR NAME',
            'CAGE',
            'SIZE',
            'QTY SHIP',
            'CONFIGURATION CONTROL DATA',
            'QUALITY CONTROL DATA',
            'RISK ASSESSMENT COMPLETED',
            'ON TIME DELIVERY',
            'MITIG. STRAT.',
            'RISK RATING AFTER MIT.',
            'FINACIAL IMPACT',
            'MITIG. STRAT.',
            'RISK RATING AFTER MIT.',
            'LABOR CAPACITY',
            'MITIG. STRAT.',
            'RISK RATING AFTER MIT.',
            'FACILITY CAPACITY',
            'MITIG. STRAT.',
            'RISK RATING AFTER MIT.',
            'SUPPLIER',
            'MITIG. STRAT.',
            'RISK RATING AFTER MIT.',
            'PRODUCT LIABILITY',
            'MITIG. STRAT.',
            'RISK RATING AFTER MIT.'
        );
        
        // Style title
        $titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FF000000']
            ],
        ];

        // Style headers
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF9972E3']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF757575'],
                ],
            ],

        ];

        $highlightStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'F2F5A9']
            ],
        ];

        $alternateRowStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFF0F0F0']
            ],
        ];

        // Calculate the end column for 40 headers (column AN)
        $endColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));

        $sheet->setCellValue('A1', 'ATAP, Inc - FA8532-D-21-0004 - EDE Item Report ' . date('m/d/Y'));
        $sheet->getStyle('A1:'.$endColumn .'1')->applyFromArray($titleStyle);
        $spreadsheet->getActiveSheet()->mergeCells('A1:'. $endColumn .'1');

        // Set headers
        $sheet->fromArray([$headers], null, 'A2');       
        $headerRange = 'A2:' . $endColumn . '2';
        $sheet->getStyle($headerRange)->applyFromArray($headerStyle);
        
        // Add data rows
        $row = 3;
        foreach($data as $item) {
            $rowData = [
                $item->order_clin ?? '',
                $item->order_no_mod ?? '',
                $item->requisition_no ?? '',
                $item->nsn_no ?? '',
                $item->order_qty ?? '',
                $item->unit_price ?? '',
                ($item->order_date != '') ? (new \DateTime($item->order_date))->format('Y-m-d') : '',
                ($item->due_date != '') ? (new \DateTime($item->due_date))->format('Y-m-d') : '',
                ($item->recovery_date != '') ? (new \DateTime($item->recovery_date))->format('Y-m-d') : '',
                ($item->ship_date != '') ? (new \DateTime($item->ship_date))->format('Y-m-d') : '',
                $item->deliver_loc ?? '',
                $item->tracking_no ?? '',
                $item->comments ?? '',
                $item->noun ?? '',
                $item->part_no ?? '',
                $item->vendor_name ?? '',
                $item->vendor_cage_code ?? '',
                $item->vendor_bus_size ?? '',
                $item->qty_shipped ?? '',
                $item->config_control_data ?? '',
                $item->quality_control_data ?? '',
                $item->risk_assessment_complete ?? '',
                $item->on_time_delivery ?? '',
                $item->mitig_strat_a ?? '',
                $item->risk_rating_after_mit_a ?? '',
                $item->finacial_impact ?? '',
                $item->mitig_strat_b ?? '',
                $item->risk_rating_after_mit_b ?? '',
                $item->labor_capacity ?? '',
                $item->mitig_strat_c ?? '',
                $item->risk_rating_after_mit_c ?? '',
                $item->facility_capacity ?? '',
                $item->mitig_strat_d ?? '',
                $item->risk_rating_after_mit_d ?? '',
                $item->supplier ?? '',
                $item->mitig_strat_e ?? '',
                $item->risk_rating_after_mit_e ?? '',
                $item->product_liability ?? '',
                $item->mitig_strat_f ?? '',
                $item->risk_rating_after_mit_f ?? ''
            ];
            
            // Add the rest of the row data starting from column B
            $sheet->fromArray([$rowData], null, 'A' . $row);
            $rowRange = 'A' . $row . ':' . $endColumn . $row;
            if( $row % 2 == 0){
                $sheet->getStyle($rowRange)->applyFromArray($alternateRowStyle);
            }

            // Highlight row if recovery_date is not empty
            if ($item->recovery_date != '') {
                $sheet->getStyle($rowRange)->applyFromArray($highlightStyle);
            }

            $row++;
        }
        
        // Auto-size columns
        for($col = 1; $col <= count($headers); $col++) {
            $sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }
        
        $cellBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF757575'],
                ],
            ],
        ];

        //Add borders to data
        if ($row > 2) {
            $dataRange = 'A3:' . $endColumn . ($row - 1);
            $sheet->getStyle($dataRange)->applyFromArray($cellBorderStyle, false);
        }

        $sheet->getStyle('F1:F'.$row )->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
   
        // Freeze header row        
        $sheet->freezePane('A3'); 
        $sheet->setSelectedCell('A1');
        
        // Generate filename
        $filename = "SRC0004" . date('mdy') . "_MSR_A0007_ATAP_" . strtoupper(date('MY')) . ".xlsx";
        
        // Create temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);
        
        // Read and return file content
        $fileContent = file_get_contents($tempFile);
        unlink($tempFile);
        
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($fileContent);
    }
}