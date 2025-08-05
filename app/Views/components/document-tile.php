<?php foreach($data as $document) : ?>
<div class="row m-1 mb-4">
    <div class="col mx-auto p-2 border ">
        <div class="row p-1">
            <div class="col-3 d-none d-xxl-block" >
                <div class="d-flex justify-content-center align-items-center h-100 <?= $document['color'] ?>" >
                    <div style="width:50px">
                        <?= view($document['icon']) ?>
                    </div>
                </div>

            </div>
            <div class="col-xxl-9 col-xl-12">
                <div class="row">
                    <div class="col-12 text-start mb-2">
                        <h6 class="h6 pb-0 m-0"><?= $document['name'] ?></h6>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-12">

                    </div>
                </div>
                <div class="row">
                    <div class="d-grid">
                        <a  href='<?= base_url($document['url']) ?>' class="btn btn-outline-primary" type="button"><?= ($document['btn_text']) ? $document['btn_text'] : 'Download' ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>