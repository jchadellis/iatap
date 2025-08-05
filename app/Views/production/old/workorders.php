

<!-- <div class="row mb-4" id="statusButtons">
  <div class="col-2">
    <h5 class="h5"> Filter Status : </h5>
  </div>
  <div class="col d-grid"><button class="btn btn-dark" data-status="">ALL</button></div>
  <div class="col d-grid"><button class="btn btn-danger " data-status="Deficient">DEFICIENT</button></div>
  <div class="col d-grid"><button class="btn btn-info " data-status="On Order" style="background-color: #cceeff" >ON ORDER</button></div>
  <div class="col d-grid"><button class="btn btn-warning " data-status="Needs Issued">NEEDS ISSUED</button></div>
  <div class="col d-grid"><button class="btn btn-success " data-status="Ready">READY</button></div>
</div> -->
<div class="row">
  <div class="col-3">
  </div>
  <div class="col-3">
    <label for="statusFilter">Filter By Dept</label>
    <?php if( $depts ) : ?>
      <select name="deptFilter" id="deptFilter" class="form-select"> 
        <?php foreach( $depts as $key => $dept ) : ?>
          <option value="<?= $key ?>" <?= ($key == $id) ? 'selected' : ''?>> <?= strtoupper($dept['description'])  ?></option>
        <?php endforeach; ?>
        <option value="">ALL</option>
      </select>    
    <?php endif; ?>
  </div>
  <div class="col-3">
    <label for="statusFilter">Filter By Status</label>
    <select id="statusFilter" class="form-select">
      <option value="">ALL</option>
      <option value="Deficient">DEFICIENT</option>
      <option value="On Order">ON ORDER</option>
      <option value="Needs Issued">NEEDS ISSUED</option>
      <option value="Ready">READY</option>
    </select>
  </div>
  <div class="col-3"></div>
</div>

<table class="table table-border table-striped">
    <thead>
        <tr>
            <th class="text-center">Work Order ID</th>
            <th class="text-center">Part Num</th>
            <th class="text-center">Description</th>
            <th class="text-center">Want Date</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if($data) : ?>
            <?php foreach($data as $wo) : ?>
                <tr data-workorder="<?= $wo->id ?>">
                    <td class="text-center" ><?= $wo->base_id ?></td>
                    <td class="text-center"><?= $wo->part_id ?></td>
                    <td class="text-center"><?= $wo->description ?></td>
                    <td class="text-center"><?= (new DateTime($wo->want_date))->format('M d Y') ?></td>
                    <td class="text-center <?= $wo->cell_color ?>"><?=$wo->wo_status ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>


<!-- Vertically centered scrollable modal -->
 <div class="modal" id="wo-modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">

        </div>
    </div>
 </div>


 <!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalMessageBody">
        <!-- Message will be injected here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
