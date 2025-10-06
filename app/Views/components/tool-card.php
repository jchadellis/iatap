<hr class="w-100">
<div class="d-flex flex-wrap gap-1">
<?php foreach($data as $card ) : ?>
    <div class="card rounded-0 w-100">
        <a href="<?= base_url($card['url']) ?>" class="text-decoration-none text-dark">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="d-flex justify-content-center align-items-center me-2 flex-shrink-0" style="width:75px">
                        <?= $card['icon'] ? view($card['icon']) : '' ?>        
                    </div>
                    <div class="d-flex flex-column ms-2 ps-3 flex-fill">
                        <h6 class="h6 pb-0 m-0"><?= $card['name'] ?></h6>
                        <hr >
                        <div class="">
                            <?= $card['description'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php endforeach; ?>
</div>

