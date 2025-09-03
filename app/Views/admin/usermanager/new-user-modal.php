<form action="">
<div class="modal-header">
    <h5 class="modal-title">User Edit Form</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row mb-2">
        <div class="col-4">
            <div class="form-floating">
                <?php $value = $data->first_name ?? '' ?>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="" value="<?= $value ?>">
                <label for="">First Name</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <?php $value = $data->last_name ?? '' ?>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="" value="<?= $value ?>">
                <label for="">Last Name</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <?php $value = $data->employee_id ?? '' ?>
                <select name="employee_id" id="" class="form-select">
                    <option value="0">Select</option>
                    <?php if(isset($employees)) : ?>
                    <?php foreach($employees as $item) : ?>
                    <option value="<?= $item->employee_id ?>"><?= $item->first_name ?> <?= $item->last_name ?></option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <!-- <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="" value="<?= $value ?>"> -->
                <label for="">Empl. ID</label>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-6">
            <div class="form-floating">
                <?php $value = $data->username ?? '' ?>
                <input type="text" class="form-control" name="username" id="first_name" placeholder="" value="<?= $value ?>">
                <label for="">Username</label>
            </div>
        </div>
        <div class="col-6">
            <div class="form-floating">
                <?php $value = $data->email ?? '' ?>
                <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?= $value ?>">
                <label for="">Email Address</label>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4">
            <div class="form-floating">
                <?php $value = $data->dept_id ?? '' ?>
                <select name="dept_id" class="form-select" id="">
                    <option value="0">Select Dept</option>
                    <?php if(isset($depts)) : ?>
                    <?php foreach($depts as $item) : ?>
                    <option value="<?= $item->id ?>" <?= $value == $item->id ? 'selected' : '' ?>><?= $item->name ?></option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="">Department</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <?php $value = $data->bldg_id ?? '' ?>
                <select name="bldg_id" class="form-select" id="">
                    <option value="0">Select Building</option>
                    <?php if(isset($buildings)) : ?>
                    <?php foreach($buildings as $item) : ?>
                    <option value="<?= $item->id ?>" <?= $value == $item->id ? 'selected' : '' ?>><?= $item->name ?></option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="">Building</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <?php $value = $data->host_id ?? '' ?>
                <select name="host_id" class="form-select" id="">
                    <option value="0">Select Workstation</option>
                    <?php if(isset($workstations)) : ?>
                    <?php foreach($workstations as $item) : ?>
                    <option value="<?= $item->id ?>" <?= $value == $item->id ? 'selected' : '' ?>><?= $item->display_name ?></option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="">User Workstation</label>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-6">
            <div class="form-floating">
                <input class="form-control" type="text" name="password" id="password" placeholder="">
                <label for="password">Password</label>
            </div>
        </div>
        <div class="col-5">
            <div class="d-flex align-items-center h-100">
                <button type="button" class="btn btn-success gen-pw">
                    <i class="bi bi-arrow-clockwise"></i>&nbsp;Generate Password
                </button>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <hr>
            <h6 class="h6">Group Permissions</h6>
        </div>
    </div>
    <div class="row mb-2">
        <?php foreach($groups as $group) : ?>
            <?php if($group->name != 'guest') : ?>
            <div class="col-4">
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" name="groups[]" 
                        data-toggle="toggle" data-size="small" 
                        value="<?= strtolower( $group->name ) ?>" 
                        id="groups-<?= $group->id ?>"
                        <?= strtolower( $group->name )  === 'user' ? 'checked' : '' ?>
                    >
                    <label class="form-check-label" for="groups-<?= $group->id ?>"><?= strtoupper($group->name) ?></label>
                </div>      
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <hr>
            <h6 class="h6">User Permissions</h6>
        </div>
    </div>
    <div class="row mb-2">
        <?php if(isset($permissions)) : ?>     
        <?php foreach($permissions as $permission) : ?>
        <div class="col-4">
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="permissions[]" 
                    data-toggle="toggle" 
                    data-size="small" 
                    value="<?= $permission->group.'.'.$permission->function ?>" 
                    id="groups-<?= $permission->id ?>" 
                >
                <label class="form-check-label" for="groups-<?= $permission->id ?>"><?= strtoupper($permission->group).'.'.strtoupper($permission->function) ?></label>
            </div>         
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-square"></i>&nbsp;Close</button>
    <button type="button" class="btn btn-warning save-btn" disabled><i class="bi bi-floppy"></i>&nbsp;Save</button>
</div>
</form>
