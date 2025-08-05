<table class="table table-bordered table-striped" id="vendorTable">

</table>


<div class="modal" id="content_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            
        </div>
    </div>
</div>


<?php foreach($data as $row) : ?>
    <div class="modal fade" id="<?= $row->id ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Performance Period <?= ( new \DateTime($row->start_date))->format('m-d-Y')  ?> - <?= ( new \DateTime($row->end_date))->format('m-d-Y') ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Vendor ID</th>
                        <th colspan="3">Vendor Name</th>
                    </tr>
                    <tr>
                        <td><?= $row->id ?></td>
                        <td colspan="3"><?= $row->name ?></td>
                    </tr>
                    <tr>
                        <th colspan="4">
                            Address
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table class="table">
                                <tr>
                                    <td colspan="4">
                                        <?= $row->street_1 ?>
                                    </td>
                                    <?php if( $row->street_2) : ?>
                                    <td colspan="4">
                                        <?= $row->street_2 ?>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td><?= $row->city ?></td>
                                    <td><?= $row->state ?></td>
                                    <td><?= $row->zip ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Phone:</td>
                        <td colspan="3"><?= $row->phone ?></td>
                    </tr>
                    <tr>
                        <th>Email:</td>
                        <td colspan="3"><?= $row->email ?></td>
                    </tr>
                    <tr class="text-center">
                        <th class="col-6">On Time Percentage</th>
                        <th class="col-6">Late Percentage</th>
                    </tr>
                    <tr class="text-center">
                        <td class="col-6">
                            <div class="progress " role="progressbar" aria-label="Basic example" aria-valuenow="<?= $row->on_time_percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar <?= $row->bg_color ?>" style="width: <?= $row->on_time_percentage ?>%"><?= $row->on_time_percentage ?>%</div>
                            </div>
                        </td>
                        <td class="col-6">
                            <div class="progress " role="progressbar" aria-label="Basic example" aria-valuenow="<?= $row->late_percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar <?= $row->late_bg_color ?>" style="width: <?= $row->late_percentage ?>%"><?= $row->late_percentage ?>%</div>
                            </div>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="4">
                            Total Lines : <?= $row->total_lines ?> / Total On Time : <span class="text-success"><?= $row->total_on_time ?></span> / Total Late : <span class="text-danger"><?= $row->total_late ?></span> / Total NCP : <span class="text-dark"><?= ($row->ncp) ? $row->ncp : 0 ?></span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" disabled>Email Vendor</button>
            </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>