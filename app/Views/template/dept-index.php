<div class="row">
    <div class="col-12 col-lg-5">
        <div class="row">
            <div class="col">
                <h5 class="h5 text-center">
                    <?= $title ?? '' ?> Tools
                </h5>
            </div>
        </div>

        <?php if(!empty($secured_cards)) : ?>
            <?php  if($user->inGroup(...$groups)) :  ?>
                <?= view('components/tool-card', ['data' => $secured_cards ]) ?>
            <?php else: ?>
                <?php  $groups = implode(',',$groups); ?>
                <?= view_cell('App\Cells\Alerts\GroupAccessDeniedCell', ['groups' => $groups]) ?>
            <?php endif; ?>
        <?php endif; ?>

        <?= view('components/tool-card', ['data' => $tool_cards ]) ?>
    </div>
    <div class="col-12 col-lg-4">
        <div class="row">
            <div class="col">
                <h5 class="h5 text-center">
                    <?= $title ?? ''?> Charts
                </h5>
            </div>
        </div>
        <hr class="w-100">
        <div class="row">
            <div class="col">
                <canvas id="sales-chart" height="100px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="row">
            <div class="col">
                <h5 class="h5 text-center">
                    <?= $title ?? ''?> Documents
                </h5>
            </div>
        </div>
        <?= view('components/document-tile', ['data' => $documents ?? [] ]) ?>
    </div>

</div>
