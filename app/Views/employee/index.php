<div class="row row-gap-2">
    
    <div class="col-4">
        <h6>Forms</h6>
        <?= view('components/document-tile', ['data' => $forms ]) ?>
    </div>
    <div class="col-4">
        <h6>Documents</h6>
        <?= view('components/document-tile', ['data' => $documents ]) ?>
    </div>
    <div class="col-4">
        <h6>Additional Resources</h6>
        <?= view('components/document-tile', ['data' => $resources ]) ?>
    </div>
</div>

