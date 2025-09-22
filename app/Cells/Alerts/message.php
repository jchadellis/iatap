<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success fade show"  id="message-alert">
        <?= esc(session()->getFlashdata('message')) ?>
    </div>
<?php endif; ?>