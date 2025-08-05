<div class="row mb-2">
        <div class="col-4">
            <input type="hidden" name="id" value="<?= ($pwd->id) ?? '' ?>">
            <div class="form-floating">
                <input type="text" name="login" id="" value="<?= ($pwd->login) ?? '' ?>" class="form-control" placeholder="">
                <label for="login">Login</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <select name="user_id" id="" class="form-select" placeholder="">
                    <option value="">Select User</option>
                    <?php foreach($users as $user) : ?>
                    <option value="<?= $user->id ?>" <?= ($pwd->user_id == $user->id ) ? 'selected' : '' ?>><?= $user->first_name .' '. $user->last_name ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="user_id">User</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <div class="form-floating">
                    <select name="type_id" id="" class="form-select" placeholder="">
                        <option value="">Select Type</option>
                        <?php foreach($pwd_types as $pwd_type) : ?>
                        <option value="<?= $pwd_type->id ?>" <?= ($pwd->type_id == $pwd_type->id ) ? 'selected' : '' ?>><?= $pwd_type->name ?></option>
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