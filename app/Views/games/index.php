<div class="row gap-2">
<?php if(isset($cards)) : ?>
<?php foreach($cards as $card) : ?>
    <div class="col-3">
        <a href="<?= base_url($card['url']) ?>" class="text-decoration-none">
        <div class="card d-flex flex-row rounded-0" style="">
            <img src="<?= base_url('assets/img/sec_logo.jpg')?>" class="rounded-0" alt="">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <h5 class="" ><?= $card['name'] ?></h5>
                </div>
            </div>
        </div>
        </a>
    </div>
<?php endforeach; ?>
<?php endif; ?>
</div>
