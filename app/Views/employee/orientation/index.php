<div class="row" style="height: 200px">
<?php if($cards) : ?>
<?php foreach($cards as $card) : ?>
    <div class="col-3">
        <div class="card h-100">
            <img class="card-img-top" src="<?= base_url($card['card-thumb']) ?>">
            <div class="card-body">
                <h5 class="card-title text-center"><?= $card['title'] ?></h5>
                <!-- <p class="card-text"><?= $card['text'] ?></p> -->

            </div>
            <div class="card-footer">
                <div class="d-grid">
                    <a href="<?= base_url($card['btn-url']) ?>" class="btn btn-primary"><?= $card['btn-text'] ?></a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>
</div>
