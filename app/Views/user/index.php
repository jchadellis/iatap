
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
        <h6 class="h6 border-bottom border-primary p-2">Profile Information</h6>
        <div class="row mt-3">
            <div class="col-6">
                <span class="text-accent2">First Name: </span> <?= $user->first_name ?>
                <span class="text-accent2">Last Name: </span> <?= $user->last_name ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <span class="text-accent2">Email: </span> <?= $user->email ?>
            </div>
        </div>
        <div class="row mt-3">
            <h6 class="h6 border-bottom border-primary p-2">Contact Information</h6>
            <div class="col-6"><span class="text-accent2">Primary Number: </span><?= $user->primary_number ?></div>
            <div class="col"><span class="text-accent2">Secondary Number: </span> <?= $user->secondary_number ?></div> 
        </div>
        <div class="row mt-3">
            <span class="text-accent2">Address: </span>
            <div class="col"><?= $user->street ?></div>
        </div>
        <div class="row">
            <div class="col"><?= $user->city ?> <?= $user->state ?> <?= $user->zip ?></div>
        </div>
        <div class="row mt-3">
            <h6 class="h6 border-bottom border-primary p-2">Emergency Contact Information</h6>
            <div class="col-6"><span class="text-accent2">Contact: </span><?= $user->emergency_contact ?></div>
            <div class="col"><span class="text-accent2">Relationship: </span><?= $user->emergency_contact_relationship ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-4"><span class="text-accent2">Moblie Number: </span><?= $user->emergency_contact_cell ?></div>
            <div class="col"><span class="text-accent2">Work Number: </span><?= $user->emergency_contact_work ?></div>
            <div class="col"><span class="text-accent2">Home Number:  </span><?= $user->emergency_contact_home ?></div>
        </div>
        <div class="row mt-3">
            <h6 class="h6 border-bottom border-primary p-2">PTO Available</h6>
            <div class="col-6"><span class="text-accent2">Free Days Left: </span> 0 </div>
            <div class="col"><span class="text-accent2">Vacation Days Left: </span> 0 </div>
        </div>

    </div>
</div>