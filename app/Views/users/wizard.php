<form action="<?= site_url('user/add/new') ?>" method="post">
<div class="row">
    <div class="col-12 mx-auto">
        <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item fs-5" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Personal Information</button>
        </li>

        <li class="nav-item fs-5" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">ATAP Related</button>
        </li>
        <li class="nav-item fs-5" role="presentation">
            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#workstation-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Work Station</button>
        </li>
        <li class="nav-item fs-5" role="presentation">
            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Passwords</button>
        </li>
        </ul>
        <div class="tab-content shadow mb-4 p-4" id="myTabContent" style="border-color: var(--bs-orange) !important; " >
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div class="row p-2 mt-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="First Name" name="user[fname]">
                        <label for="floatingInput">First Name</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Last Name" name="user[lname]">
                        <label for="floatingInput">Last Name</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control date-picker" id="floatingInput" placeholder="Date of Birth" name="user[dob]">
                        <label for="floatingInput">Date of Birth</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                 <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Street Address" name="user[street]">
                        <label for="floatingInput">Street</label>
                    </div>
                </div>
                 <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="City" name="user[city]">
                        <label for="floatingInput">City</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <select name="user[state]" id="select_user_state" class="form-select">
                            <option value="0">Select One</option>
                            <?= view('states') ?>
                        </select>
                        <label for="select_user_state" class="">State</label>
                    </div>
                </div>
                 <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Street Address" name="user[zip]">
                        <label for="floatingInput">Zip Code</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control phone" id="text_user_phone" placeholder="Primary #" name="user[primary_phone]" required>
                        <label for="text_user_phone" class="">Primary #</label>
                    </div>
                </div>
                <div class="col-3">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control phone" name="user[secondary_phone]"  placeholder="Secondary #">
                        <label for="text_user_phone" class="">Secondary #</label>
                    </div>
                </div>
                <div class="col">
                     <div class="form-floating mb-3">
                        <input type="text" id="text_user_email" class="form-control " name="user[personal_email]" placeholder="Home Email">
                        <label for="text_user_email" >Home Email</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Emergency Contact" name="user[emergency_contact]">
                        <label for="text_emergency_contact">Emergency Contact</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Emergency Contact Relationship"  name="user[emergency_contact_relationship]">
                        <label for="text_emergency_contact">Emergency Contact Relationship</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control phone" placeholder="Mobile Number" name="user[emergency_contact_mobile]">
                        <label for="">Mobile Number</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control phone" placeholder="Work Number" name="user[emergency_contact_work]">
                        <label for="">Work Number</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control phone" placeholder="Home Number" name="user[emergency_contact_home]">
                        <label for="">Home Number</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <div class="row mt-3">
                <div class="col-5">
                     <div class="form-floating mb-3">
                        <input type="text" id="text_user_email phone" class="form-control" name="user[work_email]" placeholder="Work Email">
                        <label for="text_user_email" >Work Email</label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="user[extension]" placeholder="Phone Extension">
                        <label for="">Phone Extension</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Phone IP Address" name="user[extension_ip_address]">
                        <label for="">Phone IP Address</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
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
                <div class="col-3">
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
                <div class="col-3">
                    <div class="form-floating mb-3">
                        <select name="user[bldg_id]" id="select_user_building_id" class="form-select">
                            <option value="0">Select One</option>
                            <?php foreach($access_levels as $item): ?>
                            <option value="<?= $item->id ?>"><?= $item->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="select_user_building_id">Access Level</label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-5">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Connect Portal Username" name="user[connect_username]" >
                        <label for="">Connect Portal Username</label>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="Connect Portal Username" name="user[connect_pwd]" >
                        <label for="">Connect Portal Password</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="workstation-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
            <div class="row mt-3">
                <div class="col-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Display Name" name="host[display_name]"> 
                        <label for="display_name">Display Name</label>     
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Display Name" name="host[network_name]"> 
                        <label for="network_name">Network Name</label>     
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="host[ip_address]" value="192.168.1.1" class="form-control" placeholder="IP Address">            
                        <label for="ip_address">IP Address</label>     
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <div class="form-floating mb-3">
                        <select class="form-control" name="host[type_id]" id="">
                            <option value="0">Select</option>
                            <?php foreach($host_types as $item) : ?>
                            <option value="<?= $item->id ?>"  <?= ($item->id == 2) ? 'selected' : '' ?> ><?= $item->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="host_type">Host Type</label>     
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="host[physical_location]" value="" class="form-control" placeholder="Host Physical Location">            
                        <label for="physical_location">Physical Location</label>     
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating mb-3">
                        <select class="form-control" name="host[dept_id]" id="">
                            <option value="0">Select</option>
                            <?php foreach($depts as $item) : ?>
                            <option value="<?= $item->id ?>"  ><?= $item->name ?></option>
                            <?php endforeach; ?>
                        </select>         
                        <label for="department">Department</label>     
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <select type="text" name="host[switch_id]" class="form-control">
                            <option value="0">Select</option>
                            <?php foreach($switches as $item) : ?>
                            <option value="<?= $item->id ?>" ><?= $item->friendly_name ?></option>
                            <?php endforeach; ?>           
                        </select>
                        <label for="switch_id">Switch</label>                     
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="host[switch_port_no]" value="" class="form-control" placeholder="Switch Port">            
                        <label for="switch_port_no">Switch Port</label>     
                    </div>                    
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="host[make]" value="" class="form-control" placeholder="Manufacturer">            
                        <label for="host_make" >Manufacturer</label>                     
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="host[make]" value="" class="form-control" placeholder="Model">            
                        <label for="host_model" >Model</label>                     
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-floating">
                        <input type="text" name="host[operating_system]" placeholder="Operating System" class="form-control">
                        <label for="host_os">Operating System</label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating">
                        <input type="text" name="host[version]" placeholder="OS Version" class="form-control">
                        <label for="host_os">OS Version</label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating">
                        <input type="text" name="host[serial_no]" placeholder="Serial No." class="form-control">
                        <label for="host_os">Serial No. </label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating">
                        <input type="text" name="host[contract_no]" placeholder="Contract No." class="form-control">
                        <label for="host_os">Contract No </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
            <div class="row duplicate mt-2">
                <div class="col-3">
                    <div class="form-floating">
                        <select id="select_pwd_type" class="form-select" name="passwords[0][type_id]" data-prefix="passwords" data-name="type_id">
                            <option value="0">Select Type</option>
                            <?php foreach($pwd_types as $item): ?>
                            <option value="<?= $item->id ?>"><?= $item->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="">Password Type</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="text" placeholder="User Name / Login " class="form-control" name="passwords[0][username]" data-prefix="passwords" data-name="username" placeholder="Username" >
                        <label for="">Username</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="password" placeholder="Password" data-type="password" class="form-control" name="passwords[0][password]" data-prefix="passwords" data-name="password" placeholder="Password">
                        <label for="">Password</label>            
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-success btn-add mt-3"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row mt-1">
    <div class="col d-grid"><button class="btn btn-primary">Add User</button></div>
</div>
</form>
