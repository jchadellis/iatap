
<div class="row">
    <div class="col">
        <h5 class="h5">
            Production Tools 
        </h5>
    </div>
</div>
<div class="col-8">
    <?php if( auth()->user()->inGroup(...$groups) ) : ?>
    <?= view('components/tool-card', ['data' => $secure_cards]) ?>
    <?php else: ?>
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        Hi there! These production tools require special access. You'll need to be in one of these groups: "<span class="fw-bold"><?= strtoupper(implode(', ', $groups))  ?></span>". 
        <a href="<?= base_url('login') ?>" class="alert-link">Please login</a> with an account that has the proper permissions, or contact your administrator for access.
    </div>
    <?php endif; ?>
</div>

