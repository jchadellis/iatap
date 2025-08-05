<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col">
                <h5 class="h5">
                    Tools
                </h5>
            </div>
        </div>
        <?= view('components/tool-card', ['data' => $tool_cards ]) ?>
    </div>
    <?php if( auth()->inGroup('maintenance') ) : ?>
    <div class="col-xxl-4 col-xl-6">
        <div class="row">
            <div class="col">
                <h5 class="h5">
                    Documents
                </h5>
            </div>
        </div>
        <?= view('components/document-tile', ['data' => $documents ]) ?>
    </div>
    <?php endif; ?>
</div>


<?php if( auth()->inGroup('maintenance') ) : ?>
<div class="row">
    <div class="col">
        <h5 class="h5">
            Charts
        </h5>
    </div>
</div>
<div class="row">
    <div class="col-4 m-0 p-1 d-flex">
        <div class="card h-100 w-100">
            <div class="card-header">
                Maintenance Performance
                <p class="float-end m-0">
                    <?php echo date('m-d-Y') ?>
                </p>
            </div>
            <div class="card-body ">
                <div class="chart-container">
                    <canvas id="maintenancePerformanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4 m-0 p-1 d-flex">
        <div class="card h-100 w-100">
            <div class="card-header">
                Woodshop Performance
                <p class="float-end m-0">
                    <?php echo date('m-d-Y') ?>
                </p>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="woodshopPerformanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col m-0 p-1">
                <div class="card">
                    <div class="card-header">
                        Maintenance Tickets Last 3 Months
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="maintenanceServiceTicketChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m-0 p-1">
                <div class="card">
                    <div class="card-header">
                        Woodshop Tickets Last 3 Months
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="woodshopServiceTicketChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>