<div class="row mb-2">
    <div class="col-12">
        <h6 class="h6">Work Request</h6>
        <input type="hidden" name="id" value="<?= $data->id ?>">
        <input type="hidden" name="request_id" value="<?= $data->request_id ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-6">
        <div class="row mb-2">
            <div class="col-12">
                <div class="form-floating">
                    <?php $value = $data->work_order ?? '' ?>
                    <input type="text" name="work_order" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="work_order">Work Order</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="form-floating">
                    <?php $value = $data->mfg_email ?? '' ?>
                    <input type="text" name="mfg_email" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="mfg_email">MFG. Contact</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="form-floating">
                    <?php $value = $data->request_by_email ?? '' ?>
                    <input type="text" name="request_by_email" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="request_by_email">Requested By</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                <div class="form-floating">
                    <?php $value = $data->qty ?? '' ?>
                    <input type="text" name="qty" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="qty">Qty</label>
                </div>
            </div>
            <div class="col-9">
                <div class="form-floating">
                    <?php $value = $data->part_id ?? '' ?>
                    <input type="text" name="part_id" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="qty">Part ID</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="form-floating">
                    <?php $value = $data->due_date ?? '' ?>
                    <input type="text" name="due_date" id="" class="form-control datepicker" placeholder="" value="<?= $value ?>">
                    <label for="due_date">Due Date</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
                <div class="col-6">
                    <div class="form-floating">
                        <select name="demand_type"  placeholder="" class="form-select demand-type-select">
                            <option value="">Select Type</option>
                            <?php if(isset($demand_types) ) : ?>
                                <?php foreach($demand_types as $type) : ?>
                                <option value="<?= $type->id ?>" <?= $type->id == $data->demand_type ? 'selected' : '' ?>><?= $type->name ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?> 
                        </select>
                        <label for="demand_type">Demand Type</label>
                    </div>
                </div>
            <div class="col-6">
                <div class="form-floating">
                    <?php $value = $data->demand_id ?? '' ?>
                    <input type="text" name="demand_id" id="" class="form-control demand-id-input" placeholder="" value="<?= $value ?>" <?= $data->demand_type != 1 ? 'disabled' : ''; ?>>
                    <label for="demand_id">Demand ID</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row mb-2">
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = $data->qar ?? '' ?>
                    <input type="text" name="qar" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="qty">QAR</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = $data->coc ?? '' ?>
                    <input type="text" name="coc" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="qty">COC</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <?php $value = $data->dpas_rating ?? '' ?>
                    <input type="text" name="dpas_rating" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="qty">DPAS</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <div class="form-floating">
                    <?php $value = $data->contract ?? '' ?>
                    <input type="text" name="contract" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="work_order">Contract #</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <?php $value = $data->end_user ?? '' ?>
                    <input type="text" name="end_user" id="" class="form-control" placeholder="" value="<?= $value ?>">
                    <label for="work_order">End User</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="form-floating">
                    <?php $value = $data->notes ?? '' ?>
                    <textarea class="form-control" id="notes" name="notes" rows="3" style="height: 200px"><?= $value ?></textarea>
                    <label for="notes">Notes</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 d-grid">
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <h6 class="h6">Update History</h6>
        <?php if( isset($data->history) ) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Modified</th>
                    <th>By</th>
                    <th>Part ID</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($data->history as $log) : ?>
                <tr>
                    <td><?= (new \DateTime($log->updated_at))->format('m-d-Y')?></td>
                    <td><?= $log->updated_by ?></td>
                    <td><?= $log->part_id ?></td>
                    <td><?= (new \DateTime($log->created_at))->format('m-d-Y') ?></td>
                </tr>
                <tr class="table-info">
                    <td colspan="5">
                        <span class="fw-bold">Changes: </span> <?= $log->updated_fields ?? 'Not Recorded' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">
                        No updated have been saved.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
        </table>
    </div>
</div>