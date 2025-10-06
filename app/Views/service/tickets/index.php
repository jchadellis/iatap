
<div class="row mb-1">
    <div class="col">
        <div class="alert alert-info">
            <p class="text-center p-0 m-0">
                To get started, simply click the <i class="bi bi-plus-square"></i>&nbsp;New Request Ticket button.This will open up the ticket editor where you can enter all the details of your request.
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <table class="table table-bordered table-striped" id="table">
        
        </table>
    </div>
</div>

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
            <div class="row mb-3">
                <div class="col">
                    <div class="card text-bg-lite-blue ">
                        <div class="card-header">Priority Level</div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-bg-lite-blue"><span class="fw-bold">No Action Needed:</span> Informational only or don't require follow-up</li>
                                <li class="list-group-item text-bg-lite-blue"><span class="fw-bold">Routine</span> Standard requests with no urgency</li>
                                <li class="list-group-item text-bg-lite-blue"><span class="fw-bold">Important</span> Needs attention soon</li>
                                <li class="list-group-item text-bg-lite-blue"><span class="fw-bold">Urgent</span> High impact issues like outages, security breaches, or widespread disruption</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
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

                <div class="col-8">
                    <div class="form-floating">
                        <input class="form-control" type="text" name="title" id="" placeholder="">
                        <label for="title">Title</label>
                    </div>
                </div>
            </div>
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

<div class="modal" tabindex="-1" id="service-ticket-modal">
    <form action="" id="service-ticket-modal-form" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content-modal">
                <div class="modal-header">
                    <h5 class="modal-title">Request Ticket Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"> <i class="bi bi-x-square"></i> &nbsp;Exit</button>
                    <?php if($userCanClose) : ?>
                        <button type="button" id="close-ticket-btn" class="btn btn-warning"><i class="bi bi-check-square"></i>&nbsp;Close Ticket</button> 
                    <?php else: ?>
                        <button type="button" id="close-ticket-btn" class="btn btn-warning" disabled><i class="bi bi-check-square" ></i>&nbsp;Close Ticket</button> 
                    <?php endif; ?>
                    <?php if($userCanUpdate) : ?>  
                        <button type="button" id="update-ticket-btn"  class="btn btn-primary" ><i class="bi bi-arrow-up-circle"></i>&nbsp;Update</button>
                    <?php else: ?>
                        <button type="button" id="update-ticket-btn"  class="btn btn-primary" disabled><i class="bi bi-arrow-up-circle"></i>&nbsp;Update</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>
