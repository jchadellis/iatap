<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger fade show"  id="errors-alert">
        <?= esc(session()->getFlashdata('errors')) ?>
    </div>
<?php endif; ?>