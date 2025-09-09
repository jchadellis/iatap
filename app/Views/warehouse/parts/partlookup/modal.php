<pre>
    <?php $data = (object)$data ?>
    <?php //return; ?>
</pre>

<?php if( $data ) : ?>
<div class="modal-header">
    <p class="modal-title"><span class="fw-bold">Part ID:</span> <?= $data->id ?? '' ?> <span class="fw-bold">Part Description:</span> <?= $data->description ?? '' ?></p>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table class="table">
        <tr class="table-info">
            <th colspan="6" >General</th>
        </tr>
        <tr>
            <th>On Hand</th>
            <td><?= $data->qty_on_hand ?? '' ?></td>
            <th>Stock UM</th>
            <td><?= $data->stock_um ?? ''?></td>
            <th>Primary Location</th>
            <td><?= $data->location_id ?? ''?></td>
        </tr>
        <tr>
            <th>Specifications</th>
            <td colspan="5" style="height:100px"><?= $data->bits['bits'] ?? '' ?></td>
        </tr>
    </table>
    <table class="table table-striped">
        <tr class="table-info">
            <th colspan="6">
                Sales History
            </th>
        </tr>
        <tr>
            <th class="text-center">Customer ID</th>
            <th class="text-center">Order Date</th>
            <th class="text-center">Order ID</th>
            <th class="text-center">Order Qty</th>
            <th class="text-center">Order Line</th>
            <th class="text-center">Amount</th>
        </tr>
        <?php if(!empty($data->customer_orders)) : ?>
        <?php foreach($data->customer_orders as $row ) : ?>
        <tr>
            <td class="text-center"><?= $row['co_customer_id'] ?></td>
            <td class="text-center"><?= $row['co_order_date'] ?></td>
            <td class="text-center"><?= $row['col_order_id'] ?></td>
            <td class="text-center"><?= $row['col_order_qty'] ?></td>
            <td class="text-center"><?= $row['col_line_no'] ?></td>
            <td class="text-end"><?= $row['col_unit_price'] ?></td>
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

    <table class="table table-striped">
        <tr class="table-info">
            <th colspan="7"> 
                Purchase History
            </th>
        </tr>
        <tr>
            <th class="text-center">Purchase No.</th>
            <th class="text-center">Order Date</th>
            <th class="text-center">Promise Date</th>
            <th class="text-center">Order Qty</th>
            <th class="text-center">PO Line</th>
            <th class="text-center">Vendor ID</th>
            <th class="text-center">Order Amount</th>
        </tr>
        <?php if(!empty($data->purchase_orders) ) : ?>
        <?php foreach($data->purchase_orders as $row ) : ?>
        <tr>
            <td class="text-center"><?= $row['po_id'] ?></td>
            <td class="text-center"><?= $row['po_order_date'] ?></td>
            <td class="text-center"><?= $row['po_promise_date'] ?></td>
            <td class="text-center"><?= $row['pol_order_qty'] ?></td>
            <td class="text-center"><?= $row['pol_line_no'] ?></td>
            <td class="text-center"><?= $row['po_vendor_id'] ?></td>
            <td class="text-end"><?= $row['pol_unit_price'] ?></td>
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
    <table class="table table-striped">
        <tr class="table-info">
            <th colspan="7"> 
                Quote History
            </th>
        </tr>
        <tr>
            <th class="text-center">Quote ID</th>
            <th class="text-center">Quote Date</th>
            <th class="text-center">Customer ID</th>
            <th class="text-center">Quote Qty</th>
            <th class="text-center">Order Line</th>
            <th class="text-center">Amount</th>
        </tr>
        <?php if(!empty($data->quote_history) ) : ?>
        <?php foreach($data->quote_history as $row ) : ?>
        <tr>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-end"></td>
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
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
</div>
<?php else : ?>
    <div class="modal-header"></div>
    <div class="modal-body">

    </div>
    <div class="modal-footer"></div>
<?php endif; ?>
