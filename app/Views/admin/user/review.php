



<?php helper('form'); ?>
<div class="row">
    <div class="col">
        <div id="alert-container">

        </div>
    </div>
</div>
<?= form_open('sadmin/user/update/'.$user->id); ?>
<div class="row mb-2 ">
    <div class="col-3 d-grid">
        <button class="btn btn-success form-btn" disabled>Save Updates</button>
    </div>
    <div class="col-3 d-grid">
        <button class="btn btn-warning" id="form-btn" >Disable User</button>
    </div>
    <div class="col-3">

    </div>
    <div class="col-3 d-grid">
        <a href="<?= base_url('user/profile/'.$user->id)  ?>" class="btn btn-info" > User Profile</a>
    </div>
</div>
<input type="hidden" name="user[id]" value="<?= $user->id ?? null?>">
<div class="row">
    <div class="col">
        <div class="col border-bottom border-top border-warning border-2 p-3 mb-2">
            <h5 class="h5 border-2 border-bottom border-gray-200 p-2">User Information</h5>
            <div class="row mb-2">
                <?php $value = old('user[first_name', $user->first_name ?? ''); ?>
                <?= formFloatingInput(['name' => 'user[first_name]', 'label' => lang('Auth.first_name'), 'colClass' => ['col-4'], 'value' => $value]); ?>
                <?php $value = old('user[last_name]', $user->last_name ?? ''); ?>
                <?= formFloatingInput(['name' => 'user[last_name]',  'label' => lang('Auth.last_name'), 'colClass' => ['col-4'], 'value' => $value]); ?>
                <?php $value = old('user[date_of_birth]', $user->date_of_birth ?? '') ?>
                <?= formFloatingInput(['name' => 'user[date_of_birth]', 'label' => lang('Auth.dob'), 'colClass' => ['col-4'], 'type' => 'date', 'value'=> $value]); ?>
            </div>
            <div class="row mb-2">
                <?php $value = old('user[street]', $user->street ?? '' );  ?>
                <?= formFloatingInput(['name' => 'user[street]', 'label' => lang('Auth.street'), 'colClass' => 'col-4','value' => $value ]); ?>
                <?php $value = old('user[city]', $user->city ?? ''); ?>
                <?= formFloatingInput(['name' => 'user[city]', 'label' => lang('Auth.city'), 'colClass' => 'col-4', 'value' => $value]); ?>
                <?php $value = old('user[state]', $user->state ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[state]', 'label' => lang('Auth.state'), 'colClass' => 'col-2', 'value' => $value]); ?>
                <?php $value = old('user[zip]', $user->zip ?? ''); ?>
                <?= formFloatingInput(['name' => 'user[zip]', 'label' => lang('Auth.zip'), 'colClass' => 'col-2', 'value' => $value]); ?>
            </div>
            <div class="row mb-2">
                <?php $value = old('user[primary_number]', $user->primary_number ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[primary_number]', 'label' => lang('Auth.primary_phone'), 'colClass' => 'col-6', 'value' => $value, 'extra' => ['class' => 'form-control phone']]); ?> 
                <?php $value = old('user[secondary_number]', $user->secondary_number ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[secondary_number]', 'label' => lang('Auth.secondary_phone'), 'colClass' => 'col-6', 'value' => $value ]); ?> 
            </div>
            <div class="row mb-2">
                <?php $value = old('user[personal_email]', $user->personal_email ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[personal_email]', 'colClass' => 'col-6', 'label' => lang('Auth.personal_email'), 'value' => $value ]); ?>
                <?php $value = old('user[email]', $user->email ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[email]', 'colClass' => 'col-6', 'label' => lang('Auth.email'), 'value' => $value ]); ?>
            </div>
            <div class="row mb-2">
                <?php $value = old('user[username]', $user->username ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[username]', 'colClass' => 'col-3', 'label' => lang('Auth.username'), 'value' => $value ]); ?>
                <?php $value = old('user[password]',  '' ); ?>
                <?= formFloatingInput(['name' => 'user[password]', 'colClass' => 'col-2', 'label' => lang('Auth.pwd'), 'value' => $value, 'extra' => ['id' => 'password'] ]); ?>
                <div class="col-2 d-grid">
                    <button class="btn btn-primary gen-pw" type="button">
                        Generate PW
                    </button>
                </div>
                <?= formFloatingInput(['name' => 'user[dept_id]', 'selected' => $user->dept_id, 'label' => lang('Auth.dept'), 'value' => $value, 'colClass' => 'col-2', 'type' => 'select', 'select_options' => $depts ]); ?> 
                <?= formFloatingInput(['name' => 'user[bldg_id]', 'selected' => $user->bldg_id, 'label' => lang('Auth.bldg'), 'value' => $value, 'colClass' => 'col', 'type' => 'select', 'select_options' => $building ]); ?> 
            </div>
            <div class="row mb-2">
                <?php $value = old('user[emergency_contact]', $user->emergency_contact ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[emergency_contact]', 'label' => lang('Auth.emg_contact'), 'colClass'=> 'col-6', 'value' => $value ]); ?> 
                <?php $value = old('user[emergency_contact]', $user->emergency_contact_relationship ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[emergency_contact_relationship]', 'label' => lang('Auth.emg_contact'), 'colClass'=> 'col-6', 'value' => $value ]); ?> 
            </div>
            <div class="row mb-2">
                <?php $value = old('user[emergency_contact_cell]', $user->emergency_contact_cell ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[emergency_contact_cell]', 'label' => lang('Auth.emg_con_cell'), 'colClass'=> 'col-4', 'value' => $value ]); ?> 
                <?php $value = old('user[emergency_contact_work]', $user->emergency_contact_work ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[emergency_contact_work]', 'label' => lang('Auth.emg_con_work'), 'colClass'=> 'col-4', 'value' => $value ]); ?> 
                <?php $value = old('user[emergency_contact_home]', $user->emergency_contact_home ?? '' ); ?>
                <?= formFloatingInput(['name' => 'user[emergency_contact_home]', 'label' => lang('Auth.emg_con_home'), 'colClass'=> 'col-4', 'value' => $value]); ?>            
            </div>
            <h5 class="h5 border-2 border-bottom border-gray-200  p-2">Page Access</h5>
            <div class="row mb-3 p-2 row-gap-2">
                <?php foreach($groups as $group) : ?>
                    <div class="col-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="user[groups][]" data-toggle="toggle" data-size="small" value="<?= strtolower( $group->name ) ?>" id="groups-<?= $group->id ?>" <?= (in_array(strtolower($group->name),$user->getGroups())) ? 'checked' : '' ?> >
                            <label class="form-check-label" for="groups-<?= $group->id ?>"><?= strtoupper($group->name) ?></label>
                        </div>                
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col  border-bottom border-warning border-2 p-3 mb-2">
            <h5 class="h5 border-2 border-bottom border-gray-200  p-2">Additional Logins</h5>     
                <div class="row mb-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name / Login</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        
                        
                        <tbody>
                            <?php if( $user->logins ?? false ) :?>
                                <?php foreach($user->logins as $login) : ?>
                                    <tr>
                                        <td><?= $login->login ?></td>
                                        <td><?= $login->type ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>  
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-infos">
                                            <?= lang('Auth.no_logins_found') ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4"></div>
                                        <div class="col-4 d-grid">
                                            <a href="<?= base_url('sadmin/login-manager/'.$user->id) ?>" class="btn btn-primary"> Add / Edit Logins </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </div>  
        <div class="col  border-bottom border-warning border-2 p-3 mb-2">
        <h5 class="h5 border-2 border-bottom border-gray-200  p-2">User Workstation</h5>
            <?php if( $user->host->id ?? false ) : ?>
                <input type="hidden" name="host[id]" value="<?= $user->host->id ?>">
                <div class="row mb-2">                    
                    <div class="col-3 d-grid mt-2"><a href="<?= base_url('sadmin/asset/edit/'.$user->host->id) ?>" class="btn btn-primary">Open <?= $user->host->ip_address ?></a></div>
                    <div class="col-3 d-grid mt-2"><a class="btn btn-danger" type="button" id="rm-workstation" href="<?= base_url('sadmin/asset/remove-user/').$user->id ?>" >Remove Workstation</a></div>
                    <div class="col-3"></div>
                    <div class="col-3"></div>
                </div>
           
            <?php else: ?>
                <div class="row">
                    <div class="col">
                        <div class="alert alert-info">
                            <?= lang('Auth.no_workstation_found') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3 d-grid">
        <button class="btn btn-success form-btn" disabled>Save Updates</button>
    </div>
    <div class="col-3 d-grid">
        <button class="btn btn-warning" id="form-btn" >Disable User</button>
    </div>
    <div class="col-3">

    </div>
    <div class="col-3">
        
    </div>
</div>

<?= form_close(); ?>

<div class="modal modal-lg" id="wsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('sadmin/asset/add-user/'.$user->id); ?>
                <div class="row mb-2">
                    <?= formFloatingInput(['name' => 'host[host_id]', 'label' => lang('Auth.workstation'),  'colClass' => 'col-4', 'type' => 'select', 'select_options' => $workstations ]); ?> 
                    <div class="col"><p class="p-3">- Or Enter Workstation Details Below. </p></div>
                </div>

                <div class="row mb-2">
                    <div class="col d-grid">
                        <button class="btn btn-success">Save Workstation</button>
                    </div>
                 </div>
                <?= form_close();?>
           </div>
        </div>
    </div>
</div>

<div class="modal modal-lg" id="pwdModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('logins/add/'.$user->id); ?>
                <div class="" id="passwordCollapse">
                    <div class="row duplicate mb-2">
                        <?= formFloatingInput(['name' => 'passwords[0][type_id]', 'label' => lang('Auth.pwd_type'),  'colClass' => 'col-3', 'type' => 'select', 'select_options' => $pwd_types, 'extra' => ['data-prefix' => 'passwords', 'data-name' => "type_id"] ]); ?> 
                        
                        <?= formFloatingInput(['name' => 'passwords[0][username]', 'label' => lang('Auth.username'), 'colClass'=> 'col-3','extra' => ['data-prefix' => 'passwords', 'data-name' => "username"]  ]); ?>  

                        <?= formFloatingInput(['name' => 'passwords[0][password]', 'label' => lang('Auth.password'), 'colClass'=> 'col-5', 'extra' => ['data-prefix' => 'passwords', 'data-name' => "password"]  ]); ?>   
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-add mt-3"><i class="fa fa-plus"></i></button>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col d-grid">
                        <button class="btn btn-success">Save Login</button>
                    </div>
                 </div>
                <?= form_close();?>
           </div>
        </div>
    </div>
</div>