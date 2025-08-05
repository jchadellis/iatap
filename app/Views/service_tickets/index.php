<div class="row">
    <div class="col">
        <table class="table table-bordered table-striped" id="table">
        
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" id="it_modal_form">
  <form action="">
    <div class="modal-dialog modal-lg">
        <input type="hidden" name="type" value="<?= $type ?>">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?= $title ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php if($user) : ?>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control" type="text" name="user" id="" placeholder="" value="<?= $user->first_name . ' ' .$user->last_name ?>" >
                        <input type="hidden" name="user_id" value="<?= $user->id ?>">
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
                        <select name="priority" id="" class="form-select">
                            <option value="none">No Action Needed</option>
                            <option value="low">Routine</option>
                            <option value="medium">Important</option>
                            <option value="high">Urgent</option>
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
            <button type="button" class="btn btn-success form-submit-btn" ><i class="bi bi-plus-square"></i>&nbsp;Submit Request</button>
        </div>
        </div>
    </div>
  </form>
</div>

<?php if($data) : ?>
<?php foreach($data as $row) : ?>
    <?php $row = (object) $row ?>
    <div class="modal" tabindex="-1" id="editModal<?= $row->id ?>">
        <form action="" id="editForm<?=$row->id?>" >
            <input type="hidden" name="id" value="<?= $row->id ?>">
            <input type="hidden" name="type" value="<?= $row->type ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $title ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="user" id="" placeholder="" value="<?= $row->user ?>" >
                                <label for="requested_by">First & Last Name</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="text" name="need_date" id="" class="form-control date-picker" placeholder="" value="<?= $row->need_date  ?> ">
                                <label for="need_date">Need Date</label>
                            </div>
                        </div>
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
                                <select name="priority" id="" class="form-select">
                                    <option value="none">No Action Needed</option>
                                    <option value="low">Routine</option>
                                    <option value="medium">Important</option>
                                    <option value="high">Urgent</option>
                                </select>
                                <label for="priority">Priority Level</label>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="title" id="" placeholder="" value="<?= $row->title ?>">
                                <label for="title">Title</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="request" style="height: 100px" value="<?= $row->description ?>"><?= $row->description ?></textarea>
                                <label for="floatingTextarea2">description</label>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-6">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="work_performed" style="height: 100px" value="<?= ($row->work_performed) ?? '' ?>" id="resolution_input<?= $row->id ?>" <?= ($row->work_performed) ? '' : 'disabled' ?>><?= ($row->work_performed) ?? '' ?></textarea>
                                <label for="floatingTextarea2">Work Performed</label>
                            </div>                          
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="comments" style="height: 100px" value="<?= ($row->comments) ?? '' ?>" id="comment_input<?= $row->id ?>" <?= ($row->comments) ? '' : 'disabled' ?>><?= ($row->comments) ?? '' ?></textarea>
                                <label for="floatingTextarea2">Comment</label>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info exit-btn" data-bs-dismiss="modal"> <i class="bi bi-x-square"></i> &nbsp; Exit</button>
                    <button type="button" data-id="<?= $row->id ?>" class="btn btn-warning complete-btn" <?= ($user->can("$type.delete")) ? '' : 'disabled' ?> <?= ($row->status) == 'Completed' ? 'disabled' : '' ?>>
                        <?php if( $row->btn_icon ) : ?> <i class="bi bi-check-square"></i> <?php else : ?> <?php endif; ?> 
                        &nbsp;<?= $row->status == 'Completed' ? 'Closed' : 'Mark Completed' ?>
                    </button>
                    <button type="button" data-id="<?= $row->id ?>" class="btn btn-primary form-submit-btn" <?= ($row->status == 'Completed') ? 'disabled' : '' ?>><i class="bi bi-arrow-up-circle"></i> &nbsp; Update</button>
                </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?>
<?php endif; ?>

<div class="modal" id="confirm_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Comments</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-floating">
                        <textarea name="resolution" id="resolution">

                        </textarea>
                        <label for="resolution">Work Completed</label>
                    </div>
                    <div class="form-floating">
                        <textarea name="comment" id="comment">

                        </textarea>
                        <label for="resolution">Comments</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
