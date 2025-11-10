<?php 
    $pie_charts = [
        [
            'title' => 'Vendor Performance', 
            'date_range' => 'Last 90 Days', 
            'color' => 'primary', 
            'report_url' => base_url('vendors/performance'), 
            'download_url' => base_url('vendors/performance'), 
            'chart_id' => 'performance-chart', 
        ],
    ]; 

    $bar_charts = [
        [
            'title' => 'Purchase Orders 2025', 
            'date_range' => 'By Month', 
            'color' => 'primary', 
            'report_url' => '#!', 
            'download_url' => '#!', 
            'chart_id' => 'totals-chart', 
        ],
    ];

    $purchasing_cards = [
        [       
            'title' => 'Paint', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-table', 
            'url' => base_url('purchasing/paint-report'), 
        ],
        [       
            'title' => 'Fabrication', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-table', 
            'url' => base_url('purchasing/fabrication-report'), 
        ],
        [       
            'title' => 'Orders', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-table', 
            'url' => base_url('purchasing/orders'), 
        ],
        [       
            'title' => 'Safety Stock', 
            'description' => '', 
            'color' => 'success', 
            'icon' => 'bi bi-table', 
            'url' => base_url('purchasing/safety-stock'), 
        ],
    ];

    $booking_cards = [
        [       
            'title' => 'Bookings', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-table', 
            'url' => base_url('purchasing/tools/bookings'), 
        ],
        [       
            'title' => 'Confirmations', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-table', 
            'url' => base_url('purchasing/tools/confirmations'), 
        ],
    ];

    $vendor_cards = [
        [       
            'title' => 'List', 
            'description' => '', 
            'color' => 'primary', 
            'icon' => 'bi bi-table', 
            'url' => base_url('vendors/list'), 
        ],
        [       
            'title' => 'Performance', 
            'description' => '', 
            'color' => 'info', 
            'icon' => 'bi bi-bar-chart', 
            'url' => base_url('vendors/performance'), 
        ],
        [       
            'title' => 'JCP Report', 
            'description' => '', 
            'color' => 'success', 
            'icon' => 'bi bi-exclamation-circle', 
            'url' => base_url('vendors/jcp-report'), 
        ],
    ];

    $other_cards = [
        [       
            'title' => 'Work Request', 
            'description' => '', 
            'color' => 'accent2', 
            'icon' => 'bi bi-input-cursor-text', 
            'url' => '#!',
            //'url' => base_url('purchasing/work-request'), 
        ],
        [       
            'title' => 'Paint Issued Report', 
            'description' => '', 
            'color' => 'success', 
            'icon' => 'bi bi-table', 
            'url' => base_url('purchasing/paint-issued'), 
        ],
    ];


    $document_cards = [
        [
            'title' => 'DoD Export Control From',
            'icon' => 'bi bi-file-earmark-pdf',
            'color' => 'danger', 
            'url' => "http://connectportal/assets/documents/purchasing/ecda.pdf", 
        ],
        [
            'title' => 'Product Return Form',
            'icon' => 'bi bi-file-earmark-pdf',
            'color' => 'danger', 
            'url' => "http://connectportal/assets/documents/purchasing/return-form.pdf", 
        ],
        [
            'title' => 'Product Return Process',
            'icon' => 'bi bi-file-earmark-pdf',
            'color' => 'danger', 
            'url' => "http://connectportal/assets/documents/purchasing/return-process.pdf", 
        ]
    ];
?>


