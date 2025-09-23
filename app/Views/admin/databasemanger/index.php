<div class="row mt-3">
    <div class="col-12">
        <div class="row p-0">
            <div class="col-6">
                <h5>Site Data Backups</h5>
            </div>
            <div class="col-6 ">
                <a href="<?= base_url('sadmin/backup-manager/backup-site') ?>" class="btn btn-primary float-end"><i class="bi bi-floppy"></i>&nbsp;Backup Now</a>
            </div>
        </div>
        
        <hr class="p-0 my-2">
        <div class="d-flex flex-wrap gap-2">
        <?php if( isset($site_backups) ) : ?>
        <?php foreach($site_backups as $key => $file) : ?>
        
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="d-flex align-items-center flex-shrink-0" style="width:50px">
                            <?= view('components/icon/circle-stack'); ?>
                        </div> 
                        <div class="d-flex flex-column">
                            <h6 class="ms-2"><?= $file ?></h6>
                            <div class="d-flex flex-row ">
                                <a  class="btn btn-primary ms-2 flex-grow-1" href="<?= base_url('sadmin/backup-manager/download-file/site_db/'.$file) ?>" class="text-decoration-none text-dark"><i class="bi bi-cloud-download"></i>&nbsp;Download</a>
                                <a  class="btn btn-danger ms-2 flex-grow-1" href="<?= base_url('sadmin/backup-manager/delete-file/site_db/'.$file) ?>" class="text-decoration-none text-dark"><i class="bi bi-trash"></i>&nbsp;Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
    
    <hr class="my-2">
    </div>
    
</div>
<div class="row mt-3">
    <div class="col-12">
        <div class="row p-0">
            <div class="col-6">
                <h5>Visual Cache Data Backups</h5>
            </div>
            <div class="col-6 ">
                <a href="<?= base_url('sadmin/backup-manager/backup-visual') ?>" class="btn btn-primary float-end"><i class="bi bi-floppy"></i>&nbsp;Backup Now</a>
            </div>
        </div>
        
        <hr class="p-0 my-2">
        <div class="d-flex flex-wrap gap-2">
        <?php if( isset($visual_backups) ) : ?>
        <?php foreach($visual_backups as $key => $file) : ?>
        
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="d-flex align-items-center flex-shrink-0" style="width:50px">
                            <?= view('components/icon/circle-stack'); ?>
                        </div> 
                        <div class="d-flex flex-column">
                            <h6 class="ms-2"><?= $file ?></h6>
                            <div class="d-flex flex-row ">
                                <a  class="btn btn-primary ms-2 flex-grow-1" href="<?= base_url('sadmin/backup-manager/download-file/visual_cache_db/'.$file) ?>" class="text-decoration-none text-dark"><i class="bi bi-cloud-download"></i>&nbsp;Download</a>
                                <a  class="btn btn-danger ms-2 flex-grow-1" href="<?= base_url('sadmin/backup-manager/delete-file/visual_cache_db/'.$file) ?>" class="text-decoration-none text-dark"><i class="bi bi-trash"></i>&nbsp;Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
    <hr class="my-2">
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <div class="row p-0">
            <div class="col-6">
                <h5>iATAP Application Files Backup</h5>
            </div>
            <div class="col-6 ">
                <a href="<?= base_url('sadmin/backup-manager/site-files-backup') ?>" class="btn btn-primary float-end"><i class="bi bi-floppy"></i>&nbsp;Backup Now</a>
            </div>
        </div>
        
        <hr class="p-0 my-2">
        <div class="d-flex flex-wrap gap-2">
        <?php if( isset($site_files) ) : ?>
        <?php foreach($site_files as $key => $file) : ?>
        
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="d-flex align-items-center flex-shrink-0" style="width:50px">
                            <?= view('components/icon/circle-stack'); ?>
                        </div> 
                        <div class="d-flex flex-column">
                            <h6 class="ms-2"><?= $file ?></h6>
                            <div class="d-flex flex-row ">
                                <a  class="btn btn-primary ms-2 flex-grow-1" href="<?= base_url('sadmin/backup-manager/download-site-files/'.$file) ?>" class="text-decoration-none text-dark"><i class="bi bi-cloud-download"></i>&nbsp;Download</a>
                                <a  class="btn btn-danger ms-2 flex-grow-1" href="<?= base_url('sadmin/backup-manager/delete-site-files/'.$file) ?>" class="text-decoration-none text-dark"><i class="bi bi-trash"></i>&nbsp;Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </div>
</div>