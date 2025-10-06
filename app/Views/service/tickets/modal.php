<input type="hidden" name="id" value="<?= $ticket->id ?>">
<input type="hidden" name="type" value="<?= $ticket->type ?>">
<input type="hidden" name="status" value="<?= $ticket->status ?>">
<input type="hidden" name="num_of_updates" value="<?= $ticket->num_of_updates ?>">
<div class="row mb-3">
    <div class="col-6">
        <div class="form-floating">
            <input class="form-control" type="text" name="user" id="" placeholder="" value="<?= $ticket->first_name . ' '. $ticket->last_name ?>" disabled>
            <label for="requested_by">First & Last Name</label>
        </div>
    </div>
    <div class="col-6">
        <div class="form-floating">
            <input type="text" name="need_date" id="" class="form-control date-picker" placeholder="" value="<?= $ticket->need_date  ?> ">
            <label for="need_date">Need Date</label>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <div class="form-floating">
            <input class="form-control" type="text" name="email" id="" placeholder="" value="<?= $ticket->email ?>" >
            <label for="requested_by">Email</label>
        </div>
    </div>
    <div class="col-6">
        <?php if($ticket->type === 'engineering') : ?>
        <div class="form-floating">
            <input type="text" name="assigned_to" id="" class="form-control" disabled value="<?= $user->first_name ?? '' ?> <?= $user->last_name ?? '' ?>">
            <label for="">Assigned TO</label>
        </div>
        <?php endif; ?>
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
            <?php $options = [
                'none' => 'No Action Needed', 
                'low' => 'Routine', 
                'medium' => 'Important', 
                'high' => 'Urgent', 
            ]; ?>

            <select name="priority" id="" class="form-select">
                <?php foreach($options as $key => $option ) : ?>
                    <option value="<?= $key ?>" <?= $key == $ticket->priority ? 'selected' : '' ?>><?= $option ?></option>
                <?php endforeach; ?>
            </select>
            <label for="priority">Priority Level</label>
        </div>
    </div>

    <div class="col-8">
        <div class="form-floating">
            <input class="form-control" type="text" name="title" id="" placeholder="" value="<?= $ticket->title ?>">
            <label for="title">Title</label>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" name="description" style="height: 200px" value="<?= $ticket->description ?>"><?= $ticket->description ?></textarea>
            <label for="floatingTextarea2">Description</label>
        </div>
    </div>
</div>
