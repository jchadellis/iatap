<div class="row fs-5 p-4 mb-2 text-center border-bottom rounded-3 part-row text-white bg-color-1 fw-bold header" >
    <div class="col-2">DEPT</div>
    <div class="col-5">
        <div class="row">
            <div class="col-4">PART</div>
            <div class="col-8 text-truncate">DESCRIPTION</div>
        </div>
    </div>
    <div class="col-2">WORKORDER</div>
    <div class="col-1">START</div>
    <div class="col-1">EST. HRS</div>
    <div class="col-1">PROGRESS</div> 
    <!--
    <div class="col-2">Priority</div>
    <div class="col-1">Status</div> -->
</div>

<?php foreach($data as $row) : ?>
<div class="row fs-5 p-4 m-2 text-center bg-color-2 border rounded-3 part-row">
    <div class="col-2 fw-bold"><?= $row->dept ?></div>
    <div class="col-5 text-start border-start border-end border-dark">
        <div class="row">
            <div class="col-4"><?= $row->part_id ?> - </div>
            <div class="col-8 text-truncate"><?= $row->description ?></div>
        </div>
    </div>
    <div class="col-2 fw-bold"><?= $row->workorder_base_id ?></div>
    <div class="col-1 text-center"><?= (new \DateTime($row->start_date))->format('M d, Y') ?></div>
    <div class="col-1 text-center"><?= $row->run_hrs ?></div>
    <div class="col-1 text-center"><?= $row->actual_hrs ?></div>
    <!--- Keep here for now may not use 
    <div class="col-2"> <span class="text-danger" ><i class="bi bi-flag-fill"></i> &nbsp; High</span> | <span class="text-warning"><i class="bi bi-flag-fill"></i> &nbsp; Mid</span> | <span class="text-success"><i class="bi bi-flag-fill"></i> &nbsp;Low</span></div>
    <div class="col-1"><i class="bi bi-circle-fill fs-6" style="color:#b7fb17"></i>&nbsp; Active</div> -->
</div>
<?php endforeach; ?>