<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success fade show"  id="success-alert">
        <?= esc(session()->getFlashdata('errors')) ?>
    </div>
<?php endif; ?>