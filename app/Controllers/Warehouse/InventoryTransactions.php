<?php

namespace App\Controllers\Warehouse;
use App\Controllers\BaseController; 
use App\Models\SqlbaseModel; 
use App\Models\InventoryTransactionModel; 
use App\Libraries\Forms\PickListForm;


class InventoryTransactions extends BaseController
{
    protected $remoteModel;

    public function __construct()
    {
        $this->remoteModel = new SqlbaseModel(); 
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard'],
            ['name' => 'Warehouse', 'is_active' => false, 'url' => 'warehouse'],
            ['name' => 'Inventory Transactions', 'is_active' => true, 'url' => '']
        ];

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Inventory Transactions', 'content' => view('warehouse/inventory-transactions' )];
        $this->data['js'] = view('warehouse/inventory-transactions.js.php'); 

        return view('template/index-full',$this->data); 
    }

    public function print()
    {
        // Check if there's POST data available
        if ($post = $this->request->getPost()) 
        {
            // Extract relevant POST parameters
            $date = $post['transaction_date'];
            $start = $post['start_transaction'];
            $end = $post['end_transaction'];
            $delivered_to = $post['delivered_to'];

            // Build the data URL for fetching inventory transactions remotely
            $url = "http://vatap/mvc/public/api/getinventorytrans/$date/$start/$end";

            // Use the remoteModel to retrieve the data
            $data = $this->remoteModel->getData($url);

            // Create a new instance of the PDF class
            $pdf = new PickListForm();

            // Generate a filename with today's date
            $outputFile = 'picklist' . date('mdY') . '.pdf';

            // Generate the PDF using the provided data
            $pdf->print($outputFile, $data);

            // Return the PDF file as a download response
            // return $this->response->download(WRITEPATH . 'uploads/' . $outputFile, null);
            $model = new InventoryTransactionModel(); 
            foreach($data as $row)
            {
                $date = new \DateTime();
                $transaction = ['transaction_id' => $row->trans_id, 'printed' => $date->format('Y-m-d H:i:s'), 'delivered_to' => $delivered_to ];
                //$model->save($transaction); // Emable this to save printed Transactions. 
            }

            // Return the PDF file as a new Browser Window. 
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $outputFile . '"')
                ->setBody(file_get_contents(WRITEPATH . 'uploads/' . $outputFile));
        }
    }


    public function get_data()
    {
        if($post = $this->request->getPost())
        {
            $date = '/'. $post['transaction_date'] ?? '' ;
            if($post['json'])
            {
                $data = json_encode($this->remoteModel->getData("http://vatap/mvc/public/api/getinventorytrans$date"));
                echo $data; 
            }
        }
    }
}