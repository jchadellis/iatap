<?php helper('form'); ?>
<div class="row">
    <div class="col-12">
        <?php if(($assigned_to) ?? false ) : ?>
            <p class="badge text-bg-primary float-end">Assigned To: <a class="text-decoration-none text-white" href="<?= base_url(($user_url)??'') ?>"><?= $assigned_to ?></a></p>
        <?php else: ?>
            <p class="badge text-bg-warning float-end">Not Assigned</p>
        <?php endif; ?> 
    </div>
</div>
<?= form_open('sadmin/asset/update/'.$asset->id, ['id' => 'assetForm' ]); ?>
<div class="row mb-2">
    <?php $value = old('display_name', $asset->display_name ?? '' ); ?>
    <?= formFloatingInput(['name' => 'display_name', 'label' => lang('Auth.display_name'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
    <?php $value = old('network_name',  $asset->network_name ?? '' ); ?>
    <?= formFloatingInput(['name' => 'network_name', 'label' => lang('Auth.net_name'), 'colClass'=> 'col-6', 'value' => $value, 'inputClass' => 'form-control text-uppercase' ]); ?>           
</div>
<div class="row mb-2">
    <?= formFloatingInput(['name' => 'type_id', 'label' => lang('Auth.ws_type'),  'colClass' => 'col-4', 'type' => 'select', 'selected' => $asset->type_id,  'select_options' => $host_types ]); ?> 
    <?php $value = old('ip_address', $asset->ip_address ?? '' ); ?>
    <?= formFloatingInput(['name' => 'ip_address', 'label' => lang('Auth.ip_add'), 'colClass'=> 'col-4', 'value' => $value ]); ?>    
    <?php $value = old('host[physical_location]',  $asset->physical_location ?? '' ); ?>
    <?= formFloatingInput(['name' => 'physical_location', 'label' => lang('Auth.phy_loc'), 'colClass'=> 'col-4', 'value' => $value ]); ?>    
</div>
<div class="row mb-2">
    <?= formFloatingInput(['name' => 'dept_id', 'label' => lang('Auth.dept'),  'colClass' => 'col-4', 'type' => 'select', 'select_options' => $depts, 'selected' => $asset->dept_id]); ?> 
    <?= formFloatingInput(['name' => 'switch_id', 'label' => lang('Auth.switch'),  'colClass' => 'col-4', 'type' => 'select', 'select_options' => $switches, 'selected' => $asset->switch_id ]); ?> 
    <?php $value = old('switch_port_no',  $asset->switch_port_no ?? '0' ); ?>
    <?= formFloatingInput(['name' => 'switch_port_no', 'label' => lang('Auth.port_no'), 'colClass'=> 'col-4', 'value' => $value ]); ?>   
</div>
<div class="row mb-2">
    <?php $value = old('host[make]', $asset->make ?? ''); ?>
    <?= formFloatingInput(['name' => 'make', 'label' => lang('Auth.make'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
    <?php $value = old('host[model]', $asset->model ?? '' ); ?>
    <?= formFloatingInput(['name' => 'model', 'label' => lang('Auth.model'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
</div>
<div class="row mb-2">
    <?php $value = old('operating_system',  $asset->operating_system ?? ''  ); ?>
    <?= formFloatingInput(['name' => 'operating_system', 'label' => lang('Auth.os'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
    <?php $value = old('processor', $asset->processor ?? ''); ?>
    <?= formFloatingInput(['name' => 'processor', 'label' => lang('Auth.processor'), 'colClass'=> 'col-6', 'value' => $value ]); ?>   
</div>
<div class="row mb-2">
    <?php $value = old('ram',  $asset->ram ); ?>
    <?= formFloatingInput(['name' => 'ram', 'label' => lang('Auth.ram'), 'colClass'=> 'col-6', 'value' => $value ]); ?>  
    <?php $value = old('mac',  $asset->mac); ?>
    <?= formFloatingInput(['name' => 'mac', 'label' => lang('Auth.mac'), 'colClass'=> 'col-6', 'value' => $value , 'inputClass' => 'form-control text-uppercase']); ?> 
</div>
<div class="row mb-2">
    <?php $value = old('serial_no', $asset->serial_no ?? '' ); ?>
    <?= formFloatingInput(['name' => 'serial_no', 'label' => lang('Auth.serial_no'), 'colClass'=> 'col-6', 'value' => $value, 'inputClass' => 'form-control text-uppercase']); ?>   
    <?php $value = old('service_tag_no',  $asset->service_tag_no ?? ''  ); ?>
    <?= formFloatingInput(['name' => 'service_tag_no', 'label' => lang('Auth.service_tag'), 'colClass'=> 'col-6', 'value' => $value, 'inputClass' => 'form-control text-uppercase' ]); ?>   
</div>         

<div class="row mb-2">
    <div class="col-3">
        <div class="form-check">
            <?php $value = old('is_active',  $asset->is_active ?? 't'  ); ?>
            <input type="hidden" name="is_active" value="f" >
            <input class="form-check-input" type="checkbox" name="is_active" data-toggle="toggle" data-on="Yes" data-off="No" data-size="normal" data-onstyle="success" data-offstyle="danger" value="t" <?= ($asset->is_active === 't') ? 'checked' : '' ?>>
            <label class="form-check-label" for="">Client Is Active</label>
        </div> 
    </div>
    <div class="col-3">
        <div class="form-check">
            <?php $value = old('has_web_login',  $asset->has_web_login ?? 'f'  ); ?>
            <input type="hidden" name="has_web_login" value="f" >
            <input class="form-check-input" type="checkbox" name="has_web_login" data-toggle="toggle" data-on="Yes" data-off="No" data-size="normal" data-onstyle="success" data-offstyle="danger" value="t" <?= ($asset->has_web_login === 't') ? 'checked' : '' ?>>
            <label class="form-check-label" for="">Has Web Login</label>
        </div> 
    </div>
    <div class="col-3 d-grid"><button class="btn btn-success" type="submit"> Save Updates</button></div>
<?= form_close() ?>
    <div class="col-3 d-grid"><a href="<?= base_url('sadmin/asset/delete/'). $asset->id ?>" class="btn btn-danger" type="button"> Delete </a></div>
</div>