
<?php foreach($data as $card ) : ?>
<div class="row m-1 mb-4">
    <div class="col mx-auto p-2 border ">
        <div class="row p-2">
            <div class="col-1 d-none d-xxl-block" >
                <div class="d-flex justify-content-center align-items-center h-100 <?= $card['color'] ?>">
                    <div style="width:55px">
                        <?= view($card['icon']) ?>
                    </div>
                </div>

            </div>
            <div class="col-xxl-11 col-xl-12">
                <div class="row">
                    <div class="col-12 text-start mb-2">
                        <h6 class="h6 pb-0 m-0"><?= $card['name'] ?></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <?= $card['description'] ?>
                    </div>
                    <div class="col-4">
                        <div class="d-grid">
                            <div class="d-grid">
                                <a href='<?= base_url($card['url']) ?>' class="btn btn-outline-primary" type="button"><?= $card['btn_text'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>