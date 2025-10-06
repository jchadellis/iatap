

<div class="card border-0 h-100 px-2 rounded-0">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-sm font-weight-bold text-gray text-uppercase mb-2 pb-1  border-bottom ">
                    <i class="bi bi-calendar3 text-upper"></i>&nbsp;Holidays
                </div>
                <div style="color: var(--bs-gray-600)">
                    <?php foreach($data as  $row) : ?>
                        <?php $start  = new DateTime($row->start_date); ?>
                        <?php $today = new DateTime(); ?>
                        <?php if( $start >= $today ): ?>
                            <div class="d-flex mb-3">
                                <div class="d-flex flex-row">
                                    <img class="" src="<?= base_url('assets/img/'.$row->icon) ?>" alt="hoilday-icon" style="width:70px">
                                    <div class="d-flex flex-column ms-3 justify-content-center">
                                        <span class="fw-bold"><?= $row->name ?></span>
                                        <?=  ((new DateTime($row->start_date))->format('M d, Y')) ?? '' ?> <?= ( $row->end_date ) ? ' - ' . (new DateTime($row->end_date))->format('M d, Y') : ''  ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
