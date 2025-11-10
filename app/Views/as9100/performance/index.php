<div class="row mt-2">
     <form action="" id="date-form">
    <div class="col-12 col-md-12 col-lg-11 col-xl-9 col-xxl-8 mx-auto">
        <form action="" id="date-form">
            <div class="input-group">
                <span class="input-group-text">Select Range</span>
                <input type="text" name="date_range" class="form-control datepicker text-center" placeholder="" id="">
                <button type="submit" class="btn btn-primary"><i class="bi bi-bar-chart-fill"></i>&nbsp;Update Charts</button>
                <a type="submit" class="btn btn-outline-secondary" href="<?= base_url('as9100/performance-charts/reset') ?>"><i class="bi bi-arrow-clockwise"></i>&nbsp;Reset Charts</a>
            </div>
        </form>
    </div>
    </form>
</div>
<div class="row">
    <div class="col-12">
        <hr class="border-dark">
    </div>
</div>
<?php if($top_cards) : ?>
<div class="row g-3">
    <?php foreach($top_cards as $card) : ?>
    <div class="col-12 col-lg-6 col-xxl-3">
        <div class=" border-0 border-start border-<?= $card['color'] ?> border-4  rounded-3" >
            <div class="card shadow-sm rounded-1">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-dark"><?= $card['title'] ?> : <span id="<?= $card['id'] ?>"><?= $card['counts'] ?></span></h5>
                            <p class="text-muted small date-range"><?= $card['date_range'] ?></p>
                        </div>
                        <div class="bg-<?= $card['color'] ?> rounded-circle align-items-center d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                            <i class="bi <?= $card['icon'] ?> text-white fs-2"></i>
                            <a href="<?= $card['url'] ?>" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif;?>

<?php if($chart_cards) : ?>
<div class="row mt-3 g-2">
    <?php foreach($chart_cards as $card) : ?>
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm rounded-1">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center text-dark">
                    <div>
                        <h5 class="p-0 m-0"><?= $card['title'] ?></h5>
                        <p class="text-muted small p-0 m-0 date-range"><?= $card['date_range'] ?></p>
                    </div>
                    <div class="d-flex align-item-center justify-content-end text-<?= $card['color'] ?> flex-fill">
                        <a href="<?= $card['download_url'] ?>" class="btn btn-link text-decoration-none text-<?= $card['color'] ?>"><i class="bi bi-arrow-down-circle fs-4"></i></a>
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-75 mx-auto">
                    <canvas id="<?= $card['chart_id'] ?>"></canvas>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-link text-decoration-none fw-bold text-<?= $card['color'] ?>" href="<?= $card['report_url'] ?>">Open Report&nbsp;<i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
