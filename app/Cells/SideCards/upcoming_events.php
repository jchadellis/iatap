

<div class="card border-0 h-100" style="border-color: var(--bs-purple);">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-sm font-weight-bold text-gray text-uppercase mb-2 pb-1 ">
                <i class="bi bi-calendar3 text-upper"></i>&nbsp; Holidays</div>
                <div class="" style="color: var(--bs-gray-600)">
                    <?php foreach($data as  $row) : ?>
                    <?php $start  = new DateTime($row->start_date); ?>
                    <?php $today = new DateTime(); ?>
                    <?php if( $start >= $today ): ?>
                    <div class="row my-3">
                        <div class="col">
                            <div class="row shadow-sm border-bottom border-end rounded border-secodary p-2">
                                <div class="d-none d-xl-block col-2"><div class="d-flex justify-content-center align-items-center h-100"><img style="width:32px" src="<?= base_url('assets/img/'.$row->icon) ?>" alt=""></div></div>
                                <div class="col-lg-12 col-xl-10">
                                    <div class="row">
                                        <div class="col-12">
                                            <span class="fw-bold"><?= $row->name ?></span>
                                        </div>
                                        <div class="col">
                                        <?=  ((new DateTime($row->start_date))->format('M d, Y')) ?? '' ?> <?= ( $row->end_date ) ? ' - ' . (new DateTime($row->end_date))->format('M d, Y') : ''  ?>
                                        </div>
                                    </div>    
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-auto">
                
            </div>
        </div>
    </div>
</div>
