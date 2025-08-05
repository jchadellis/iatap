<?php helper('form'); ?>


<div class="row">
    <div class="col-4 d-grid">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assetModal">Add Asset</button>
    </div>
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

<div class="modal modal-lg" id="assetModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title">New Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('asset/create', ['id'=>'assetForm']); ?>
            <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="modal-alert-container">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <?php $value = old('display_name', '' ); ?>
                        <?= formFloatingInput(['name' => 'display_name', 'label' => lang('Auth.display_name'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
                        <?php $value = old('network_name',  '' ); ?>
                        <?= formFloatingInput(['name' => 'network_name', 'label' => lang('Auth.net_name'), 'colClass'=> 'col-6', 'value' => $value, 'inputClass' => 'form-control text-uppercase' ]); ?>           
                    </div>
                    <div class="row mb-2">
                        <?= formFloatingInput(['name' => 'type_id', 'label' => lang('Auth.ws_type'),  'colClass' => 'col-4', 'type' => 'select', 'select_options' => $host_types ]); ?> 
                        <?php $value = old('ip_address', '' ); ?>
                        <?= formFloatingInput(['name' => 'ip_address', 'label' => lang('Auth.ip_add'), 'colClass'=> 'col-4', 'value' => $value ]); ?>    
                        <?php $value = old('host[physical_location]',  '' ); ?>
                        <?= formFloatingInput(['name' => 'physical_location', 'label' => lang('Auth.phy_loc'), 'colClass'=> 'col-4', 'value' => $value ]); ?>    
                    </div>
                    <div class="row mb-2">
                        <?= formFloatingInput(['name' => 'dept_id', 'label' => lang('Auth.dept'),  'colClass' => 'col-4', 'type' => 'select', 'select_options' => $depts ]); ?> 
                        <?= formFloatingInput(['name' => 'switch', 'label' => lang('Auth.switch'),  'colClass' => 'col-4', 'type' => 'select', 'select_options' => $switches ]); ?> 
                        <?php $value = old('switch_port_no',  '0' ); ?>
                        <?= formFloatingInput(['name' => 'switch_port_no', 'label' => lang('Auth.port_no'), 'colClass'=> 'col-4', 'value' => $value ]); ?>   
                    </div>
                    <div class="row mb-2">
                        <?php $value = old('host[make]','' ); ?>
                        <?= formFloatingInput(['name' => 'make', 'label' => lang('Auth.make'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
                        <?php $value = old('host[model]', '' ); ?>
                        <?= formFloatingInput(['name' => 'model', 'label' => lang('Auth.model'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
                    </div>
                    <div class="row mb-2">
                        <?php $value = old('operating_system',  '' ); ?>
                        <?= formFloatingInput(['name' => 'operating_system', 'label' => lang('Auth.os'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
                        <?php $value = old('processor', '' ); ?>
                        <?= formFloatingInput(['name' => 'processor', 'label' => lang('Auth.processor'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
                    </div>
                    <div class="row mb-2">
                        <?php $value = old('ram',  '' ); ?>
                        <?= formFloatingInput(['name' => 'ram', 'label' => lang('Auth.ram'), 'colClass'=> 'col-6', 'value' => $value ]); ?>  
                        <?php $value = old('mac',  ''); ?>
                        <?= formFloatingInput(['name' => 'mac', 'label' => lang('Auth.mac'), 'colClass'=> 'col-6', 'value' => $value, 'inputClass' => 'form-control text-uppercase' ]); ?> 
                    </div>
                    <div class="row mb-2">
                        <?php $value = old('serial_no', '' ); ?>
                        <?= formFloatingInput(['name' => 'serial_no', 'label' => lang('Auth.serial_no'), 'colClass'=> 'col-6', 'value' => $value, 'inputClass' => 'form-control text-uppercase' ]); ?>   
                        <?php $value = old('service_tag_no',  '' ); ?>
                        <?= formFloatingInput(['name' => 'service_tag_no', 'label' => lang('Auth.service_tag'), 'colClass'=> 'col-6', 'value' => $value, 'inputClass' => 'form-control text-uppercase' ]); ?>   
                    </div>                
           </div>
           <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-secondary">Save Asset</button>
            </div>
           <?= form_close();?>
        </div>
    </div>
</div>