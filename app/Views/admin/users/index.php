<?php helper('form'); ?>
<div class="row">
    <div class="col-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add New User</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user ) : ?>
                <tr>
                    <td><?= $user->first_name ?></td>
                    <td><?= $user->last_name ?></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->email ?></td>
                    <td class="d-grid" ><a href="<?= base_url('sadmin/user/edit/'.$user->id) ?>" class="btn btn-secondary text-white" >Edit</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= lang('Auth.newUser') ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col" id="alert-container">

                </div>
            </div>
            <form  method="post" id="userForm">
                 <div class="row">
                    <div class="col-5">
                        <h6 class="h6 mb-3">Employee Information</h6>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="First Name" name="user[first_name]">
                                    <label for="floatingInput">First Name</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Last Name" name="user[last_name]">
                                    <label for="floatingInput">Last Name</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control date-picker" id="floatingInput" placeholder="Date of Birth" name="user[date_of_birth]">
                                    <label for="floatingInput">Date of Birth</label>
                                </div>
                            </div>
                        </div>                   
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingStreetInput" name="user[street]" placeholder="<?= lang('Auth.street') ?>">
                                    <label for="floatingStreetnput"><?= lang('Auth.street') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingStateInput" name="user[city]" placeholder="<?= lang('Auth.city') ?>">
                                    <label for="floatingCityInput"><?= lang('Auth.city') ?></label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingStateInput" name="user[state]" placeholder="<?= lang('Auth.state') ?>" value="<?= (old('state') == '') ? 'AL' : old('state') ?>" >
                                    <label for="floatingStateInput"><?= lang('Auth.state') ?></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="floatingStateInput" name="user[zip]" placeholder="<?= lang('Auth.zip') ?>">
                                    <label for="floatingZipInput"><?= lang('Auth.zip') ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <!-- Primary Phone -->
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control phone" id="floatingPhone1Input" name="user[primary_number]" inputmode="tel" placeholder="<?= lang('Auth.phone1') ?>">
                                    <label for="floatingPhone1Input"><?= lang('Auth.primary_phone') ?></label>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Primary Phone -->
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control phone" id="floatingPhone2Input" name="user[secondary_number]" inputmode="tel" placeholder="<?= lang('Auth.phone2') ?>">
                                    <label for="floatingPhone2Input"><?= lang('Auth.secondary_phone') ?></label>
                                </div>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="form-floating mb-2">
                            <input type="email" class="form-control" id="floatingEmailInput" name="user[personal_email]" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>">
                            <label for="floatingEmailInput"><?= lang('Auth.personal_email') ?></label>
                        </div>
                        <!-- Email -->
                        <div class="form-floating mb-2">
                            <input type="email" class="form-control" id="floatingEmailInput" name="user[email]" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>">
                            <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                        </div>
                        <!-- Username -->
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="floatingUsernameInput" name="user[username]" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>">
                            <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" id="floatingPasswordInput" name="user[password]" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>">
                            <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                        </div>

                        <!-- Password (Again) -->
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="user[password_confirm]" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>">
                            <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select name="user[dept_id]" id="select_user_dept_id" class="form-select">
                                        <option value="0">Select One</option>
                                        <?php foreach($depts as $item): ?>
                                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="select_user_building_id">Department</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select name="user[bldg_id]" id="select_user_building_id" class="form-select">
                                        <option value="0">Select One</option>
                                        <?php foreach($building as $item): ?>
                                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="select_user_building_id">Building</label>
                                </div>
                            </div>
                        </div>
       
                    </div>
                    <div class="col">
                        <div class="row mb-2">
                            <h6 class="h6 mb-3">Emergency Contact Numbers</h6>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" placeholder="Emergency Contact" name="user[emergency_contact]" >
                                    <label for="text_emergency_contact">Emergency Contact</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" placeholder="Emergency Contact Relationship"  name="user[emergency_contact_relationship]">
                                    <label for="text_emergency_contact">Emergency Contact Relationship</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control phone" placeholder="Mobile Number" name="user[emergency_contact_cell]">
                                    <label for="">Mobile Number</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control phone" placeholder="Work Number" name="user[emergency_contact_work]">
                                    <label for="">Work Number</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control phone" placeholder="Home Number" name="user[emergency_contact_home]">
                                    <label for="">Home Number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 row-gap-2">
                            <h6 class="h6 mb-3">User Groups</h6>
                            <?php foreach($groups as $group) : ?>
                                <?php if($group->name != 'guest') : ?>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox" type="checkbox" name="user[groups][]" data-toggle="toggle" data-size="small" value="<?= strtolower( $group->name ) ?>" id="groups-<?= $group->id ?>" <?= ($group->name == 'user') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="groups-<?= $group->id ?>"><?= strtoupper($group->name) ?></label>
                                    </div>                
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="row mb-3">
                            <h6 class="h6 mb-3">Assign User Workstation</h6>
                            <?= formFloatingInput(['name' => 'user[host_id]', 'label' => lang('Auth.workstation'),  'colClass' => 'col-5', 'type' => 'select', 'select_options' => $workstations ]); ?>         
                        </div>
                    </div>
            </div>
      </div>
      <div class="modal-footer">
            <div class="d-grid col-12 col-md-8 mx-auto m-3">
                <button type="submit" class="btn btn-primary btn-block" ><?= lang('Auth.newUser') ?></button>
            </div>  
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">User Added!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="alert alert-success" role="alert">
               User Add Successfully. Would you like to add a Computer to the new User? 
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#hostModal">Yes</button>
      </div>
    </div>
  </div>
</div>

