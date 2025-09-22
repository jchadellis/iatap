<style>
    .tool-card:hover{
        background-color : #d5ebfbff !important; 
    }
</style>

<?php if(isset($data)) : ?>
<?php foreach($data as $card ) : ?>

<div class="d-flex flex-wrap gap-2 ">
    <div class="card rounded-0 mb-2 w-100 " >
        <a href="<?= (base_url($card['url'])) ?? '' ?>" class="text-decoration-none text-dark">
            <div class="card-body tool-card">
                <div class="d-flex flex-row">
                    <div class="d-flex justify-content-center align-items-center me-2" style="width:55px">
                        <?= ( $card['icon'] !== '') ? view($card['icon']) : '' ?>
                    </div>
                    <div class="d-flex flex-column ms-2 ps-3">
                        <h6 class="h5 "><?= $card['name'] ?? ''?></h5>
                        <hr class="p-1 m-0">
                        <div>
                             <?= $card['description'] ?? '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>