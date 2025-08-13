<?php 
    $vendor_id = $data[0][0]->id;
    $vendor_name = $data[0][0]->name;  
    $percent = $data[0][0]->performance['on_time_percentage']; 
    $start_date = $data[0][0]->performance['start_date'];
    $end_date = $data[0][0]->performance['end_date'];
    $color = $data[0][0]->po_status_color; 
    $vendor_email = $data[0][0]->contact_email ? $data[0][0]->contact_email : ''; 
    $today = new \DateTime(); 

?>

<div class="modal-header">
    <h5><?= $vendor_id ?> : <?= $vendor_name ?> </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
        <div class="row mb-2">
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" name="from" id="" value="<?= auth()->user()->email ?>" placeholder="" class="form-control">
                    <label for="from">Email From:</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" name="to" id="" value="<?= strtolower($vendor_email) ?>" placeholder="" class="form-control">
                    <label for="from">Email To:</label>
                </div>
            </div>

        </div>
        <h6 class="h6">Opening Message: </h6>
        <div id="start-message">
            <h4 style="color: #004085;">ATAP, Inc – Delivery Status Request</h4>
            <p>Greetings,</p>

        <p>We are requesting a delivery update regarding a recent purchase order(s). Our records indicate that one or more line items are approaching their scheduled delivery date(s), and we would appreciate your confirmation of their current status.</p>

        </div>

        <?php if( isset($data) ) : ?>

        <?php foreach($data as $index => $po ) : ?>

        <table class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th colspan="5">Purchase Order Number : <?= $po[0]->purchase_order ?> / Promise Date: <?= (isset($po[0]->effective_promise)) ? $po[0]->effective_promise : 'N/A' ?></th>
                </tr>
                <tr>
                    <th>Line No.</th>
                    <th>Part Number</th>
                    <th>Description</th>
                    <th>Ordered</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($po[0]->lines as $line ): ?>
                <tr>
                    <td><?= $line['line_no'] ?></td>
                    <td><?= $line['part_id'] ?></td>
                    <td><?= $line['description'] ?></td>
                    <td><?= $line['user_order_qty'] ?></td>
                    <td><?= $line['user_received_qty'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <input type="hidden" name="items[<?= $index ?>][vendor_id]" value="<?= $vendor_id ?>">
         <input type="hidden" name="items[<?= $index ?>][po_id]" value="<?= $po[0]->purchase_order ?>" >
        <?php endforeach; ?>
        <?php endif; ?>
        <h6 class="h6">Ending Message:</h6>
        <div id="end-message">
            <p>Please review the information we have provided and respond with an update indicating when the item(s) will be delivered to our facilities.</p>
            <p>If multiple delivery dates are scheduled, please reference the line number, part number, and nomenclature from our purchase order when responding.</p>

            <p><strong>We encourage all our vendors to meet a 90% on-time delivery target.</strong></p>
            <p>Your current on-time delivery percentage is:  <b><?= $percent; ?>%</b> for the period of <b> <?= ( new \DateTime($start_date ))->format('m-d-Y') ?> - <?= ( new \DateTime    ($end_date ))->format('m-d-Y') ?></b></p>
        
            <p>Thank You, </p>
            <p style="margin-top: 30px"><b>ATAP, inc. Purchase Dept.</b><br>P: 256-362-2221<br>F: 256-362-2220<br>130 Industry Way <br>Eastaboga, AL 36260</p>
        </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>&nbsp;Close</button>
    <button class="btn btn-primary" id="email-vendor"><i class="bi bi-envelope"></i>&nbsp;Email Vendor</button>
</div>

<script>
    $(document).ready(function(){
        $('#start-message').trumbowyg({
            btns: [ 
                ['viewHTML'],
                ['undo', 'redo'], 
                ['formatting'],
                ['strong', 'em', 'del'],
                ['link'],
                ['lineheight']
            ],
            height: 50,
            autogrow: true,
        });
        $('#end-message').trumbowyg({
            btns: [ 
                ['viewHTML'],
                ['undo', 'redo'], 
                ['formatting'],
                ['strong', 'em', 'del'],
                ['link'],
                ['lineheight']
            ],
        });
    })
</script>
