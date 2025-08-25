<form action="" id="modal-form" >
    <input type="hidden" name="id" value="<?= $employee->id ?>">
    <div class="modal-header">
        <h5 class="h5">Employee Update Emergency Contacts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row mb-2">
            <div class="col-4">
            <strong>First Name:</strong> <?= $employee->first_name ?>
            </div>
            <div class="col-4">
            <strong>Middle:</strong> <?= $employee->middle_initial ?>
            </div>
            <div class="col-4">
            <strong>Last Name:</strong> <?= $employee->last_name ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <strong>Employee ID:</strong> <?= $employee->employee_id ?>
            </div>
            <div class="col-4">
                <strong>Hire Date:</strong> <?= (new \DateTime($employee->hire_date))->format('D, M Y') ?>
            </div>
            <div class="col-4">
                <strong>Birth Date:</strong> <?= (new \DateTime($employee->birth_date))->format('D, M Y') ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <hr class="border-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <strong>Street:</strong> <?= $employee->addr_1 ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <strong>City:</strong> <?= $employee->city ?>   
            </div>
            <div class="col-4">
                <strong>State:</strong> <?= $employee->state ?>
            </div>
            <div class="col-4">
                <strong>Zip:</strong> <?= $employee->zipcode ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <hr class="border-primary">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <h6 class="h6">Emergency Contacts</h6>    
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <div class="form-floating">
                    <?php $value = ($employee->contact_2) ?? '' ?>
                    <input type="text" name="contact_2" id="contact_2" class="form-control" value="<?= $value ?>"  placeholder="">
                    <label for="contact_2">Primary Contact</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <?php $value = ($employee->contact_2_relationship ) ?? '' ?>
                    <select name="contact_2_relationship" id="" class="form-select">
                        <option value="">Select</option>
                        <?php foreach($relationships as $key => $name ) : ?>    
                        <option value="<?= $key ?>" <?= ($key == $value) ? 'selected' : '' ?> ><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="contact_2">Relationship</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = ($employee->contact_2_primary) ?? '' ?>
                    <input type="text" name="contact_2_primary" id="contact_2_primary" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="contact_2">Primary</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = ($employee->contact_2_secondary) ?? '' ?>
                    <input type="text" name="contact_2_secondary" id="contact_2_secondary" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="contact_2">Secondary</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = ($employee->contact_2_alternate) ?? '' ?>
                    <input type="text" name="contact_2_alternate" id="contact_2_alternate" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="contact_2">Alternate</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <hr class="border-primary">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <div class="form-floating">
                    <?php $value = ($employee->contact_3) ?? '' ?>
                    <input type="text" name="contact_3" id="contact_3" class="form-control" value="<?= $value ?>"  placeholder="">
                    <label for="contact_3">Secondary Contact</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <?php $value = ($employee->contact_3_relationship ) ?? '' ?>
                    <select name="contact_3_relationship" id="" class="form-select">
                        <option value="">Select</option>
                        <?php foreach($relationships as $key => $name ) : ?>    
                        <option value="<?= $key ?>" <?= ($key == $value) ? 'selected' : '' ?> ><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="contact_3">Relationship</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = ($employee->contact_3_primary) ?? '' ?>
                    <input type="text" name="contact_3_primary" id="contact_3_primary" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="contact_3">Primary</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = ($employee->contact_3_secondary) ?? '' ?>
                    <input type="text" name="contact_3_secondary" id="contact_3_secondary" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="contact_3">Secondary</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = ($employee->contact_3_alternate) ?? '' ?>
                    <input type="text" name="contact_3_alternate" id="contact_3_alternate" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="contact_2">Alternate</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="modal-save-btn">Save</button>
    </div>
</form>