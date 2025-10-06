<div class="row">
    <div class="col">
        <div class="alert alert-warning text-center p-5 rounded shadow-sm">
            <img src="<?= base_url('assets/img/access-denied.png') ?>" alt="Access Denied" class="mb-4" style="max-width:200px;">
            <h4 class="alert-heading">Oops!</h4>
            <?php $group = session('denied_group'); ?>
            <p class="mt-3">
                Sorry, you don’t have access to this page yet.<br>
                To unlock them, please request access to the <a class="alert-link" href="<?= base_url("it/group-access-request/{$group}") ?>"> <span class="fw-bold"><?= ucwords($group); ?></span></a> group(s).<br>
                You can still go back or login under a different user below.
            </p>
            <hr>
            <div class="row mt-4">
                <div class="col-6 d-grid">
                    <a href="<?= previous_url() ?>" class="btn btn-primary">Return</a>
                </div>
                <div class="col-6 d-grid">
                    <a href="<?= base_url('/login') ?>" class="btn btn-outline-secondary">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>