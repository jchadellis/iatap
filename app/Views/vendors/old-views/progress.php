
<div class="modal-header">
    <h6 class="modal-title"><?= $data->vendor_name ?></h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col">
            <h6 class="text-center bg-dark p-2 text-white">Vendor Performance Last 90 days </h6>
            <p class="text-center" ><span class="fw-bold"> On Time Delivery : </span> <span class="<?= $data->on_time > $data->late ? 'text-success' : 'text-danger' ?>" > <?= $data->on_time ?> </span> of <?= $data->total ?> <span class="fw-bold"> On Time</span></p>
            <div class="progress" role="progressbar" aria-label="Success striped example" aria-valuenow="<?= $data->percent ?>" aria-valuemin="0" aria-valuemax="100" style="height: 40px">
                <div class="progress-bar progress-bar-striped bg-success p-2" style="width: <?= $data->percent ?>%"> <?= $data->percent ?>% </div>
            </div>  
        </div>
    </div>
    <div class="row">
        <div class="col">

        </div>
    </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <form id="emailForm" action="<?= base_url('vendor/reminder/') ?>" method="post">
        <button type="submit" id="emailBtn" type="button" class="btn btn-primary" name="id" value="<?= $data->id ?>" >Email Reminder</button>
    </form>
</div>
</div>

