<style>
    .doc-card:hover{
        background-color: #eafaceff; 
    }
</style>

<hr>
<?php foreach($data as $card) : ?>
<div class="d-flex flex-wrap gap-2">
    <div class="card w-100 mb-2 rounded-0">
        <a class="text-decoration-none <?= $card['color'] ?>" href="<?= base_url($card['url']) ?>">
            <div class="card-body doc-card">
                <div class="d-flex flex-row align-items-center h-100">
                    <div style="width: 55px">
                        <?= view($card['icon']) ?>
                    </div>
                    <div class="d-flex justify-content-center w-100">
                        <h6 class="h6 pb-0 m-0 text-center"><?= $card['name'] ?></h6>
                    </div>
                    
                </div>
            </div>
        </a>
    </div>
</div>
<?php endforeach; ?>

