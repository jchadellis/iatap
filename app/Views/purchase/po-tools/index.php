
<div class="row">
    
<div class="col-6">
    <?= view('components/small-card', ['data' => $cards ]); ?>
</div>
</div>

<div class="modal" tabindex="-1" id="po_count_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Purchase Order Count </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><span class="fw-bold">Period Start : </span> <span id="start"><?= $data->start  ?></span> / <span class="fw-bold">Period End : </span> : <span id="end"><?= $data->end ?></span></p>
        
        <div class="row">
            <div class="col-6">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <h5><span class="h5 fw-bold">Total Orders : </span> <span id="count" ><?= $data->id ?></span></h5>
                </div>
            </div>
            <div class="col-6">
            <form action="purchasing" id="po_counts_form">
                <div class="form-floating">
                    <input type="text" class="form-control text-success text-end" name="period" id="period" placeholder="" value="<?= date('m-d-Y')?>">
                    <label for="period">Accounting Period</label>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="button">Update Period</button>
        </form>
      </div>
    </div>
  </div>
</div>

