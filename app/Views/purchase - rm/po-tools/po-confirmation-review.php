<style>
.bg-muted-danger{
    background-color:#914d59;
 }
</style>


<div class="modal-header">  
<h5><?= $data->id ?> : <?= $data->name ?> : <?= $data->purchase_order ?></h5>
</div>

<div class="modal-body">
    <?php if( $data->has_lines) : ?>

    <p class="text-center fs-5"><strong>All Vendors are encourage to meet a 90% on-time delivery target.</strong><br>
    As of <span class="fw-bold"><?= esc($data->todays_date) ?> </span> <?= $data->name ?> : on-time delivery percentage is <strong><?= esc( ( $data->performance['metric'] ) ? $data->performance['metric'] .'%' : 'N/A' ) ?></strong>.</p>

    <div class="row">
        <table class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th>PO</th>
                    <th>Line</th>
                    <th>Order Date</th>
                    <th>Promise Date</th>
                    <th>Part #</th>
                    <th>Description</th>
                    <th>Ordered</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->lines as $item ) : ?> 
                <?php $item =  (object) $item ?>
                <tr>
                    <td><?= $item->id ?></td>
                    <td><?= $item->line_no ?></td>
                    <td><?= (new DateTime( $item->order_date ))->format('m/d/Y') ?></td>
                    <td><?= (new DateTime( $item->line_promise_date ))->format('m/d/Y') ?></td>
                    <td><?= $item->part_id ?></td>
                    <td><?= $item->description ?></td>
                    <td><?= $item->order_qty ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php else: ?>
    <div class="alert alert-info d-flex justify-content-center align-items-center">
        <h5 class="h5">No trackable parts found on this PO — some vendors like Amazon may not list part numbers.</h5>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-3"></div>
        <div class="col-6">
            <div class="form-floating">
                <input type="text" name="email_to" class="form-control" placeholder="" value="<?= strtolower(($data->contact_email)) ?? '' ?>">
                <label for="email_to">Email TO:</label>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <input type="hidden" name="vendor_id" value="<?= $data->id ?>">
    <input type="hidden" name="purchase_order_id" value="<?= $data->purchase_order ?>">
    <input type="hidden" name="promise_date" value="<?= $promise_date ?>">
    <button type="submit" class="btn btn-primary">Email Vendor</button>
</div>

