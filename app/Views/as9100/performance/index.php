<div class="row mt-2">
    <div class="col-7 mx-auto">
        <form action="" id="date-form">
            <div class="input-group">
                <span class="input-group-text">Start Date</span>
                <input type="text" name="start" class="form-control datepicker text-center" placeholder="" id="">
                <span class="input-group-text">End Date</span>
                <input type="text" name="end" class="form-control datepicker text-center" placeholder="" id="">
                <button type="submit" class="btn btn-primary"><i class="bi bi-bar-chart-fill"></i>&nbsp;Update Charts</button>
                <a type="submit" class="btn btn-outline-secondary" href="<?= base_url('as9100/performance-charts/reset') ?>"><i class="bi bi-arrow-clockwise"></i>&nbsp;Reset Charts</a>
            </div>
        </form>
    </div>
</div>

<div class="row mt-4">
    <div class="col-3 mx-auto">
        <canvas id="sales-chart" height="100px"></canvas>
    </div>
    <div class="col-3 mx-auto">
        <canvas id="engineering-chart" height="100px"></canvas>
    </div>
    <div class="col-3 mx-auto">
        <canvas id="vendor-chart" height="100px"></canvas>
    </div>
    <div class="col-3">
         <canvas id="counts-chart" height="100px"></canvas>
    </div>
</div>

<div class="row mt-3">
    <div class="col-3 mx-auto">
        <a class="btn btn-outline-primary w-100 m-1" href="<?= base_url('sales/performance') ?>" target="_blank"><i class="bi bi-table"></i>&nbsp;View Report</a>
    </div>
    <div class="col-3 mx-auto">
        &nbsp;
    </div>
    <div class="col-3 mx-auto">
        <a class="btn btn-outline-primary w-100 m-1"  href="<?= base_url('vendors/performance') ?>" target="_blank"><i class="bi bi-table"></i>&nbsp;View Report</a>
    </div>
    <div class="col-3 mx-auto">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-outline-primary w-100 m-1" href="<?= base_url('shipping/performance') ?>" target="_blank"><i class="bi bi-table"></i>&nbsp;Shipping Report</a>
                <a class="btn btn-outline-primary w-100 m-1" href="<?= base_url('shipping/rmas') ?>" target="_blank"><i class="bi bi-table"></i>&nbsp;RMA Report</a>
                <a class="btn btn-outline-primary w-100 m-1" href="<?= base_url('quality/ncp') ?>" target="_blank"><i class="bi bi-table"></i>&nbsp;NCP Report</a>
                <a class="btn btn-outline-primary w-100 m-1" href="<?= base_url('quality/internal-audit') ?>" target="_blank"><i class="bi bi-table"></i>&nbsp;Internal Audits</a>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="content-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Header Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>