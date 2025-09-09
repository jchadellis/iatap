<?php 

namespace App\Controllers\Warehouse\Parts\PartLookup;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SqlbaseModel; 

class Index extends BaseController
{


    public function __construct()
    {
        $this->remote_model = new SqlbaseModel(); 
    }

    public function index()
    {
        $data = [
            'site_name' => 'iATAP', 
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'is_active' => false, 'url' => '/dashboard' ],
				['name' => 'Warehouse', 'is_active' => false, 'url' => 'warehouse'],
				['name' => 'Parts', 'is_active' => false, 'url' => 'warehouse/parts'],
				['name' => 'Part Lookup', 'is_active' => true, 'url' => '#']
            ],
            'title' => 'Parts Lookup', 
            'content' => view('warehouse/parts/partlookup/index',[]),
            'js' => view('warehouse/parts/partlookup/index.js.php'), 
        ];

        return view('template/index', $data); 
    }

    public function get_data()
    {
        $post = $this->request->getPost();

        if(!isset($post['id'])) 
        {
            $data = [
                'id' => '', 
                'description' => '', 
                'qty_on_hand' => '', 
                'primary_loc_id' => '', 
                'unit_price' => '', 
            ];
            return $this->response->setJSON([
                'data' => $data, 
            ]);
        }

        if( $post['id'] === '' && $post['description'] === '')
        {
            
            return $this->response->setJSON(
                [
                    'title' => 'Search Field Required',
                    'message' => 'Part ID, Description, or User Define is empty. Please enter a search term for at least one of these fields.',
                    'success' => false,
                ]
            );
        }


        $url = "http://vatap/mvc/public/api/partlookup"; 

        $data = $this->remote_model->postData($url, $post);
 
        if( $data )
        {
            return $this->response->setJSON(
                [
                    'data' => $data, 
                    'success' => true,
                    'message' => 'Retrieved Data',
                ]
            );
        }
        return $this->response->setJSON(
            [
                'success' => false, 
                'title' => 'Not Found', 
                'message' => "We couldn’t find any items or parts matching your search. '{$post['id']}, {$post['description']}'", 
            ]
        );  
    }

    public function get_details($id = null)
    {
        $post = $this->request->getPost(); 

        $id = $post['id'] ?? $id; 

        $url = "http://vatap/mvc/public/api/getpart/";

        $data = $this->remote_model->postData($url, ['id' => $id]); 

 
        if($data)
        {
            $processed = $this->processTransactionData($data); 
        }

        return $this->response->setJSON([
            'data' => view('warehouse/parts/partlookup/modal', ['data' => $data]), 
            'success' => true, 
        ]);
    }

    private function processTransactionData($partData)
    {
        $partData = (object)$partData; 
        $transactions = $partData->transactions ;
        $qtyOnHand = (float)str_replace(',', '', $partData->qty ?? 0);
        $maxRows = count($transactions);  
        
        if ($maxRows === 0) {
            $partData->runningQuantities = [];
            $partData->processedTransactions = [];
            return $partData;
        }
        
        // Calculate running quantities (chronological order - oldest first)
        $runQty = $this->calculateRunningQuantities($transactions, $qtyOnHand, $maxRows);
        
        // Reverse for display (newest first)
        $statQty = array_reverse($runQty);
        
        // Process transactions for display (reverse chronological order)
        $processedTransactions = [];
        $reversedTransactions = array_reverse($transactions);
        
        foreach ($reversedTransactions as $index => $transaction) {
            $processedTransaction = $this->processTransaction($transaction, $statQty[$index] ?? 0);
            $processedTransactions[] = $processedTransaction;
        }
        
        // Add processed data back to partData object
        $partData->runningQuantities = $runQty;
        $partData->processedTransactions = $processedTransactions;
        $partData->maxRows = $maxRows;

        return $partData; 
    }

    private function calculateRunningQuantities($transactions, $qtyOnHand, $maxRows)
    {
        
        $runQty = [];
        
        for ($rows = 0; $rows < $maxRows; $rows++) {
            $transaction = (object) $transactions[$rows];
            $transQty = (float)str_replace(',', '', $transaction->qty ?? 0);
            
            if ($rows > 0 && $rows != ($maxRows - 1)) {
                $prevQty = $runQty[$rows - 1];
                
                // Check for Receipt Types (I + R)
                if ($transaction->type === "I" && $transaction->class === "R") {
                    $runQty[$rows] = $prevQty + $transQty;
                }
                // Check for Return Types (O + R)
                elseif ($transaction->type === "O" && $transaction->class === "R") {
                    $runQty[$rows] = $prevQty - $transQty;
                }
                // Check for Issue Types (O + I)
                elseif ($transaction->type === "O" && $transaction->class === "I") {
                    $runQty[$rows] = $prevQty - $transQty;
                }
                // Check for Return Issue Types (I + I)
                elseif ($transaction->type === "I" && $transaction->class === "I") {
                    $runQty[$rows] = $prevQty + $transQty;
                }
                // Check for Adjustment Types (A + no transfer)
                elseif ($transaction->class === "A" && empty($transaction->transfer_trans_id)) {
                    if ($transaction->type === "O") {
                        $runQty[$rows] = $prevQty - $transQty; // Adj. Out
                    } else {
                        $runQty[$rows] = $prevQty + $transQty; // Adj. In
                    }
                }
                // Check for Transfer Types (A + has transfer)
                elseif ($transaction->class === "A" && !empty($transaction->transfer_trans_id)) {
                    $runQty[$rows] = $prevQty; // Transfers don't change total inventory
                }
                else {
                    $runQty[$rows] = $prevQty; // Default case
                }
            }
            
            // Handle first transaction
            if ($rows === 0) {
                $runQty[$rows] = $transQty;
            }
            
            // Handle most recent transaction (should equal current qty on hand)
            if ($rows === ($maxRows - 1)) {
                $runQty[$rows] = $qtyOnHand;
            }
        }
        
        return $runQty;
    }

    private function processTransaction($transaction, $runningQty)
    {
        // Get transaction type description
        $transType = $this->getTransactionType($transaction);
        
        // Format quantity
        $transQty = number_format((float)($transaction->qty ?? 0));
        
        // Format date
        $formattedDate = $this->formatTransactionDate($transaction->transaction_date ?? '');
        
        // Calculate costs
        $costs = $this->calculateTransactionCosts($transaction);
        
        // Get reference ID
        $refId = ($transaction->workorder_base_id ?? '') . 
                ($transaction->purc_order_id ?? '') . 
                ($transaction->cust_order_id ?? '');
        
        return (object)[
            'transaction_id' => $transaction->transaction_id ?? '',
            'formatted_date' => $formattedDate,
            'type' => $transType,
            'ref_id' => $refId,
            'location_id' => $transaction->location_id ?? '',
            'quantity' => $transQty,
            'running_qty' => $runningQty,
            'total_cost' => $costs['total_cost'],
            'cost_breakdown' => $costs['breakdown'],
            'description' => $transaction->description ?? '',
            'original' => $transaction
        ];
    }

    private function getTransactionType($transaction)
    {
        $type = $transaction->type ?? '';
        $class = $transaction->class ?? '';
        $transferTransId = $transaction->transfer_trans_id ?? null;
        $purcOrderId = $transaction->purc_order_id ?? null;
        $custOrderId = $transaction->cust_order_id ?? null;
        
        // Check for Receipt Types
        if ($type === "I" && $class === "R") {
            return empty($purcOrderId) ? "WO Receipt" : "PO Receipt";
        }
        
        // Check for Return Types
        if ($type === "O" && $class === "R") {
            return empty($purcOrderId) ? "Return Receipt" : "PO Return";
        }
        
        // Check for Issue Types
        if ($type === "O" && $class === "I") {
            return empty($custOrderId) ? "WO Issue" : "CO Sale";
        }
        
        // Check for Return Issue Types
        if ($type === "I" && $class === "I") {
            return empty($custOrderId) ? "Return Issue" : "CO Return";
        }
        
        // Check for Adjustment Types
        if ($class === "A" && empty($transferTransId)) {
            return ($type === "O") ? "Adj. Out" : "Adj. In";
        }
        
        // Check for Transfer Types
        if ($class === "A" && !empty($transferTransId)) {
            return ($type === "O") ? "Move Out" : "Move In";
        }
        
        return "";
    }

    private function formatTransactionDate($dateString)
    {
        if (empty($dateString)) {
            return '';
        }
        
        $splitDate = explode(" ", $dateString);
        $tDate = explode("-", $splitDate[0]);
        
        if (count($tDate) >= 3) {
            return $tDate[1] . '/' . $tDate[2] . '/' . substr($tDate[0], -2);
        }
        
        return $dateString;
    }

    private function calculateTransactionCosts($transaction)
    {
        $qty = (float)($transaction->qty ?? 0);
        $mcost = (float)($transaction->act_material_cost ?? 0);
        $lcost = (float)($transaction->act_labor_cost ?? 0);
        $bcost = (float)($transaction->act_burden_cost ?? 0);
        $scost = (float)($transaction->act_service_cost ?? 0);
        
        $totalCost = $mcost + $lcost + $bcost + $scost;
        $unitCost = $qty > 0 ? $totalCost / $qty : 0;
        
        $unitMcost = $qty > 0 ? $mcost / $qty : 0;
        $unitLcost = $qty > 0 ? $lcost / $qty : 0;
        $unitBcost = $qty > 0 ? $bcost / $qty : 0;
        $unitScost = $qty > 0 ? $scost / $qty : 0;
        
        return [
            'total_cost' => '$' . number_format($unitCost, 2, '.', ','),
            'breakdown' => number_format($unitMcost, 2, '.', ',') . '+' .
                        number_format($unitLcost, 2, '.', ',') . '+' .
                        number_format($unitBcost, 2, '.', ',') . '+' .
                        number_format($unitScost, 2, '.', ',')
        ];
    }
}