<?php 
    $vendor_id = $data[0][0]->id;
    $vendor_name = $data[0][0]->name;  
    $percent = $data[0][0]->performance['on_time_percentage']; 
    $color = $data[0][0]->po_status_color; 
    $today = new \DateTime(); 
?>

<div class="modal-header">
     <h5><?= $vendor_id ?> : <?= $vendor_name ?> </h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <pre>
        <?php //print_r($data); return ;?>
    </pre>


    <?php if( isset($data) ) : ?>
    <p class="text-center fs-6"><strong>All Vendors are encourage to meet a 90% on-time delivery target.</strong><br>
        As of <span class="fw-bold"><?= $today->format('m-d-Y') ?> </span><strong><?= $vendor_name ?></strong> has a on-time percentage of </p>
    
    <div class="progress mb-4" role="progressbar" aria-label="Danger example" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100" style="height: 30px">
        <div class="progress-bar fs-6 <?= $color ?>" style="width: <?= $percent ?>%" ><?= $percent ?>%</div>
    </div>
    
    
    <?php foreach($data as $po ) : ?>

        <table class="table table-striped table-bordered">
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
                <tr class="<?= $line['status_color'] ?>">
                    <td><?= $line['line_no'] ?></td>
                    <td><?= $line['part_id'] ?></td>
                    <td><?= $line['description'] ?></td>
                    <td><?= $line['user_order_qty'] ?></td>
                    <td><?= $line['user_received_qty'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>&nbsp;Close</button>
    <button type="button" class="btn btn-primary" id="email-vendor"><i class="bi bi-envelope"></i>&nbsp;Email Vendor</button>
</div>