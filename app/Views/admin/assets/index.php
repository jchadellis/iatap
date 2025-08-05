<?php helper('form'); ?>


<div class="row">
    <div class="col-4"></div>
    <div class="col-4"></div>
    <div class="col-4 d-grid">
        <a href="<?= base_url('sadmin/assets/print') ?>" title="Network Assets List" target="_blank" class="btn" style="background-color: var(--bs-yellow );" ><i class="bi bi-printer-fill"></i>&nbsp; Print List</a>
    </div>
</div>
<div class="row mb-2">
    <div class="col">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">Active</th>
                    <th class="text-center">Display name</th>
                    <th class="text-center">Network name</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">IP Address</th>
                    <th class="text-center">MAC</th>
                    <th class="text-center">Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($assets as $asset ) : ?>
                <tr class="<?= ($asset->is_active ==='f') ? 'table-warning' : '' ?> ">
                    <td class="text-center"><?= ($asset->is_active === 't') ? '<i class="bi bi-x-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>' ?></td>
                    <td class="text-center"><?= $asset->display_name ?></td>
                    <td class="text-center"><?= $asset->network_name ?></td>
                    <td class="text-center"><?= $asset->type ?></td>
                    <td class="text-center"><?= ($asset->has_web_login == 't') ? "<a href='http://$asset->ip_address' class='text-decoration-none' target='_blank'> $asset->ip_address </a>" : $asset->ip_address ?></td>
                    <td class="text-center"><?= $asset->mac ?></td>
                    <td class="text-center"><a target="_blank" href="<?= base_url('sadmin/asset/edit/'.$asset->id)?>" class="btn btn-primary"><i class="bi bi-pencil-fill"></i>&nbsp; Edit</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
