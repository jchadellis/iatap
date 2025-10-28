
<div class="text-sm font-weight-bold text-gray text-uppercase mb-2 mx-2 pb-1  border-bottom ">
    <i class="bi bi-calendar3 text-upper"></i>&nbsp;Holidays
</div>
<?php foreach($data as $row) : ?>
<?php $start  = new DateTime($row->start_date); ?>
<?php $today = new DateTime(); ?>
<?php if( $start >= $today ): ?>
<div class="card border-0 h-100 round-0 text-muted">
    <div class="card-body m-0 p-1">
        <div class="d-flex justify-content-start">
            <div>
                <img class="" src="<?= base_url('assets/img/'.$row->icon) ?>" alt="hoilday-icon" style="width:60px">
            </div>
            <div class="d-flex flex-column ms-3">
                <span class="fw-bold"><?= $row->name ?></span>
                <p class="m-0 p-0"><?=  ((new DateTime($row->start_date))->format('M d, Y')) ?? '' ?> </p>
                <p class="m-0 p-0"><?= ( $row->end_date ) ? (new DateTime($row->end_date))->format('M d, Y') : ''  ?></p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
