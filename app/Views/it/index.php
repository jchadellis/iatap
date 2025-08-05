<div class="row mb-1">
    <h5 class="h5">
        Tools
    </h5>
</div>

<div class="row">
    <div class="col-8">
        <?= view('components/tool-card', ['data' => $tool_cards]) ?>
    </div>
</div>
<?php if( auth()->inGroup('it') ) : ?>
<div class="row mb-1">
    <h5 class="h5">
        Charts
    </h5>
</div>

<div class="row">
    <div class="col-4 m-0 p-1 d-flex">
        <div class="card h-100 w-100">
            <div class="card-header">
                IT Peformance 
                <p class="float-end m-0">
                    <?php echo date('m-d-Y') ?>
                </p>
            </div>
            <div class="card-body ">
                <div class="chart-container">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4 m-0 p-1 d-flex">
        <div class="card h-100 w-100">
            <div class="card-header">
                IT Support Tickets Last 3 Months
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="serviceTicketChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>