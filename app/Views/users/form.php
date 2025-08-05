<form class="needs-validation" method="post" action="" id="user_add_form" novalidate>
    <div class="row">
        <div class="col">
            <div class="card shadow border-left-primary">
                <div class="card-header bg-secondary">
                    <button class="btn btn-link text-left text-white text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#user_details_collapse" aria-expanded="false" >
                        <span class="me-2">User / Connect Portal</span>
                        <span class="arrow-icon rotate" >
                            <i class="bi bi-chevron-right" ></i>
                        </span>
                    </button>
                </div>
                <div class="card-body" id="user_details">
                    <div class="collapse show card-collapse" id="user_details_collapse" >
                        <div class="mt-3 bg-light p-4 m-1 border-bottom border-primary border-2 rounded-2 shadow shadow-sm">
                            <h5 class="h5 border-bottom border-bottom border-primary p-2 rounded-2 border-2 bg-custom-1">Personal Infomation </h5>
                            <div class="row p-2 mt-2">
                                <div class="col-lg-2 col-md-12">
                                    <div class="form-group">
                                        <label for="text_user_fname">First Name</label>
                                        <input type="text" class="form-control" id="text_user_fname" name="user[fname]" required>
                                        <div class="invalid-feedback">Enter a First Name</div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <div class="form-group">
                                        <label for="text_user_lname">Last Name</label>
                                        <input type="text" class="form-control" id="text_user_lname" name="user[lname]" required>
                                        <div class="invalid-feedback">Enter a Last Name</div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="datepicker">DOB</label>
                                    <div class="input-group">                                
                                        <input type="date"  class="form-control" name="user[dob]" required>
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        <div class="invalid-feedback">Enter DOB MM/DD/YYYY</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="text_user_street">Street</label>
                                        <input type="text" id="text_user_street" class="form-control" name="user[street]" required>
                                        <div class="invalid-feedback">Enter a Street Address</div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="text_user_city">City</label>
                                        <input type="text" id="text_user_city" class="form-control" name="user[city]">
                                        <div class="invalid-feedback">Enter a City</div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="select_user_state">State</label>
                                        <select name="user[state]" id="select_user_state" class="form-select">
                                            <? ?>
                                        </select>
                                        <div class="invalid-feedback">Select a State</div>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <label for="text_user_zip">Zip</label>
                                        <input type="text" id="text_user_zip" class="form-control" name="user[zip]">
                                        <div class="invalid-feedback">Enter a Zip Code</div>
                                    </div>
                                </div>

                            </div>
                            <div class="row p-2">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="text_user_phone">Primary #</label>
                                        <input type="text" class="form-control phone" name="user[primary_phone]" required>
                                        <div class="invalid-feedback">A Primary Number is Required</div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="text_user_phone">Secondary #</label>
                                        <input type="text" class="form-control phone" name="user[secondary_phone]" >
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="text_user_email">Home Email</label>
                                    <div class="input-group">
                                        <input type="text" id="text_user_email" class="form-control" name="user[personal_email]">
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="text_user_phone">Emergency Contact</label>
                                        <input type="text" class="form-control" name="user[emergency_contact]" required>
                                        <div class="invalid-feedback">Emergency Contact Is Required</div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="user[emergency_contact_relationship]">Relationship</label>
                                        <input type="text" class="form-control" name="user[emergency_contact_relationship]" required >
                                        <div class="invalid-feedback">Enter the Contact's Relationship</div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="text_user_phone">Mobile #</label>
                                        <input type="text" class="form-control phone" name="user[emergency_contact_mobile]" >
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="text_user_phone">Work #</label>
                                        <input type="text" class="form-control phone" name="user[emergency_contact_work]" >
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="text_user_phone">Home #</label>
                                        <input type="text" class="form-control phone" name="user[emergency_contact_home]" >
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <div class="mt-3 bg-light p-4 m-1 border-bottom border-primary border-2 rounded-2 shadow shadow-sm">
                            <h5 class="h5 border-bottom border-bottom border-primary p-2 rounded-2 border-2 mt-2 bg-custom-1">Connect Portal</h5>
                            <div class="row mt-2">
                                <div class="col-lg-3">
                                    <label for="text_user_email">Work Email</label>
                                    <div class="input-group">
                                        <input type="text" id="text_user_email phone" class="form-control" name="user[work_email]">
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <label for="text_user_ext">Extension</label>
                                    <div class="input-group">
                                        <input type="text" id="text_user_ext" class="form-control" name="user[extension]">
                                    </div>
                                </div>     
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="select_user_dept_id">Department</label>
                                        <select name="user[dept_id]" id="select_user_dept_id" class="form-select">
                                            <option value="null">Select One</option>
                                            
                                            <?php foreach($depts as $item) : ?>
                                            <option value="<?=$item->id?>"><?= $item->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="select_user_building_id">Building</label>
                                        <select name="user[bldg_id]" id="select_user_building_id" class="form-select">
                                            <option value="0">Select One</option>
                                            <?php foreach($building as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-3">
                                    <label for="">Access Level</label>

                                    <select name="user[access_level]" id="" class="form-select mt-1">
                                        <option value="0">Select</option>
                                        <?php foreach($access_levels as $item) : ?>
                                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="text_user_username">Connect Portal Username / Password</label>
                                    <div class="input-group mt-1">
                                        <input type="text" class="form-control" placeholder="Username" name="user[connect_username]" id="text_user_username" required>
                                        
                                        <input type="password" class="form-control ml-1" data-type="password" placeholder="Password" name="user[connect_pwd]" id="pwd_user_password" required>

                                        <div class="input-group-text bg-warning show_pwd">
                                            <button class="btn btn-xs" data-target="#pwd_user_password"><i class="fa fa-eye"></i></button>
                                        </div>
                                        <div class="input-group-text bg-secondary show_pwd">
                                            <button class="btn btn-secondary btn-xs text-white pwd-gen" data-inputs='["user[fname]", "user[lname]"]' data-target="#pwd_user_password" id="password_generator" >Generate Password</button>
                                        </div>
                                        
                                    </div>    
                                    <div class="invalid-feedback">Enter a Connect Portal Username and Password</div>                        
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="row border-bottom border-1 p-1">
                                        <label for="">Pages User Can Access</label>
                                    </div>
                                    <div class="row mt-2">
                                        <?php foreach($pages as $item) : ?>
                                        <?php if($item->is_default != 't') : ?>
                                            <div class="col-2">
                                                <input type="checkbox" name="pages[<?= rtrim($item->key, ' ') ?>]" id="<?= $item->id ?>"  class="form-check-input" value="<?= $item->id ?>">
                                                <label for="" class="form-check-label"><?= $item->name ?></label>
                                            </div>
                                        <?php endif;  ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2 shadow border-left-primary">
                <div class="card-header bg-secondary">
                    <button class="btn btn-link text-left text-white text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#machine_details_collapse" aria-expanded="false" >
                        <span class="me-2">Workstation</span>
                        <span class="arrow-icon" >
                            <i class="bi bi-chevron-right" ></i>
                        </span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="collapse card-collapse" id="machine_details_collapse">
                        <div class="mt-3 bg-light p-4 m-1 border-bottom border-primary border-2 rounded-2 shadow shadow-sm">
                            <div class="row m-1">

                                <div class="col-3">
                                    <select name="host[existing_id]" id="workstation_select" class="form-select">
                                        <option value="null">Select Existing Workstation</option>
                                        <?php foreach($workstations as $item): ?>
                                        <option value="<?= $item->id ?>"><?= $item->friendly_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-3" >
                                    <div class="col-12 d-grid">
                                        <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#new_workstation_collapse" aria-expanded="false" >Add New Workstation</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 bg-light p-4 m-1 border-bottom border-primary border-2 collapse rounded-2 shadow shadow-sm" id="new_workstation_collapse">
                            <h5 class="h5 border-bottom border-bottom border-primary p-2 rounded-2 border-2 bg-custom-1">New Workstation</h5>
                           
                                <div class="row">
                                    <div class="col-3">
                                        <label for="friendly_name" class="form-label">Friendly Name</label>
                                        <input type="text" name="host[friendly_name]" value="" class="form-control my-1">
                                    </div>
                                    <div class="col-3">
                                        <label for="newtwork_hostname"  class="form-label">Network Hostname</label>
                                        <input type="text" name="host[network_name]" value="" class="form-control my-1">
                                    </div>
                                    <div class="col-3">
                                        <label for="host['type_id']" class="form-label">Host Type</label>
                                        <select class="form-control" name="host[type_id]" id="">
                                            <option value="0">Select</option>
                                            <?php foreach($host_types as $item) : ?>
                                            <option value="<?= $item->id ?>"  <?= ($item->id == 2) ? 'selected' : '' ?> ><?= $item->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>   
                                    <div class="col-3">
                                        <label for=""  class="form-label">IP Address</label>
                                        <input type="text" name="host[ip_address]" value="192.168.1.1" class="form-control my-1">
                                    </div> 
                                </div>
 
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <label for="host['physical_location']"  class="form-label">Physical Location</label>
                                        <input type="text" name="host[physical_location]" value="User's Desk" class="form-control">
                                    </div> 
                                    <div class="col-3">
                                        <label for="host['dept_id']" class="form-label">Dept.</label>
                                        <select class="form-control" name="host[dept_id]" id="">
                                            <option value="0">Select</option>
                                            <?php foreach($depts as $item) : ?>
                                            <option value="<?= $item->id ?>"  ><?= $item->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label for="host['switch_id']"  class="form-label">Switch</label>
                                        <select type="text" name="host[switch_id]" class="form-control">
                                            <option value="0">Select</option>
                                            <?php foreach($switches as $item) : ?>
                                            <option value="<?= $item->id ?>" ><?= $item->friendly_name ?></option>
                                            <?php endforeach; ?>           
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="host['switch_port_no']"  class="form-label">Port</label>  
                                        <input type="text" name="host[switch_port_no]" value="XX" class="form-control">             
                                    </div>                           
                                </div>
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <label for="host[make]"  class="form-label">Manufacturer</label>  
                                        <input type="text" name="host[make]" value="Dell" class="form-control">                     
                                    </div>
                                    <div class="col-3">
                                        <label for="host[model]"  class="form-label">Model</label>  
                                        <input type="text" name="host[model]" value="N/A" class="form-control">                     
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <label for="host['operating_system']"  class="form-label">Operating System</label>  
                                        <input type="text" name="host[operating_system]" value="Windows 10" class="form-control">                     
                                    </div>
                                    <div class="col">
                                        <label for="host['contract_no']"  class="form-label">OS Version</label>  
                                        <input type="text" name="host[version]" value="N/A" class="form-control">                     
                                    </div>
                                    <div class="col">
                                        <label for="host['contract_no']"  class="form-label">Serial No.</label>  
                                        <input type="text" name="host[serial_no]" value="N/A" class="form-control">                     
                                    </div>
                                    <div class="col">
                                        <label for="host['contract_no']"  class="form-label">Contract Number</label>  
                                        <input type="text" name="host[contract_no]" value="N/A" class="form-control">                     
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="card mt-2 shadow border-left-primary">
                <div class="card-header bg-secondary">
                    <button class="btn btn-link text-left text-white text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#passwords_collapse" aria-expanded="false" >
                        <span class="me-2">Passwords</span>
                        <span class="arrow-icon" >
                            <i class="bi bi-chevron-right" ></i>
                        </span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="collapse card-collapse" id="passwords_collapse">
                        <div class="mt-3 bg-light p-4 m-1 border-bottom border-primary border-2 rounded-2 shadow shadow-sm">
                            <div class="row duplicate mt-2">
                                <div class="col-lg-2">

                                    <select id="select_pwd_type" class="form-select" name="passwords[0][type_id]" data-prefix="passwords" data-name="type_id">
                                        <option value="0">Select Type</option>
                                        <?php foreach($pwd_types as $item): ?>
                                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">

                                    <div class="input-group">
                                        <input type="text" placeholder="User Name / Login " class="form-control" name="passwords[0][username]" data-prefix="passwords" data-name="username">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="password" placeholder="Password" data-type="password" class="form-control" name="passwords[0][password]" data-prefix="passwords" data-name="password">
                                        <div class="input-group-text bg-warning show_pwd">
                                            <button type="button" class="btn btn-xs" data-target=""><i class="fa fa-eye"></i></button>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-1 d-grid">
                                    <button type="button" class="btn btn-success btn-add"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 ">
        <div class="d-grid mx-auto col-6">
            <button class="btn btn-block btn-success" type="submit" id="user_add_form_submit">Save User</button>
        </div>
    </div>
</form>
