<?php $po = $data[0]; ?>

<div class="row m-1 border border-1 g-4">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="alert <?= $po->status_map['alert'] ?> text-center"><h5 class="h5"><?= $po->status_map['message'] ?></h5> </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating">
                            <select name="received_by" id="" class="form-select">
                                <?php if($po->warehouse_received_by != '' ) : ?>
                                    <?php foreach($po->warehouse_employees as $employee) : ?>
                                        <option value="<?= $employee ?>" <?= ($employee == $po->warehouse_received_by) ? 'selected' : '' ?>><?= $employee ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="null">Select Received By</option>
                                    <?php foreach( $po->warehouse_employees as $key => $value ) : ?>
                                        <option value="<?= $value ?>" ><?= $value ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <label for="received_by">Received By</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row d-flex p-2">
                    <div class="col-12 align-items-center"><strong>Vendor: </strong><span><?= $po->vendor_name ?></span></div>
                    <div class="col-12 align-items-center"><strong>Buyer: </strong><span><?= $po->po_buyer ?></div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php foreach($po->lines as $row) : ?>

<table class="table table-bordered">
    <tbody>
            <tr class="text-center table-info">
                <th>Line #</th>
                <th>Part / Vendor ID</th>
                <th>Description</th>
                <th>Qty</th>
            </tr>
            <tr>
                <td class="col-1 text-center "><?= $row['line_no'] ?></td>
                <td class="col-3 text-center"><?= $row['part_id'] ?> / <?= $row['vendor_part_id'] ?></td>
                <td class="col-7"><?= $row['description'] ?></td>
                <td class="col-1 text-center"></td>
            </tr>
            <tr>
                <td colspan="4"> 
                    <a href="" title="View Receipt Details" class="text-decoration-none text-dark">
                    <div class="row  d-flex align-items-center">
                        <div class="col-2 border-end border-1 py-2"> 
                            <div class="row">
                                <div class="col-8"><strong>Order QTY:</strong></div>
                                <div class="col text-end text-secondary"><?= $row['order_qty'] ?></div>
                            </div>
                        </div>
                        <div class="col-4 border-end border-1">
                            <div class="row">
                                <div class="col-5  d-flex align-items-center" ><strong>QTY To Receive:</strong></div>
                                <div class="col" >
                                    <div class="input-group">
                                        <input class="form-control text-end" type="text" name="receipt[]" id="" value="<?= $row["order_qty"] - $row['warehouse_qty_to_date'] ?>">
                                        <span class="input-group-text"><?= $row['unit'] ?></span>
                                    </div>              
                                </div>
                            </div>
                        </div>
                        <div class="col-2 border-end border-1  py-2">
                            <div class="row">
                                <div class="col-5"><strong>Location:</strong></div>
                                <div class="col text-secondary"><?= $row['primary_loc_id'] ?></div>
                            </div>
                        </div>
                        <div class="col-4  py-2">
                            <div class="row ">
                                <div class="col-8"><strong>QTY Received By Shipping:</strong></div>
                                <div class="col text-secondary text-center <?= ($row['shipping_qty_to_date'] <  $row['warehouse_qty_to_date'] ) ? 'text-danger' : 'text-success' ?>"><?= $row['shipping_qty_to_date'] ?></div>
                            </div>
                            <div class="row ">
                                <div class="col-8"><strong>QTY Received By Warehouse:</strong></div>
                                <div class="col text-secondary text-center  <?= ($row['warehouse_qty_to_date'] <  $row['shipping_qty_to_date'] ) ? 'text-danger' : 'text-success' ?>"><?= $row['warehouse_qty_to_date'] ?></div>
                            </div>
                        </div>
                    </div> 
                    </a>            
                </td>
            </tr>
            <tr class="table-secondary">
                <td colspan="4">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">External Line Specs:</div>
                                <div class="col"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">Internal Line Specs:</div>
                                <div class="col"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">Customer Order Links:</div>
                                <div class="col"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-6">Order Specs:</div>
                                <div class="col"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">Work Order Links:</div>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
    </tbody>
</table> 
<?php endforeach; ?>