<div class="modal" tabindex="-1" id="new-ticket-modal">
  <form action="" id="new-ticket-modal-form">
    <div class="modal-dialog modal-lg">
        <input type="hidden" name="type" value="<?= $type ?>">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?= $title ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php if(true) : ?>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control" type="text" name="user" id="" placeholder="" value="<?= $user ? $user->first_name . ' ' .$user->last_name : '' ?>" >
                        <input type="hidden" name="user_id" value="<?= $user ?  $user->id  : 0 ?>">
                        <label for="requested_by">First & Last Name</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <input type="text" name="need_date" id="" class="form-control date-picker" placeholder="" value="">
                        <label for="need_date">Need Date</label>
                    </div>
                </div>
            </div>
            <!-- 
                Email input and Assign To Select 
                Email defaults to the signed in user. If no user then, the user will need to enter First Last Name
            -->
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control" type="text" name="email" id="" placeholder="" value="<?= $user ? $user->email : '' ?>">
                        <label for="requested_by">Email</label>
                    </div>
                </div>
                <?php if($type === 'engineering' && isset($dept_users) ) : ?>
                    <div class="col-6">
                        <div class="form-floating">    
                            <select name="assigned_to" id="" class="form-select">
                                <option value="0">Select</option>
                                <?php foreach($dept_users as $dept_user ) : ?>
                                    <option value="<?= $dept_user->id ?>"><?= $dept_user->first_name . ' ' . $dept_user->last_name ?></option>
                                <?php endforeach; ?>
                                <!-- <option value="1">Jeremy Ellis</option> -->
                            </select>
                            <label for="priority">Assign To</label>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- 
                Department Select 
                Priority Select 
            -->
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <select name="dept_id" id="" class="form-select">
                            <option value="">Select Requesting Dept.</option>
                            <?php if($depts) : ?>
                                <?php foreach($depts as $option) : ?>
                                    <option value="<?= $option->id ?>"><?= $option->name ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <label for="dept_id">Deparment</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <?php $options = [
                            'none' => 'No Action Needed', 
                            'low' => 'Routine', 
                            'medium' => 'Important', 
                            'high' => 'Urgent', 
                        ]; ?>

                        <select name="priority" id="" class="form-select">
                            <?php foreach($options as $key => $option ) : ?>
                                <option value="<?= $key ?>"><?= $option ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="priority">Priority Level</label>
                    </div>
                </div>
            </div>
            <!-- 
                Title Input 
            -->
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control" type="text" name="title" id="" placeholder="" value="">
                        <label for="title">Title</label>
                    </div>
                </div>
            </div>
            <!--
                Description Textarea
            -->
            <div class="row">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" name="description" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Description</label>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="new-ticket-btn" class="btn btn-success" ><i class="bi bi-plus-square"></i>&nbsp;Submit Request</button>
        </div>
        </div>
    </div>
  </form>
</div>