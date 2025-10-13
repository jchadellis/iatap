<?php

namespace App\Controllers\Warehouse\Transactions;
use App\Controllers\BaseController; 
use App\Models\SqlbaseModel; 
use App\Models\InventoryTransactionModel; 
use App\Libraries\Forms\PickListForm;


class Index extends BaseController
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

        $this->data = ['site_name' => 'iATAP', 'breadcrumbs' => $breadcrumbs, 'title' => 'Inventory Transactions', 'content' => view('warehouse/transactions/index' )];
        $this->data['js'] = view('warehouse/transactions/index.js.php'); 

        return view('template/index-full',$this->data); 
    }

    public function print()
    {


        

        // Check if there's POST data available
        if ($post = $this->request->getPost()) 
        {

            $db = db_connect('atapweb');

            $table = $db->table('inventory_trans'); 

            
            // Extract relevant POST parameters
            $date = $post['transaction_date'];
            $start = $post['start_transaction'];
            $end = $post['end_transaction'];
            $delivered_to = $post['delivered_to'];

            $where = "trans_id BETWEEN {$start} AND {$end}";

            $transactions = $table->select('*')->where($where)->get()->getResult(); 

          

            $trans_ids =  array_column($transactions,'trans_id');

            $url = "http://vatap/mvc/public/api/getinventorytrans/$date/$start/$end";

            // Use the remoteModel to retrieve the data
            $data = $this->remoteModel->getData($url);

            // Create a new instance of the PDF class
            $pdf = new PickListForm();

            // Generate a filename with today's date
            $outputFile = 'picklist' . date('mdY') . '.pdf';

            // Generate the PDF using the provided data
            $pdf->print($outputFile, $data);


            /**
             * TEMPORARY WORKAROUND:
             * 
             * The following block is a transitional solution to support operations
             * while both the legacy `trans_inventory` database (hosted on 192.168.1.39)
             * and the new system are in use. This code ensures that transaction print
             * records are updated and maintained in both systems during the migration
             * period. Once the migration to the new database is complete and the old
             * system is decommissioned, this workaround should be removed and all
             * related logic consolidated to the new data model.
             *
             * Please review and refactor when the legacy database is no longer required.
             */


            $model = new InventoryTransactionModel(); 
            $printed_transactions = array_column($model->findAll(), 'transaction_id');
            
            foreach($data as $row)
            {
                $date = new \DateTime();
                $transaction = ['transaction_id' => $row->trans_id, 'printed' => $date->format('Y-m-d h:i:s'), 'delivered_to' => $delivered_to ];
                if( in_array($row->trans_id,$printed_transactions))
                {
                    $printed = $model->where('transaction_id', $row->trans_id)->first(); 
                    $transaction = ['id' => $printed['id'], 'transaction_id' => $row->trans_id, 'printed' => $date->format('Y-m-d h:i:s'), 'delivered_to' => $delivered_to ];
                }
                $model->save($transaction); // Emable this to save printed Transactions. 

                if( in_array($row->trans_id, $trans_ids ) ){
                    $table->set('trans_date', date('Y-m-d'));
                    $table->where('trans_id', $row->trans_id);
                    $table->update();
                }else{
                    $data = [
                        'trans_date' => date('Y-m-d'),
                        'trans_id' => $row->trans_id,
                    ];
                }
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
                $data = json_encode($this->remoteModel->getData("http://vatap/mvc/public/api/getinventorytrans/$date"));
                echo $data; 
            }
        }
    }

}