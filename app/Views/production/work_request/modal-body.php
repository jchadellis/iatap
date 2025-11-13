<?php 
    $new = (!isset($data->id)) ? true : false;
    // print_array($data);
    // return; 

?>

<div class="modal-header">
    <?php if($new) : ?>
        <h5 class="h5">New Work Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <?php else: ?>
        <h5 class="h5">Work Request <strong><?= $data->id ?> - <?= $data->part_id ?></strong> Update </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <?php endif; ?>
</div>
<div class="modal-body">
    <div class="row mb-2">
        <div class="col-6">
            <!-- HIDE IF NEW WORK REQUEST --> 
            <?php if( !$new ) : ?>
            <div class="row mb-2">
                <div class="col-6">
                    <div class="form-floating">
                        <input type="hidden" name="id" value="<?= $data->id ?>">
                        <?php $value = $data->work_order ?? '' ?>
                        <input type="text" name="work_order" id="" class="form-control" placeholder="" value="<?= $value ?>">
                        <label for="work_order">Work Order</label>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- <div class="row mb-2">
                <div class="col-12">
                    <div class="form-floating">
                        <?php  //$value = ($user) ? $user->email : '' ?>
                        <input type="text" name="request_by_email" id="" class="form-control" placeholder="" value="">
                        <label for="request_by_email">Requested By</label>
                    </div>
                </div>
            </div> -->
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
                        <?php $value = ( $data ?? null ) ? (new \DateTime($data->want_date))->format('Y-m-d') : '' ?>
                        <input type="text" name="want_date" id="" class="form-control datepicker" placeholder="" value="<?= $value ?>">
                        <label for="want_date">Due Date</label>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <div class="form-floating">
                        <?php $value = $data->notes ?? '' ?>
                        <textarea class="form-control" id="notes" name="notes" rows="2" style="height: 200px"><?= $value ?></textarea>
                        <label for="notes">Notes</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row mb-2">
                <div class="col-6">
                    <div class="form-floating">
                        <?php $value = $data->demand_type ?? '' ?>
                        <select name="demand_type"  placeholder="" class="form-select" id="demand-type-select">
                            <option value="">Select Type</option>
                            <?php if(isset($demand_types) ) : ?>
                                <?php foreach($demand_types as $type) : ?>
                                <option value="<?= $type->id ?>" <?= ( $type->id === $value ) ? 'selected' : '' ?> ><?= $type->name ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?> 
                        </select>
                        <label for="demand_type">Demand Type</label>
                    </div>
                </div>
            </div>
            <div class="collapse <?= (isset($data) &&  $data->demand_type === '2' ) ? 'show' : ''  ?> " data-id="<?= $data->id ?? '' ?>" id="demand-type-collapse">
                <div class="row mb-2 g-2">
                    <div class="col-4">
                        <div class="form-floating">
                            <?php $value = $data->demand_id ?? '' ?>
                            <input type="text" name="demand_id" id="" class="form-control demand-id-input" placeholder="" value="<?= $value ?>">
                            <label for="demand_id">Demand ID</label>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-floating">
                            <?php $value = $data->inspection_level_id ?? '1' ?>
                            <select name="inspection_level" id="demand-type-select" placeholder="" class="form-select">
                                <option value="" selected>Select Type</option>
                                <?php if(isset($inspection_levels)) : ?>
                                    <?php foreach($inspection_levels as $type ) : ?>
                                        <option value="<?= $type->id  ?>" <?= $type->id === $value ? 'selected' : '' ?>><?= $type->name ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <label for="demand_type">Inspection Level</label>
                        </div>
                    </div> 
                </div>
                <div class="row mb-2 g-2 d-flex align-items-center">
                    
                    <div class="col-6 d-flex flex-column justify-content-center">
                        <?php $value = (isset($data) && $data->qar_signoff === 't' ) ? true : false ?>
                        <label for="qty" class="text-center">QAR Signoff</label>
                        <input type="checkbox" name="qar_signoff" id="" class="checkbox flex-fill"  data-size="small"  data-toggle="toggle" data-on="YES" data-off="NO" value="1" <?= $value ? 'checked' : '' ?>>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-center">
                        <?php $value = (isset($data) && $data->coc_required === 't' ) ? true : false ?>
                        <label for="qty" class="text-center">COC Required</label>
                        <input type="checkbox" name="coc_required" id="" class="checkbox flex-fill"  data-size="small" data-toggle="toggle" data-on="YES" data-off="NO" value="1" <?= $value ? 'checked' : '' ?>>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-floating">
                            <?php $value = $data->dpas_rating ?? '' ?>
                            <input type="text" name="dpas_rating" id="" class="form-control" placeholder="" value="<?= $value ?>">
                            <label for="qty">DPAS</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2 g-2">
                    <div class="col-12">
                        <div class="form-floating">
                            <?php $value = $data->contract_no ?? '' ?>
                            <input type="text" name="contract_no" id="" class="form-control" placeholder="" value="<?= $value ?>">
                            <label for="contract_no">Contract #</label>
                        </div>
                    </div>       
                    <div class="col-12">
                        <div class="form-floating">
                            <?php $value = $data->end_user ?? '' ?>
                            <input type="text" name="end_user" id="" class="form-control" placeholder="" value="<?= $value ?>">
                            <label for="end_user">End User</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <?php if(isset($data->history) && count($data->history) > 0 ) : ?>
                <table class="table mt-1 table-sm">
                <?php foreach($data->history as $item): ?>
                    
                    <?php $changes = json_decode($item->updated_fields); ?>
                    <tr class="table-info">
                        <th>Updated :</th>
                        <td><?= (new \DateTime($item->created_at))->format('Y-m-d') ?></td>
                        <th>Updated By:</th>
                        <td class="text-start"><a class="text-decoration-none text-dark" href="mailto:<?=$item->email?>?subject=<?= urldecode('Work Request Info:'.$item->work_request_id) ?>"><?= $item->user ?></a></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table class="table table-sm">
                                <tr>
                                    <th class="text-center">Field</th>
                                    <th class="text-center">Old Value</th>
                                    <th class="text-center">New Value</th>
                                </tr>
                                <?php foreach( $changes as $value ) : ?>
                                <tr>
                                    <td class="text-center">
                                        <span><?= $value->field_name ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class=""><?= $value->old_value ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class=""><?= $value->new_value ?></span> 
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                    
                <?php endforeach; ?>
                </table>
            <?php else: ?>
                <div class="alert alert-info d-flex justify-content-center align-items-center"><p class="p-0 m-0">No Change History</p></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-square"></i>&nbsp;Close Window</button>
    <?php if(!$new) : ?>
    <button type="button" class="btn btn-warning" id="close-btn">Close Work Request</button>
    <?php endif; ?>
    <button type="button" class="btn btn-success" aria-label="Close" id="save-btn"><i class="bi bi-floppy"></i>&nbsp;Save</button>
</div>