
<table class="table table-striped table-bordered">


</table>

<div class="modal" id="newRecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Training Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-floating">
                            <select name="employee_id" id="" class="form-select" >
                                <option value="null">Select Employee</option>
                                <?php foreach($employees as $employee) : ?>
                                <option value="<?= $employee->id ?>"><?= $employee->first_name . ' ' . $employee->last_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="employee_id">Employee</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="form-floating">
                            <input type="text" name="type" id="" placeholder="" class="form-control">
                            <label for="type">Training Type</label>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-floating">
                            <input type="text" name="type" id="" placeholder="" class="form-control">
                            <label for="type">Training Description</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating">
                            <select name="trainer_id" id="" class="form-select" >
                                <option value="null">Select Trainer</option>
                                <?php foreach($employees as $employee) : ?>
                                <option value="<?= $employee->id ?>"><?= $employee->first_name . ' ' . $employee->last_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="trainer_id">Trainer</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" name="date" id="" class="form-control date-picker">
                            <label for="date">Date</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                <button type="button" class="btn btn-success"><i class="bi bi-plus-square"></i> Save</button>
            </div>
        </div>
    </div>
</div>
