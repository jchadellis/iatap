<div class="row">
    <div class="col-xxl-8 col-xl-12">
        <div class="row">
            <div class="col">
                <h5 class="h5">
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

    <div class="col-xxl-4 col-xl-6">
        <div class="row">
            <div class="col">
                <h5 class="h5">
                    <?= $title ?? ''?> Documents
                </h5>
            </div>
        </div>
        <?= view('components/document-tile', ['data' => $documents ?? [] ]) ?>
    </div>
</div>
