
<?php 
    $vendor_id = $data[0][0]->id;
    $vendor_name = $data[0][0]->name;  
    $percent = $data[0][0]->performance['on_time_percentage']; 
    $start_date = $data[0][0]->performance['start_date'];
    $end_date = $data[0][0]->performance['end_date'];
    $color = $data[0][0]->po_status_color; 
    $vendor_email = $data[0][0]->contact_email ? $data[0][0]->contact_email : ''; 
    $today = new \DateTime(); 
    $purchase_order = $data[0][0]->purchase_order;
    $promise_date = $data[0][0]->effective_promise;
?>

<div class="modal-header">
    <h5><?= $vendor_id ?> : <?= $vendor_name ?> </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
        <div class="alert alert-info">
            "Review your opening and closing messages below — these will appear at the start and end of your email. Feel free to edit either one before sending."
        </div>

        <div class="row mb-2">
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" name="from" id="from_email" value="<?= auth()->user()->email ?>" placeholder="" class="form-control">
                    <label for="from">Email From:</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" name="to" id="to_email" value="<?= strtolower($vendor_email) ?>" placeholder="" class="form-control">
                    <label for="from">Email To:</label>
                </div>
            </div>

        </div>
        <h6 class="h6">Opening Message: </h6>
        <div id="start-message">
            <h4 style="color: #004085;">ATAP, Inc –  Purchase Order Confirmation Request</h4>

            <p>Greetings,</p>

            <p>Our records indicate that the following purchase order includes one or more line items that remain unconfirmed:</p>

            <p><b>Purchase Order:</b> <?= $purchase_order ?> </p>

            <p><b>Promised Delivery date:</b> <?= $promise_date ?></p>
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
            <p>Please review the information provided and respond so we may update our records accordingly.</p>
            <p>If there are multiple delivery dates scheduled, please reference the line number, part number, and nomenclature from our purchase order when replying.</p>

            <p><strong>We encourage all our vendors to meet a 90% on-time delivery target.</strong></p>
            <p>Your current on-time delivery percentage is:  <b><?= $percent ?>%</b> for the period of <b> <?= ( new \DateTime($start_date))->format('m-d-Y') ?> - <?= ( new \DateTime($end_date ))->format('m-d-Y') ?></b></p>
            <p>We kindly ask you to confirm that:</p>

            <ul>
                <li>You have received the purchase order</li>
                <li>You accept the terms and conditions</li>
                <li>You are able to meet the stated delivery date</li>
            </ul>

            <p style="margin-top: 30px;">If revisions are necessary, please indicate the affected line number(s), part number(s), and description(s) in your response.,<br>
            Thank you for your prompt attention to this request.</p>

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
