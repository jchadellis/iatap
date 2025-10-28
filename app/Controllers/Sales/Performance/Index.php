<?php 

namespace App\Controllers\Sales\Performance;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{


    public function __construct()
    {
        // initialize default models and parameters
    }

    public function index()
    {
        $session = session(); 
        $url = base_url('sales/performance/data');
        $range = "Customer Order Performance Last 90 Days"; 
        if( $session->has('performance_start_date') )
        {
            $start = $session->get('performance_start_date');
            $end = $session->get('performance_end_date');
            $start = (new \DateTime($start))->format('m-d-Y'); 
            $end = (new \DateTime($end))->format('m-d-Y'); 
            $range = "Customer Order Performance <strong>{$start}</strong> to <strong>{$end}</strong>"; 
        }
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Sales', 'is_active' => false, 'url' => 'sales'],
				['name' => 'Performance', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Sales Performance', 
            'content' => view('sales/performance/index', ['url' => $url, 'range' => $range ]),
            'js' => view('sales/performance/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {

        $session = session();
        $model = new SqlbaseModel(); 
        $url = "http://vatap/mvc/public/api/getsalesperformance"; 

        if( $this->request->getMethod() === 'POST') 
        {
            $post = $this->request->getPost(); 
            $start = $post['start_date'];
            $end = $post['end_date'];
            $url = "http://vatap/mvc/public/api/getsalesperformance/0/{$start}/{$end}";
            $data = $model->getData($url); 

            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Vendor Performance</p><p><strong>{$start} - {$end}</strong></p>",
                ]
            );
        }
        
        if( $session->has('performance_start_date') )
        {
            $start = $session->get('performance_start_date');
            $end = $session->get('performance_end_date');
            $url = "http://vatap/mvc/public/api/getsalesperformance/0/{$start}/{$end}";

            $data = $model->getData($url); 
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Shipping Performance</p><p><strong>{$start} - {$end}</strong></p>",
                ]
            );

        }

        $data = $model->getData($url); 
        if( $data )
        {
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Shipping Performance</p><p><strong>Last 90 Days</strong></p>",
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

    public function get_spreadsheet()
    {
        $session = session();
        $model = new SqlbaseModel(); 
        $spreadsheet = new Spreadsheet();

        $url = "http://vatap/mvc/public/api/getsalesperformance"; 
        
        if( $session->has('performance_start_date') )
        {
            $start = $session->get('performance_start_date');
            $end = $session->get('performance_end_date');
            $url = "http://vatap/mvc/public/api/getsalesperformance/0/{$start}/{$end}";            
        }

        $data = $model->getData($url); 

        $start = isset($start)
            ? new \DateTime($start) 
            : (new \DateTime())->modify('-90 Days'); 


        $end = isset($end)
            ? new \DateTime($end) 
            : new \DateTime(); 

        //Setup Headers
        $headers = [
            'CUSTOMER ID', 
            'CUSTOMER NAME',
            'LINES',
            'ON TIME', 
            'LATE', 
            'ON TIME %', 
            'LATE %', 
        ];

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
                'startColor' => ['argb' => 'FF42699b'],
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

        //Alternate Row Style
        $alternateRowStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFdae9fc']
            ],
        ];

        //Totals Row Style
        $totalsRowStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF96ff9d']
            ],
        ];

        //Set the default style for the spreadsheet
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(12);

        $sheet = $spreadsheet->getActiveSheet();
        
        //Get the end column index
        $endColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));

        // Set sheet title
        $title = 'Sales Performance Report'; 
        $sheet->setTitle($title);

        $formatted_start = $start->format('Y-m-d'); 
        $formatted_end = $end->format('Y-m-d'); 
        $sheet->setCellValue('A1', 'Sales Performance - ' . $formatted_start . ' / ' .$formatted_end);
        $sheet->getStyle('A1:'.$endColumn .'1')->applyFromArray($titleStyle);
        $spreadsheet->getActiveSheet()->mergeCells('A1:'. $endColumn .'1');

        // Set headers
        $sheet->fromArray([$headers], null, 'A2');       
        $headerRange = 'A2:' . $endColumn . '2';
        $sheet->getStyle($headerRange)->applyFromArray($headerStyle);

        $row = 3;
        $total_lines = 0; 
        $total_on_time = 0; 
        $total_late = 0; 
        foreach($data as $item) {
            $total_lines += $item->total_lines; 
            $total_on_time += $item->total_on_time; 
            $total_late += $item->total_late; 

            $rowData = [
                $item->id ?? '',
                $item->name ?? '',
                $item->total_lines ?? '',
                $item->total_on_time ?? '',
                $item->total_late ?? '', 
                $item->on_time_percentage ? $item->on_time_percentage / 100 :  '', 
                $item->late_percentage ? $item->late_percentage / 100 : '', 
            ];
            
            // Add the rest of the row data starting from column B
            $sheet->fromArray([$rowData], null, 'A' . $row);
            $rowRange = 'A' . $row . ':' . $endColumn . $row;
            if( $row % 2 == 0){
                $sheet->getStyle($rowRange)->applyFromArray($alternateRowStyle);
            }

            $row++;
        }


        //Write totals to last row. 
        $totals = [
            'TOTALS:',
            $total_lines,
            $total_on_time, 
            $total_late, 
            ($total_on_time / $total_lines ),
            ($total_late / $total_lines)
        ];
        $rowRange = 'C' . $row . ':' . $endColumn . $row; 
        $sheet->fromArray([$totals], null, 'B' . $row);
        $sheet->getStyle($rowRange)->applyFromArray($totalsRowStyle);
        $rowRange = 'B' . $row . ':' . $endColumn . $row; 
        $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle( $rowRange)->getFont()->setBold(true);

        // Auto-size columns
        for($col = 1; $col <= count($headers); $col++) {
            $sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }

        $sheet->getStyle('F:G')
            ->getNumberFormat()
            ->setFormatCode('0.00%');

        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $filename = "Sales-Performance.xlsx";
        
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