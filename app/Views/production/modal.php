

<div class="modal-header">
    <div class="row">
        <h6 class="modal-title">Work Order # <?= $data->base_id ?> / <span class='text-secondary'><?= $data->description ?></span></h6>
    </div>
    <div class="row">
       <h6 class="modal-title ms-4" >Want Date : <?= ( new DateTime( $data->want_date ) )->format('m-d-Y') ?> <?= ( $data->want_date < date('Y-m-d') ) ? "<span class=\"badge text-bg-warning\"> Work Order Is Late </span>" : '' ?></h6>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <?php foreach($data->operations as $op ) : ?>
        <form action="<?= base_url('workorder/print') ?>" method="post">
        <input type="hidden" name="base_id" value="<?= $op->base_id ?>"> <input type="hidden" name="sub_id" value="<?= $op->sub_id ?>"><input type="hidden" name="seq_no" value="<?= $op->sequence_no ?>"><input type="hidden" name="resource_id" value="<?= $op->resource_id ?>">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th class="text-center" >Sub ID</th>
                    <th class="text-center" >Sequence No.</th>
                    <th class="text-center" >Resourece ID</th>
                    <th class="text-center" >Schedule Start Date:</th>
                    <th class="text-center" >Run</th>
                    <th class="text-center" >Run Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" ><?= $op->sub_id ?></td>
                    <td class="text-center" ><?= $op->sequence_no ?></td>
                    <td class="text-center" ><?= $op->resource_id ?></td>
                    <td class="text-center" ><?= $op->sched_start_date ?></td>
                    <td class="text-center" ><?= $op->run ?></td>
                    <td class="text-center" ><?= $op->run_type ?></td>
                </tr>
                <tr colspan="6">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center col-1">Piece No</th>
                                <th class="text-center col-2" >Part ID</th>
                                <th class="col-2">Description</th>
                                <th class="text-center col-1" >QTY PER</th>
                                <th class="text-center col-1" >REQ. QTY</th>
                                <th class="text-center col-1" >ISS</th>
                                <th class="text-center col-1" >QOH</th>
                                <th class="text-center col-1" >QOO</th>
                                <th class="text-center col-1" >STATUS</th>
                                <th class="text-center col-1" >Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( count($op->requirements) > 0 ) : ?>
                            <?php foreach($op->requirements as $req ) : ?>
                            <tr>
                                <td class="text-center col-1 fs-6"><?= $req->piece_no ?> <span class="fw-bold">(<?= $req->status ?>)</span></td>
                                <td class="text-center col-2 text-truncate p-0" ><?= $req->part_id ?></td>
                                <td class="text-truncate col-2"><?= $req->description ?></td>
                                <td class="text-center col-1" ><?= $req->qty_per ?></td>
                                <td class="text-center col-1" >
                                    <?php if( $req->status != 'C') : ?>
                                        <input class="form-control form-control-sm text-end border-1 border-danger" type="text" name="request_qty[]" id="" value="<?= $req->calc_qty ?>">
                                    <?php else : ?>
                                        <?= $req->calc_qty ?>
                                        <input type="hidden" name="request_qty[]" value="<?=$req->calc_qty ?>">
                                    <?php endif; ?>
                                </td>
                                <td class="text-center col-1"><?= $req->issued_qty ?></td>
                                <td class="text-center col-1" v><?= $req->qty_on_hand ?></td>
                                <td class="text-center col-1" ><?= $req->qty_on_order?></td>
                                <td class="text-center col-1 <?= $req->text_color ?>" ><?= $req->wo_status ?></td>
                                <td class="text-center col-1 "><input type="checkbox" name="print[<?= $req->part_id ?>]" value="1" id="" checked></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <div class="alert alert-warning text-center">
                                    This Operation Does Not Have Any Requirements
                                </div>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </tr>
                <tr >
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="d-flex justify-content-end align-items-center h-100 fw-bold">
                                <label for="deliver_to">Deliver TO:</label>
                                </div>
                            </div>
                        <div class="col-4 d-grid">
                           
                            <select class="form-select" name="deliver_to" id="deliver_to">
                                <option value="Todd Pate">Todd</option>
                                <option value="Roland Gidley">Roland</option>
                                <option value="Adam Lawson">Adam</option>
                                <option value="Jason Hammon">Jason</option>
                                <option value="Ricky Thomas">Ricky</option>
                                <option value="Larry Cheatwood">Larry</option>
                            </select>
                        </div>
                        <div class="col-4 d-grid"><button class="btn btn-success part-submit-btn" type="submit"><i class="bi bi-printer-fill"></i> &nbsp; Print Parts Request</button></div>
                    </div>
                </tr>
            </tbody>
        </table>
        </form>
    <?php endforeach; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>