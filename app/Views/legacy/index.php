<div class="d-flex align-items-center border rounded-3 shadow-sm mb-4">
    <div class="w-25">
        <img src="<?= base_url('assets/img/vatap_logo.png') ?>" alt="" class="img-fluid ms-3">
    </div>
    <div>
        <blockquote class="blockquote p-3 ms-2">
           “The links below point to legacy tools and pages. These resources have since been moved or updated, but are provided here for reference.”
        </blockquote>
    </div>
</div>
<div class="row">
    <?php foreach( $links as $key => $group ) : ?>
    <div class="col-3 p-3">
        <h5 class="h5 text-center">
            <?= strtoupper($key) ?>
        </h5>
        <?php if( $group ) : ?>
            <ul class="list-group">
                <?php foreach($group as $link) : ?>
                    <a href="<?= $link['url'] ?>" class="list-group-item list-group-item-action"><?= $link['name'] ?></a>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>