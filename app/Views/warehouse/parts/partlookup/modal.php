
<?php $data = (object)$data ?>

<?php if( $data ) : ?>
<div class="modal-header">
    <h5 class="modal-title"><span class="fw-bold">Part ID:</span> <span class="text-success"><?= $data->id ?? '' ?></span> <span class="fw-bold">Part Description:</span> <span class="text-success"><?= $data->description ?? '' ?></span></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table class="table">
        <tr class="table-info">
            <th colspan="10" >General</th>
        </tr>
        <tr>
            <th>Projected Qty:</th>
            <td class="<?= ($data->calc_projected_qty > 0) ? 'table-success' : 'table-danger' ?> text-center"><?= $data->calc_projected_qty ?? ''?></td>
            <th>On Hand:</th>
            <td><?= $data->qty_on_hand ?? '' ?></td>
            <th>Stock UM:</th>
            <td colspan="2"><?= $data->stock_um ?? ''?></td>
            <th colspan="2">NSN #:</th>
            <td><?= $data->user_10 ?>
        </tr>
        <tr>
            <th colspan="8">
                Specifications
            </th>
            <th>WH Location</th>
            <td><?= $data->location_id ?? ''?></td>
        </tr>
        <tr>
            <td colspan="8">
                <div class="p-2 m-0 rounded-2 overflow-scroll" style="background-color: #e6faffff;">
                    <?php 

                        $bits = $data->bits['bits'] ?? ''; 
                        $bits_formatted =  implode('\n', array_map('trim', explode('\n', $bits))); 
                    ?>
                    <pre><?= $bits_formatted ?></pre>
                </div>
            </td>
        </tr>
    </table>

    <div class="row m-1">
       <div class="col-12  p-2">
           <div class="d-flex flex-row align-items-middle">
                <button
                    type="button"
                    class="btn btn-secondary mx-2"
                    data-bs-toggle="collapse"
                    data-bs-target="#sales-history-table"
                    aria-expanded="false"
                ><i class="bi bi-clock-history"></i>&nbsp;Sales History</button>

                <button
                    type="button"
                    class="btn btn-secondary mx-2"
                    data-bs-toggle="collapse"
                    data-bs-target="#purchase-history-table"
                    aria-expanded="false"
                ><i class="bi bi-clock-history"></i>&nbsp;Purchase History</button>

                <button
                    type="button"
                    class="btn btn-secondary mx-2"
                    data-bs-toggle="collapse"
                    data-bs-target="#quote-history-table"
                    aria-expanded="false"
                ><i class="bi bi-clock-history"></i>&nbsp;Quote History</button>

                <button
                    type="button"
                    class="btn btn-primary mx-2"
                    data-bs-toggle="collapse"
                    data-bs-target="#carry-cost-table"
                    aria-expanded="false"
                    aria-controls="costing-data"
                ><i class="bi bi-currency-dollar"></i>&nbsp;Carrying Cost</button>

                <button
                    type="button"
                    class="btn btn-primary mx-2"
                    data-bs-toggle="collapse"
                    data-bs-target="#transaction-table"
                    aria-expanded="false"
                    aria-controls="costing-data"
                ><i class="bi bi-receipt-cutoff"></i>&nbsp;Transactions</button>

                <button
                    type="button"
                    class="btn btn-primary mx-2"
                    data-bs-toggle="collapse"
                    data-bs-target="#pricing-utility-table"
                    aria-expanded="false"
                    aria-controls="costing-data"
                ><i class="bi bi-calculator"></i>&nbsp;Pricing Utility</button>
           </div>
       </div>
    </div>
     <hr>
    <div id="parent-collapse">
        <div class="collapse" id="pricing-utility-table" data-bs-parent="#parent-collapse">
            <table class="table table-striped">
                <tbody>
                    <tr class="table-primary">
                        <th>Pricing Utility</th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                                $material_cost = $data->material_cost ?? 0;
                                $labor_cost = $data->labor_cost ?? 0;
                                $service_cost = $data->service_cost ?? 0;
                                $burden_cost = $data->burden_cost ?? 0;
                                $total_cost = $material_cost + $labor_cost + $burden_cost + $service_cost;
                                $sale_price = $data->unit_price ?? 0;
                                $mark_up = 0;
                                if($total_cost > 0 )
                                {
                                    $mark_up = (( $sale_price - $total_cost ) / $total_cost) * 100;
                                    if($mark_up < 0)
                                    {
                                        $mark_up = 0;
                                    }
                                }
                                $gross_margin = 0;
        
                                if($sale_price > 0)
                                {
                                    $gross_margin = (( $sale_price - $total_cost ) / $sale_price ) * 100  ;
                                }
        
                            ?>
                            <form action="" id="costing-form">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Material</th>
                                        <td>$<?= number_format($material_cost, 2) ?></td>
                                        <th class="text-end">Total Cost (<span class="text-danger">TC</span>)</th>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input
                                                    type="text"
                                                    name="total_cost"
                                                    id="total_cost_input"
                                                    class="form-control text-end costing text-danger"
                                                    style="width: 8em"
                                                    data-initial_value="<?= $total_cost ?>"
                                                    value="<?= number_format($total_cost, 2) ?>"
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Labor</th>
                                        <td>$<?= number_format($labor_cost, 2) ?></td>
                                        <th class="text-end">Sale Price (<span class="text-primary">R</span>)</th>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input
                                                    type="text"
                                                    name="sale_price"
                                                    id="sale_price_input"
                                                    class="form-control text-end costing text-primary"
                                                    style="width: 8em"
                                                    data-initial_value="<?= $sale_price ?>"
                                                    value="<?= number_format($sale_price, 2) ?>"
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Burden</th>
                                        <td>$<?= number_format($burden_cost, 2) ?></td>
                                        <th class="text-end">GM% (<span class="text-primary">R</span>-<span class="text-danger">TC</span>) / <span class="text-primary">R</span></th>
                                        <td>
                                            <div class="input-group">
        
                                                <input
                                                    type="text"
                                                    name="gross_margin"
                                                    id="gross_margin_input"
                                                    class="form-control text-end costing"
                                                    style="width: 8em"
                                                    data-initial_value="<?= $gross_margin ?>"
                                                    value="<?= number_format($gross_margin, 2) ?>"
                                                >
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Service</th>
                                        <td>$<?= number_format($service_cost, 2) ?></td>
                                        <th class="text-end">MU% (<span class="text-primary">R</span>-<span class="text-danger">TC</span>) / <span class="text-primary"><span class="text-danger">TC</span></span></th>
                                        <td>
                                            <div class="input-group">
        
                                                <input
                                                    type="text"
                                                    name="mark_up"
                                                    id="mark_up_input"
                                                    class="form-control text-end costing"
                                                    style="width: 8em"
                                                    data-initial_value="<?= $mark_up ?>"
                                                    value="<?= number_format($mark_up, 2) ?>"
                                                >
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="collapse" id="carry-cost-table" data-bs-parent="#parent-collapse">
            <table class="table table-striped">
                <tbody>
                    <tr class="table-primary">
                        <th colspan="4">Carring Cost</th>
                    </tr>
                    <tr>
                        <th>Material Each</th>
                        <td>$<?= number_format($data->inventory_balance['material_amount_per_qty'], 2 )?></td>
                        <th>Material Total</th>
                        <td>$<?= number_format($data->inventory_balance['material_amount'], 2 )?></td>
                    </tr>
                    <tr>
                        <th>Labor Each</th>
                        <td><?= number_format($data->inventory_balance['labor_amount_per_qty'], 2 )?></td>
                        <th>Labor Total</th>
                        <td><?= number_format($data->inventory_balance['labor_amount'], 2 )?></td>
                    </tr>
                    <tr>
                        <th>Burden Each</th>
                        <td><?= number_format($data->inventory_balance['burden_amount_per_qty'], 2 )?></td>
                        <th>Burden Total</th>
                        <td><?= number_format($data->inventory_balance['burden_amount'], 2 )?></td>
                    </tr>
                    <tr>
                        <th>Service Each</th>
                        <td><?= number_format($data->inventory_balance['service_amount_per_qty'], 2 )?></td>
                        <th>Service Total</th>
                        <td><?= number_format($data->inventory_balance['service_amount'], 2 )?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="collapse" id="transaction-table" data-bs-parent="#parent-collapse">
            <table class="table table-striped">
                <thead>
                    <tr class="table-primary">
                        <th colspan="9">Transactions</th>
                    </tr>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>REF. ID</th>
                        <th>Location</th>
                        <th>Qty</th>
                        <th>@Qty</th>
                        <th>Total Cost</th>
                        <!-- <th>Cost Breakdown</th> -->
                        <th>Description</th>
                    </tr>
                    <?php if($data->processedTransactions) : ?>
                    <?php foreach($data->processedTransactions as $trans ): ?>
                    <tr>
                        <td><?= $trans->transaction_id ?? '' ?></td>
                        <td><?= $trans->formatted_date ?></td>
                        <td><?= $trans->type ?></td>
                        <td><?= $trans->ref_id ?></td>
                        <td><?= $trans->location_id ?></td>
                        <td><?= $trans->quantity ?></td>
                        <td><?= $trans->running_qty ?></td>
                        <td><?= $trans->total_cost ?></td>
                        <!-- <td><?= $trans->cost_breakdown ?></td> -->
                        <td><?= $trans->description ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="10">
                            <div class="alert alert-warning">
                                No Transactions have been recorded for this part.
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </thead>
            </table>
        </div>
    </div>

    <div id="history-collapse">
        <div class="collapse" id="sales-history-table" data-bs-parent="#history-collapse">
            <table class="table table-striped">
                <tr class="table-success">
                    <th colspan="6">
                        Sales History
                    </th>
                </tr>
                <tr>
                    <th class="text-center">Customer ID</th>
                    <th class="text-center">Order Date</th>
                    <th class="text-center">Order ID</th>
                    <th class="text-center">Order Qty</th>
                    <th class="text-center">Amount</th>
                </tr>
                <?php if(!empty($data->customer_orders)) : ?>
                <?php foreach($data->customer_orders as $row ) : ?>
                <tr>
                    <td class="text-center"><?= $row['customer_id'] ?></td>
                    <td class="text-center"><?= $row['order_date'] ?></td>
                    <td class="text-center"><?= $row['order_id'] ?></td>
                    <td class="text-center"><?= $row['qty'] ?></td>
                    <td class="text-end">$<?= number_format($row['total'], 2)?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-warning">
                                There are currently no customer orders associated with this part.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div class="collapse" id="purchase-history-table" data-bs-parent="#history-collapse">
            <table class="table table-striped">
                <tr class="table-success">
                    <th colspan="7">
                        Purchase History
                    </th>
                </tr>
                <tr>
                    <th class="text-center">Purchase No.</th>
                    <th class="text-center">Order Date</th>
                    <th class="text-center">Order Qty</th>
                    <th class="text-center">Vendor ID</th>
                    <th class="text-center">Order Amount</th>
                </tr>
                <?php if(!empty($data->purchase_orders) ) : ?>
                <?php foreach($data->purchase_orders as $row ) : ?>
                <tr>
                    <td class="text-center"><?= $row['order_id'] ?></td>
                    <td class="text-center"><?= $row['order_date'] ?></td>
                    <td class="text-center"><?= $row['qty'] ?></td>
                    <td class="text-center"><?= $row['vendor_id'] ?></td>
                    <td class="text-end">$<?= number_format($row['total'],2) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-warning">
                                No purchase history records were found for this part.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div class="collapse" id="quote-history-table" data-bs-parent="#history-collapse">
            <table class="table table-striped">
                <tr class="table-success">
                    <th colspan="7">
                        Quote History
                    </th>
                </tr>
                <tr>
                    <th class="text-center">Quote ID</th>
                    <th class="text-center">Quote Date</th>
                    <th class="text-center">Customer ID</th>
                    <th class="text-center">Work Order ID</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Unit Price</th>
                </tr>
                <?php if(!empty($data->quote_history) ) : ?>
                <?php foreach($data->quote_history as $row ) : ?>
                <tr>
                    <td class="text-center"><?= $row['order_id'] ?></td>
                    <td class="text-center"><?= $row['order_date'] ?></td>
                    <td class="text-center"><?= $row['customer_id'] ?></td>
                    <td class="text-center"><?= $row['workorder_id'] ?></td>
                    <td class="text-center"><?= $row['qty'] ?></td>
                    <td class="text-center">$<?= number_format($row['total'], 2)  ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-warning">
                                No quote history records were found for this part.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
</div>
<?php else : ?>
    <div class="modal-header"></div>
    <div class="modal-body">

    </div>
    <div class="modal-footer"></div>
<?php endif; ?>
