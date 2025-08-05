<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Login name</th>
            <th class="text-center">Type</th>
            <th class="text-center">Password</th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row ) : ?>
        <tr class="align-middle  text-center" data-id="<?= $row->id ?>">
            <td><?= $row->login ?? '' ?></td>
            <td><?= $row->type ?></td>
            <td class="pwd-field" sytle="font-family: monospace; letter-spacing:2px">*********</td>
            <td><div class="d-grid"><button type="button" class="btn btn-warning show-pwd"><i class="bi bi-eye"></i> Show</button></div></td>
            <td><div class="d-grid"><button type="button" class="btn btn-secondary copy-pwd" disabled><i class="bi bi-copy"></i> Copy</button></div></td>
            <td><div class="d-grid"><button type="button" class="btn btn-primary edit-pwd" data-id="<?= $row->id ?>" data-bs-target="#edit_modal" data-bs-toggle="modal"><i class="bi bi-pencil-fill"></i> Edit</button></div></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal" tabindex="-1" id="form_modal">
   <form action="<?= base_url('sadmin/login-manager/save') ?>" method="post" >
    <div class="modal-dialog modal-lg">
        <input type="hidden" name="type" value="">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">New Login / Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
                    <div class="col-4">
                        <div class="form-floating">
                            <input type="text" name="login" id="" class="form-control" placeholder="">
                            <label for="login">Login</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <select name="user_id" id="" class="form-select" placeholder="">
                                <option value="">Select User</option>
                                <?php foreach($users as $user) : ?>
                                <option value="<?= $user->id ?>" ><?= $user->first_name .' '. $user->last_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="user_id">User</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <div class="form-floating">
                                <select name="type_id" id="" class="form-select" placeholder="">
                                    <option value="null">Select Type</option>
                                    <?php foreach($pwd_types as $pwd_type) : ?>
                                    <option value="<?= $pwd_type->id ?>" ><?= $pwd_type->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="user_id">Login Type</label>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-floating">
                        <input type="text" name="password" id="" class="form-control" placeholder="">
                        <label for="password">Password</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success save_btn" ><i class="bi bi-plus-square"></i>&nbsp;Save</button>
        </div>
        </div>
    </div>
  </form>
</div>

<div class="modal" tabindex="-1" id="edit_modal">
   <form action="<?= base_url('sadmin/login-manager/save') ?>" method="post" id="edit_form" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">New Login / Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success form-submit-btn" ><i class="bi bi-plus-square"></i>&nbsp;Update</button>
        </div>
        </div>
    </div>
  </form>
</div>