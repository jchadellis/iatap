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
        <div class="form-floating">
            <input type="text" name="assigned_to" id="" class="form-control" disabled value="<?= $user->first_name ?? '' ?> <?= $user->last_name ?? '' ?>">
            <label for="">Assigned To</label>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <div class="form-floating">
            <select name="dept_id" id="" class="form-select">
                <option value="0">Select Requesting Dept.</option>
                <?php if($depts) : ?>
                    <?php foreach($depts as $option) : ?>
                        <option value="<?= $option->id ?>" <?= $ticket->dept_id == $option->id ? 'selected' : '' ?>><?= $option->name ?></option>
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
                    <option value="<?= $key ?>" <?= $key == $ticket->priority ? 'selected' : '' ?>><?= $option ?></option>
                <?php endforeach; ?>
            </select>
            <label for="priority">Priority Level</label>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <div class="form-floating">
            <input class="form-control" type="text" name="title" id="" placeholder="" value="<?= $ticket->title ?>">
            <label for="title">Title</label>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" name="description" style="height: 100px" value="<?= $ticket->description ?>"><?= $ticket->description ?></textarea>
            <label for="floatingTextarea2">Description</label>
        </div>
    </div>
</div>
