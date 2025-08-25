<div class="row gx-3">
    <div class="col-3 p-3">
        
        <img src="https://placehold.co/250x250" alt="">
        <h6 class="h6 mt-3 border-bottom border-primary p-2">Password Management</h6>
        <div class="col form-floating mt-2">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Old Password" disabled>
            <label for="floatingPassword">Old Password</label>
        </div>
        <div class="col form-floating mt-2">
            <input type="password" class="form-control" id="floatingPassword" placeholder="New Password" disabled>
            <label for="floatingPassword">New Password</label>
        </div>
        <div class="col d-grid mt-2"><button class="btn btn-primary" disabled>Change</button></div>
    </div>
    <div class="col p-3 ms-3">
        <h6 class="h6 border-bottom border-primary p-2">Profile Information <span class="float-end">Employee ID: <?= $details->employee_id ?></span></h6>
        <div class="row mt-3">
            <div class="col-6">
                <span class="text-accent2">First Name: </span> <?= $user->first_name ?>
                <span class="text-accent2">Last Name: </span> <?= $user->last_name ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <span class="text-accent2">Work Email: </span> <?= $details->work_email ?>
            </div>
            <div class="col-6">
                <span class="text-accent2">Work Email: </span> <?= $details->personal_email ?>
            </div>
        </div>
        <div class="row mt-3">
            <h6 class="h6 border-bottom border-primary p-2">Contact Information</h6>
            <div class="col-6"><span class="text-accent2">Primary Number: </span><?= $details->phone ?></div>
            <div class="col"><span class="text-accent2">Secondary Number: </span> <?= $details->phone_2 ?></div> 
        </div>
        <div class="row mt-3">
            <span class="text-accent2">Address: </span>
            <div class="col"><?= $details->addr_1 ?></div>
        </div>
        <div class="row">
            <div class="col"><?= $details->city ?> <?= $details->state ?> <?= $details->zipcode ?></div>
        </div>
        <div class="row mt-3">
            <h6 class="h6 border-bottom border-primary p-2">Emergency Contact Information - Primary <span class="float-end"><button class="btn btn-primary">Update</button></span></h6>
            <div class="col-6"><span class="text-accent2">Contact: </span><?= $details->contact_2 ?></div>
            <div class="col"><span class="text-accent2">Relationship: </span><?= $details->contact_2_relationship ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-4"><span class="text-accent2">Moblie Number: </span><?= $details->contact_2_primary ?></div>
            <div class="col"><span class="text-accent2">Work Number: </span><?= $details->contact_2_secondary?></div>
            <div class="col"><span class="text-accent2">Home Number:  </span><?= $details->contact_2_alternate ?></div>
        </div>
        <div class="row mt-3">
            <h6 class="h6 border-bottom border-primary p-2">Emergency Contact Information - Secondary</h6>
            <div class="col-6"><span class="text-accent2">Contact: </span><?= $details->contact_3 ?></div>
            <div class="col"><span class="text-accent2">Relationship: </span><?= $details->contact_3_relationship ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-4"><span class="text-accent2">Moblie Number: </span><?= $details->contact_3_primary ?></div>
            <div class="col"><span class="text-accent2">Work Number: </span><?= $details->contact_3_secondary?></div>
            <div class="col"><span class="text-accent2">Home Number:  </span><?= $details->contact_3_alternate ?></div>
        </div>
        <div class="row mt-3">
            <h6 class="h6 border-bottom border-primary p-2">PTO Available <span class="float-end"><button class="btn btn-primary">Show</button></span></h6>
            <div class="col-6"><span class="text-accent2">Free Days Left: </span> <?= $details->free_days ?> </div>
            <div class="col"><span class="text-accent2">Vacation Days Left: </span> <?= $details->vac_days ?> </div>
        </div>

    </div>
</div>