<div class="row">
    <div class="col">
        <table class="table table-striped table-border">
            <thead>
                <tr>
                    <th class="text-center">Transaction NO.</th>
                    <th class="text-center">WO NO.</th>
                    <th class="text-center">Part ID</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">ISS</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Loc. QTY</th>
                    <th class="text-center">Printed</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row) : ?>
                <tr>
                    <td class="text-center"><?= $row->trans_id ?> </td>
                    <td class="text-center"><?= $row->trans_base_id ?></td>
                    <td class="text-center"><?= $row->part_id ?></td>
                    <td class="text-center"><?= $row->part_description ?></td>
                    <td class="text-center"><?= $row->trans_qty ?></td>
                    <td class="text-center"><?= $row->trans_loc_id ?></td>
                    <td class="text-center"><?= $row->part_loc_qty ?></td>
                    <td class="text-center"><?= ($row->printed) ? 'Yes' : 'No' ?></td>
                </tr>
                <tr>
                    <td colspan="8">
                        <div class="row fw-bold">
                            <div class="col-6">
                                 <?= $row->trans_description ?>
                            </div>
                            <div class="col-6 text-end">
                                <?= round($row->trans_material_cost / $row->trans_qty,2) ?> EA / <?= $row->trans_material_cost ?> EXT 
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <form action="">
                            <div class="row">
                                <div class="col"></div>
                                <div class="col-2 d-grid text-end"><button class="btn btn-success" type="button"><i class="bi bi-printer-fill"></i>&nbsp;   Print</button></div>
                            </div>
                        </form>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>