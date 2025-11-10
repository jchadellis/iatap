<?php 
    $pie_charts = [
        [
            'title' => 'Sales Performance', 
            'date_range' => 'Last 90 Days', 
            'color' => 'primary', 
            'report_url' => base_url('sales/performance'), 
            'download_url' => base_url('sales/performance/spreadsheet'), 
            'chart_id' => 'sales-performance-chart', 
        ],
        [
            'title' => 'Vendor Performance', 
            'date_range' => 'Last 90 Days', 
            'color' => 'primary', 
            'report_url' => '#!', 
            'download_url' => '#!', 
            'chart_id' => 'vendor-performance-chart', 
        ],
    ]; 

    $bar_charts = [
        [
            'title' => 'Sales 2025', 
            'date_range' => 'By Month', 
            'color' => 'primary', 
            'report_url' => '#!', 
            'download_url' => '#!', 
            'chart_id' => 'sales-total-chart', 
        ],
    ];

    $section_cards = [
        [       
            'title' => 'Customer List', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-buildings', 
            'url' => base_url('sales/customers'), 
        ],
        [       
            'title' => 'Customer Orders', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-receipt-cutoff', 
            'url' => base_url('sales/customers/open-orders'), 
        ],
        [       
            'title' => 'EDE Report', 
            'description' => '', 
            'color' => 'success', 
            'icon' => 'bi bi-file-earmark-x', 
            'url' => base_url('sales/ede/report/spreadsheet'), 
        ],
        [       
            'title' => 'Part Lookup', 
            'description' => '', 
            'color' => 'info', 
            'icon' => 'bi bi-binoculars', 
            'url' => base_url('warehouse/parts/part-lookup'), 
        ],
        // [       
        //     'title' => 'Conference RM Calendar', 
        //     'description' => '', 
        //     'color' => 'info', 
        //     'icon' => 'bi bi-calendar-range', 
        //     'url' => base_url('sales/resource-calendar'), 
        // ],
    ];


    $document_cards = [
        [
            'title' => 'Finanical Obligation Chart',
            'icon' => 'bi bi-file-earmark-pdf',
            'color' => 'danger', 
            'url' => "http://connectportal/assets/documents/sales/financial-obligation-chart.pdf", 
        ],
        [
            'title' => 'Return Process',
            'icon' => 'bi bi-file-earmark-pdf',
            'color' => 'danger', 
            'url' => "http://connectportal/assets/documents/sales/return-process.pdf", 
        ],
        [
            'title' => 'Risk Assessment',
            'icon' => 'bi bi-file-earmark-pdf',
            'color' => 'danger', 
            'url' => "http://connectportal/assets/documents/sales/risk-assessment.pdf", 
        ],
        [
            'title' => 'Standard Warranty',
            'icon' => 'bi bi-file-earmark-pdf',
            'color' => 'danger', 
            'url' => "http://connectportal/assets/documents/sales/warranty.pdf", 
        ]
    ];
?>


<div class="row d-flex align-items-stretch">
    <div class="col-4">
        <div class="card shadow-sm rounded-1 h-100">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center text-dark">
                    <div>
                        <h5 class="p-0 m-0"><?= $pie_charts[0]['title'] ?></h5>
                        <p class="text-muted small p-0 m-0 date-range"><?= $pie_charts[1]['date_range'] ?></p>
                    </div>
                    <div class="d-flex align-item-center justify-content-end text-<?= $pie_charts[0]['color'] ?> flex-fill">
                        <a href="<?= $pie_charts[0]['download_url'] ?>" class="btn btn-link text-decoration-none text-<?= $pie_charts[0]['color'] ?>"><i class="bi bi-arrow-down-circle fs-4"></i></a>    
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-75 mx-auto">
                    <canvas id="<?= $pie_charts[0]['chart_id'] ?>"></canvas>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-link text-decoration-none fw-bold text-<?= $pie_charts[0]['color'] ?>" href="<?= $pie_charts[0]['report_url'] ?>">Open Report&nbsp;<i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card shadow-sm rounded-1">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center text-dark">
                    <div>
                        <h5 class="p-0 m-0"><?= $bar_charts[0]['title'] ?></h5>
                        <p class="text-muted small p-0 m-0 date-range"><?= $bar_charts[0]['date_range'] ?></p>
                    </div>
                    <div class="d-flex align-item-center justify-content-end text-<?= $bar_charts[0]['color'] ?> flex-fill">
                        <!-- <a href="<?= $bar_charts[0]['download_url'] ?>" class="btn btn-link text-decoration-none text-<?= $bar_charts[0]['color'] ?>  pe-none"><i class="bi bi-arrow-down-circle fs-4"></i></a> -->
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-75 mx-auto">
                    <canvas id="<?= $bar_charts[0]['chart_id'] ?>"></canvas>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-link text-decoration-none fw-bold text-<?= $bar_charts[0]['color'] ?> pe-none" href="<?= $bar_charts[0]['report_url'] ?>">&nbsp;<i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-6">
      <div class="row g-2">
        <h5>Tools and Reports</h5>
        <?php foreach($section_cards as $card) : ?>
        <div class="col-12 col-lg-6">
            <div class=" border-0 border-start border-<?= $card['color'] ?> border-4  rounded-3" >
                <div class="card shadow-sm rounded-1">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mx-2">
                                <h6 class="text-dark"><?= $card['title'] ?></h6>
                            </div>
                            <div class="bg-<?= $card['color'] ?> rounded-circle d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                                <i class="bi <?= $card['icon'] ?> text-white fs-3"></i>
                                <a href="<?= $card['url'] ?>" class="stretched-link" target="_blank"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-6">
      <div class="row g-2">
        <h5>Documents & Forms</h5>
        <?php foreach($document_cards as $card) : ?>
        <div class="col-12 col-lg-6">
            <div class=" border-0 border-start border-<?= $card['color'] ?> border-4  rounded-3" >
                <div class="card shadow-sm rounded-1">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mx-2">
                                <h6 class="text-dark"><?= $card['title'] ?></h6>
                            </div>
                            <div class="bg-<?= $card['color'] ?> rounded-circle d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                                <i class="bi <?= $card['icon'] ?> text-white fs-3"></i>
                                <a href="<?= $card['url'] ?>" class="stretched-link" target="_blank"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
</div>
