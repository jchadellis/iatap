<form action="<?= base_url('as9100/engineering-performance')?>" method="post">
    <div class="row mb-2">
        <div class="col-8 mx-auto">
            <div class="input-group">
                <span class="input-group-text" >Start Date</span>
                <input type="text" name="start_date" class="form-control form-control-sm  datepicker">
                <span class="input-group-text">-</span>
                <span class="input-group-text">End Date</span>
                <input type="text" name="end_date" class="form-control form-control-sm  datepicker">
                <button type="submit" class="btn btn-primary">Get Range</button>
                <button type="button" class="btn btn-warning" id="reset-btn">Reset</button>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-8 mx-auto">
        <canvas id="engineeringChart" height="150" ></canvas>
        <p class="text-center">On Time Percentage: <?= number_format($engineering_data['percentage_on_time'],2) ?>%</p>
    </div>
</div>
