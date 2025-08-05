<?php 
    
    if( $po->linear_progress <= 25 ){
        $color = "bg-success"; 
    } elseif( $po->linear_progress >= 26 && $po->linear_progress <= 50 ){
        $color = 'bg-primary';
    }  elseif( $po->linear_progress > 51 && $po->linear_progress <= 90 ){
        $color = 'bg-warning text-dark';
    } elseif( $po->linear_progress > 90 && $po->linear_progress <= 99 ){
        $color = 'bg-warning text-dark'; 
    } elseif( $po->linear_progress >= 100  ){
        $color = 'bg-muted-danger text-white'; 
    }
    

    $today = new \DateTime();

    function getFollowupButton($targetDate, $updatedAt, $today, $expected = false)
    {
        if($expected)
        {
            if($targetDate >= $today )
            {
                return ['btn-success', 'On Time', true];
            }else{
                return ['btn-danger', 'Late', true];
            }

        }

        if ($targetDate > $today  ) {
            return ['btn-outline-primary', 'Update', false];
        } elseif ($updatedAt) {
            return ['btn-primary', 'Updated', true];
        } elseif( $today > $targetDate && empty($updatedAt) ) {
            return ['btn-outline-danger', 'Not Updated', true];
        } else {
            return ['btn-danger', 'Updated', true];
        }
    }


list($class25, $label25, $disabled25) = getFollowupButton($po->followup_25_target_date, $po->followup_25_updated_at, $today);
list($class50, $label50, $disabled50) = getFollowupButton($po->followup_50_target_date, $po->followup_50_updated_at, $today);
list($class90, $label90, $disabled90) = getFollowupButton($po->followup_90_target_date, $po->followup_90_updated_at, $today);
list($classExpected, $labelExpected, $disabledExpected) = getFollowupButton($po->true_promise, $po->true_promise, $today, true); 

$percent = max(0, min(100, $po->linear_progress )); 
?>

    <div class="modal-header">  
        <h5><?= $data->id ?> : <?= $data->name ?> : <?= $data->purchase_order ?> &nbsp; <span class="badge <?= ($po->confirmed) ? 'text-bg-success' : 'text-bg-warning'?>"><?= ($po->confirmed) ? 'Confirmed' : 'Unconfirmed'?></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    </div>

    <div class="modal-body">
        <h6 class="h6">Progress Toward Delivery Date</h6>
        <div class="progress mb-4" role="progressbar" aria-label="Danger example" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100" style="height: 30px">
            <div class="progress-bar fs-6 <?= $color ?>" style="width: <?= $percent ?>%" ><?= $percent ?>%</div>
        </div>
        <p>Last recorded update from the vendor regarding this order: <span class="fw-bold"><?= !empty($po->last_vendor_update_at) ? $po->last_vendor_update_at : 'N/A'?></span>. Next scheduled vendor update is: <span class="fw-bold"><?= !empty($po->next_vendor_update_at) ? $po->next_vendor_update_at : 'N/A'?></span></p>
        <?php if($data->lines) : ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">PO#</th>
                    <th class="text-center">Promise Date</th>
                    <th class="text-center">Part No.</th>
                    <th>Description</th>
                    <th class="text-center">Ordered</th>
                    <th class="text-center">Received</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->lines as $row ) : ?>
                <?php $row = (object) $row ?>
                <tr>
                    <td class="text-center"><?= $row->id ?></td>
                    <td class="text-center"><?= ( new \DateTime($row->line_promise_date))->format('m-d-Y');  ?></td>
                    <td class="text-center"><?= $row->part_id ?></td>
                    <td><?= $row->description ?></td>
                    <td class="text-center"><?= $row->user_order_qty ?></td>
                    <td class="text-center"><?= $row->user_received_qty ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="text-center fs-6"><strong>All Vendors are encourage to meet a 90% on-time delivery target.</strong><br>
        As of <span class="fw-bold"><?= esc($data->todays_date) ?> </span> <?= $data->name ?> : on-time delivery percentage is <strong><?= esc( ( $data->performance['metric'] ) ? $data->performance['metric'] .'%' : 'N/A' ) ?></strong>.</p>
        <?php else : ?>
        <div class="alert alert-warning">
            <p>There are no matching line items found for this purchase order.</p>
        </div>
        <?php endif; ?>

        <div class="row mt-2">
            <div class="col-4"><p class="fw-bold p-0 p-1 mb-0">Contact Name:</p><p><?= $po->contact_first_name . ' ' . $po->contact_last_name ?></p></div>
            <div class="col-4"><p class="fw-bold p-0 p-1 mb-0">Phone:</p><p><?= $po->phone ?></p></div>
            <div class="col-4">
                <div class="form-floating">
                    <input type="text" name="email_to" class="form-control" placeholder="" value="<?= strtolower(($data->contact_email)) ?? '' ?>">
                    <label for="email_to">Email TO:</label>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">    
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="hidden" name="vendor_id" value="<?= $data->id ?>">
        <input type="hidden" name="purchase_order_id" value="<?= $data->purchase_order ?>">
        <input type="hidden" name="promise_date" value="<?= $promise_date ?>">
        <button type="submit" class="btn btn-success">Email Vendor</button>
    </div>

<!-- Modal -->
 <script> 

    function vendorLoadingModal( id = 'vendor_update_modal',  title = 'Loading', message = 'Please wait...') {
    
        // Remove existing modal if it exists
        const existing = document.getElementById(id);

        if (existing) existing.remove();

        const vendorModal = `<div class="modal fade" id="vendor_update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Vendor Delivery Progress Update</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr class="text-center">
                                        <td colspan="5" class="fw-bold">
                                            Vendor Delivery Update Schedule
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <th>25%</th>
                                        <th>50%</th>
                                        <th>80%</th>
                                        <th>90%</th>
                                        <th>Expected</th>
                                    </tr>
                                    <tr class="text-center">
                                        <td><?= $po->followup_25_target_date->format('m-d-Y') ?></td>
                                        <td><?= $po->followup_50_target_date->format('m-d-Y') ?></td>
                                        <td><?= $po->followup_90_target_date->format('m-d-Y') ?></td>
                                        <td><?= $po->true_promise->format('m-d-Y') ?></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="text-center">
                                            <button class="btn <?= $class25 ?>" <?= $disabled25 ? 'disabled' : '' ?>><?= $label25 ?></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn <?= $class50 ?>" <?= $disabled50 ? 'disabled' : '' ?>><?= $label50 ?></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn <?= $class90 ?>" <?= $disabled90 ? 'disabled' : '' ?>><?= $label90 ?></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn <?= $classExpected ?>" <?= $disabledExpected ? 'disabled' : '' ?>><?= $labelExpected ?></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                        </div>
                    </div>
                    </div>`;
        // Append to body
        document.body.insertAdjacentHTML('beforeend', vendorModal);

        // Show modal
        const modalEl = document.getElementById(id);
        const bsModal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false
        });

        // Optional: Automatically remove modal element after it's fully hidden
        // modalEl.addEventListener('hidden.bs.modal', function onHiddenCleanup() {
        //     modalEl.remove(); // Remove from DOM
        // });

        bsModal.show();

        // Return reference to modal in case you want to hide or destroy it later
        return bsModal;

    }

    $(document).ready(()=>{ 

        $('#vendorUpdateBtn').on('click',(e)=>{
            e.preventDefault();
            vndorUpdateModal = vendorLoadingModal(); 

        })  
        
    })
</script>