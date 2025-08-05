<div class="row">
    <div class="col-xxl-8 col-xl-12">
        <div class="row">
            <div class="col">
                <h5 class="h5">
                    Purchasing Tools
                </h5>
            </div>
        </div>
        <?= view('components/tool-card', ['data' => $tool_cards ]) ?>
    </div>

    <div class="col-xxl-4 col-xl-6">
        <div class="row">
            <div class="col">
                <h5 class="h5">
                    Purchasing Documents
                </h5>
            </div>
        </div>
        <?= view('components/document-tile', ['data' => $documents ]) ?>
    </div>
</div>
