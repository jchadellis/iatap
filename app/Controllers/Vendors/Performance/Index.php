<?php 

namespace App\Controllers\Vendors\Performance;

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
        $this->db = \Config\Database::connect('visual_cache');
        $this->data = $this->db->query("SELECT * FROM vendor_cache")->getResult(); 
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Puchasing', 'is_active' => false, 'url' => '/purchasing'],
            ['name' => 'Vendor Tools',  'is_active' => false, 'url' => '/vendors/tools'],
            ['name' => 'Performance',  'is_active' => true, 'url' => '#'],
        ];

        $data = $this->data; 
        $content = view('vendors/performance/index', ['data' => $data ]); 
        $js = view('vendors/performance/index.js.php'); 

        return view('template/index', ['content' => $content, 'title' => 'Vendor Performance', 'js' => $js , 'breadcrumbs' => $breadcrumbs]);
    }

    public function get_data()
    {        
        $session = session();
        $remote = new SqlbaseModel(); 

        if($this->request->getMethod() === 'POST')
        {
            $post = $this->request->getPost(); 
            $remote = new SqlbaseModel(); 
            $url = "http://vatap/mvc/public/api/vendor_performance/0/{$post['start_date']}/{$post['end_date']}";
            $start = (new \DateTime($post['start_date']))->format('m-d-Y'); 
            $end = (new \DateTime($post['end_date']))->format('m-d-Y'); 
            $data = $remote->getData($url); 
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Vendor Performance</p><p><strong>{$start} - {$end}</strong></p>",
                ]
            );
        }

        if($session->getTempdata('performance_start_date') !== null ){
            $start = $session->getTempdata('performance_start_date'); 
            $end = $session->getTempdata('performance_end_date'); 
            $url = "http://vatap/mvc/public/api/vendor_performance/0/{$start}/{$end}"; 
            $data = $remote->getData($url); 

            $start = (new \DateTime($start))->format('m-d-Y'); 
            $end = (new \DateTime($end))->format('m-d-Y');
            return $this->response->setJSON([
                    'success' => true, 
                    'data' => $data, 
                    'icon' => 'success', 
                    'title' => 'Success', 
                    'html' => "<p>Showing Vendor Performance</p><p><strong>{$start} - {$end}</strong></p>",
                ]
            );
        }
    
        foreach($this->data as $row)
        {
            //Convert date strings to date objects
            $row->open_date = new \DateTime($row->open_date); 
            $row->modify_date = new \DateTime($row->modify_date); 
        }

        return $this->response->setJSON([
            'success' => true, 
            'data' => $this->data,
            'icon' => 'success', 
            'title' => 'Success', 
            'html' => "<p>Showing Vendor Performance</p><p><strong>Last 90 days</strong></p>",
        ]); 
    }

    public function get_vendor()
    {
        $remote = new SqlbaseModel(); 
        $data = $this->request->getPost(); 
        $db = db_connect('visual_cache'); 
        $builder = $db->table('vendor_cache'); 

        if( !isset($data['id']))
        {
            return $this->response->setJSON([
                'success' => false, 
                'title' => 'Error', 
                'message' => 'Vendor ID missing', 
                'icon' => 'warning',
            ]);
        }

        $vendor = $builder->where("vendor_id", $data['id'] )->get()->getResult();

        $vendor = $vendor[0]; 

        $url = "http://vatap/mvc/public/api/getallvendorpurchaseorders/{$vendor->vendor_id}"; 
        try{
             $vendor->pos = $remote->getData($url); 
        }catch(Exception $e){
            return $this->response->setJSON([
                'data' => $url, 
                'success' => false, 
                'icon' => 'warning', 
                'message' => $e->getMessage(), 
            ]);      
        }

        return $this->response->setJSON([
            'data' => view('vendors/performance/modal', ['data' => $vendor ]), 
            'success' => true, 
            'icon' => 'success', 
            'message' => 'Successfully retrieved vendor details', 
        ]);
    }

    public function get_open_lines($vendor)
    {
        $model = new SqlbaseModel(); 
        $url = "http://vatap/mvc/public/api/getallvendorpolines/{$vendor}";
        $result = $model->getData($url); 


        //return view('vendors/performance/lines-table', ['lines' => $result] );

        if($result){
            return $this->response->setJSON([
                'success' => true, 
                'data' => view('vendors/performance/lines-table', ['lines' => $result] ), 
                'icon' => 'success', 
                'title' => 'Success!', 
                'html' => "<p>Successfully retreived open lines for {$vendor}</p>",
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'title' => 'Error', 
            'icon' => 'warning', 
            'html' => '<p>There was an error processing your request</p>',
        ]);
    }

    public function send_email()
    {
        $file = $this->request->getFile('file'); 

        $data = $this->request->getPost();

        $validation = service('validation');

        $rules = [
            'email_from' => [
                'label' => 'Email From', 
                'rules' => 'required|valid_email', 
                'errors' => [
                    'required' => 'A <strong>{field}</strong> address is required.',
                    'valid_email' => 'The <strong>{field}</strong> must be a valid email address', 
                ],
            ],
            'email_to' => [
                'label' => 'Email To', 
                'rules' => 'required|valid_email', 
                'errors' => [
                    'required' => 'A <strong>{field}</strong> address is required', 
                    'valid_email' => 'The <strong>{field}</strong> must be a valid email address',
                ]
            ],
            'subject' => [
                'label' => 'Email Subject', 
                'rules' => 'required', 
                'errors' => [
                    'required' => 'The <strong>{field}</strong> is required', 
                ]
            ],
            'message' => [
                'label' => 'Email Message', 
                'rules' => 'required', 
                'errors' => [
                    'required' => 'The <strong>{field}</strong> is required', 
                ]
            ],
            'file' => [
                'label' => 'Purchase Order', 
                'rules' => [
                    //'uploaded[file]',
                    'ext_in[file,pdf]',
                    'mime_in[file,application/pdf]',
                ],
                'errors' => [
                    'uploaded' => 'Please select a file to attach before sending your email.',
                    'ext_in' => 'Only PDF files are allowed as attachments.',
                    'mime_in' => 'Attachments must be in PDF format.',
                ],
            ]

        ];

        $validation->setRules($rules); 

        if(!$validation->run($data))
        {
            $errors = $validation->getErrors(); 

            $message = '<ul class="list-group">'; 

            foreach($errors as $key => $value)
            {
                $message .= '<li class="list-group-item">' . $value . '</li>'; 
            }

            $message .= '</ul>';

            return $this->response->setJSON([
                'success' => false, 
                'title' => 'Warning!', 
                'icon' => 'warning',
                'message' => $message,
            ]);
        }

        if(!$file->isValid())
        {
            return $this->response->setJSON([
                'success' => false, 
                'title' => 'Error', 
                'icon' => 'warning', 
                'message' => 'The file is not a vaild file.', 
            ]);
        }

        $fileName = $file->getName(); 
        $filePath = $file->store('', $fileName); 

        $email = service('email'); 
        $email->setFrom($data['email_from']); 
        $email->setTo($data['email_to']); 
        $email->setSubject($data['subject'] . $data['purchase_order']); 
        $email->setMessage($data['message']); 

        $email->attach(WRITEPATH.'uploads/'.$filePath); 

        if($email->send())
        {
            return $this->response->setJSON([
                'success' => true, 
                'data' => $data, 
                'title' => 'Success', 
                'icon' => 'success', 
                'message' => 'The vendor was successfully emailed', 
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false, 
            'title' => 'Error', 
            'icon' => 'warning', 
            'message' => 'There was an error sending the email!', 
        ]);
        
    }

    public function get_spreadsheet()
    {
        $session = session();
        $model = new SqlbaseModel(); 
        $spreadsheet = new Spreadsheet();
        $url = "http://vatap/mvc/public/api/vendor_performance/0/";

        if( $session->has('performance_start_date') )
        {
            $start = $session->get('performance_start_date');
            $end = $session->get('performance_end_date');       
            $url = "http://vatap/mvc/public/api/vendor_performance/0/{$start}/{$end}";     
        }

        $start = isset($start)
            ? new \DateTime($start) 
            : (new \DateTime())->modify('-90 Days'); 


        $end = isset($end)
            ? new \DateTime($end) 
            : new \DateTime(); 

        
        $data = $model->getData($url); 
 
        //Setup Headers
        $headers = [
            'VENDOR ID', 
            'VENDOR NAME',
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
                'startColor' => ['argb' => 'FFacce5b'], 
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

        //Alternate Row Style
        $alternateRowStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFdcfa96']
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
        $title = 'Vendor Performance Report'; 
        $sheet->setTitle($title);

        $formatted_start = $start->format('Y-m-d'); 
        $formatted_end = $end->format('Y-m-d'); 
        $sheet->setCellValue('A1', 'Vendor Performance - ' . $formatted_start . ' / ' .$formatted_end);
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
                $item->vendor_id ?? '',
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
        //$sheet->getStyle($rowRange)->applyFromArray($totalsRowStyle);
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

        $filename = "Vendor-Performance.xlsx";
        
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