<div class="row d-flex align-items-stretch">
    <div class="d-none d-lg-block col-lg-6 col-xl-4">
        <div class="card shadow-sm rounded-1 h-100">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center text-dark">
                    <div>
                        <h5 class="p-0 m-0"><?= $pie_charts[0]['title'] ?></h5>
                        <p class="text-muted small p-0 m-0 date-range"><?= $pie_charts[0]['date_range'] ?></p>
                    </div>
                    <div class="d-flex align-item-center justify-content-end text-<?= $pie_charts[0]['color'] ?> flex-fill">
                        <a href="<?= $pie_charts[0]['download_url'] ?>" class="btn btn-link text-decoration-none text-<?= $pie_charts[0]['color'] ?>"><i class="bi bi-arrow-down-circle fs-4"></i></a>    
                    </div>
                </div>
            </div>
            <div class="card-body d-flex align-items-center">
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
    <div class="d-none d-lg-block col-lg-6 col-xl-8">
        <div class="card shadow-sm rounded-1 h-100">
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
            <div class="card-body d-flex align-items-center">
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
<hr>
<div class="row mt-2">
    <div class="col-12 col-xl-9">
       <div class="d-flex flex-wrap">
            <div class="col-12 col-lg-6 col-xl-3">
                <h5 class="text-center">Ordering</h5>
                <?php foreach($purchasing_cards as $card) : ?>
                <div class="card m-1 border-0 border-end border-top border-bottom shadow-sm" >
                    <div class="card-body border-start border-<?= $card['color'] ?> border-5 rounded-3 d-flex flex-row align-items-center">
                        <h6 class="flex-wrap flex-fill w-75 text-truncate"><?= $card['title'] ?></h6>
                        <div class="d-flex justify-content-center align-items-center bg-<?= $card['color'] ?> rounded-circle ms-2"
                            style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-<?= $card['icon'] ?> text-white fs-4"></i>
                            <a href="<?= $card['url'] ?>" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <h5 class="text-center">Bookings</h5>
                <?php foreach($booking_cards as $card) : ?>
                <div class="card m-1 border-0 border-end border-top border-bottom shadow-sm" >
                    <div class="card-body border-start border-<?= $card['color'] ?> border-5 rounded-3 d-flex flex-row align-items-center">
                        <h6 class="flex-wrap flex-fill w-75 text-truncate"><?= $card['title'] ?></h6>
                        <div class="d-flex justify-content-center align-items-center bg-<?= $card['color'] ?> rounded-circle ms-2"
                            style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-<?= $card['icon'] ?> text-white fs-4"></i>
                            <a href="<?= $card['url'] ?>" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <h5 class="text-center">Vendor</h5>
                <?php foreach($vendor_cards as $card) : ?>
                <div class="card m-1 border-0 border-end border-top border-bottom shadow-sm" >
                    <div class="card-body border-start border-<?= $card['color'] ?> border-5 rounded-3 d-flex flex-row align-items-center">
                        <h6 class="flex-wrap flex-fill w-75 text-truncate"><?= $card['title'] ?></h6>
                        <div class="d-flex justify-content-center align-items-center bg-<?= $card['color'] ?> rounded-circle ms-2"
                            style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-<?= $card['icon'] ?> text-white fs-4"></i>
                            <a href="<?= $card['url'] ?>" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <h5 class="text-center">Other</h5>
                <?php foreach($other_cards as $card) : ?>
                <div class="card m-1 border-0 border-end border-top border-bottom shadow-sm" >
                    <div class="card-body border-start border-<?= $card['color'] ?> border-5 rounded-3 d-flex flex-row align-items-center">
                        <h6 class="flex-wrap flex-fill w-75 text-truncate"><?= $card['title'] ?></h6>
                        <div class="d-flex justify-content-center align-items-center bg-<?= $card['color'] ?> rounded-circle ms-2"
                            style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-<?= $card['icon'] ?> text-white fs-4"></i>
                            <a href="<?= $card['url'] ?>" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
       </div>
    </div>
    <div class="col-12 col-xl-3">
        <h5 class="text-center">Documents</h5>
        <?php foreach($document_cards as $card) : ?>
        <div class="card m-1 border-0 border-end border-top border-bottom shadow-sm" >
            <div class="card-body border-start border-<?= $card['color'] ?> border-5 rounded-3 d-flex flex-row align-items-center">
                <h6 class="flex-wrap flex-fill w-75 text-truncate"><?= $card['title'] ?></h6>
                <div class="d-flex justify-content-center align-items-center bg-<?= $card['color'] ?> rounded-circle ms-2"
                    style="width: 40px; height: 40px; flex-shrink: 0;">
                    <i class="bi bi-<?= $card['icon'] ?> text-white fs-4"></i>
                    <a href="<?= $card['url'] ?>" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
