<style>
 .bg-muted-danger{
    background-color:#914d59;
 }
</style>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">PO No.</th>
            <th class="text-center">Order Date</th>
            <th class="text-center">Last Vendor Update</th>
            <th class="text-center">Buyer</th>
            <th class="text-center">Name</th>
            <th class="text-center">Phone</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($data as $row ) : ?>
        <tr data-vendor="<?= $row->vendor_id ?>" data-purchase_order="<?= $row->id ?>" data-promise_date="<?= $row->true_promise ?>">
            <td class="text-center col-1 <?// $row->color ?>"><?= $row->id ?> <?= $row->confirmed == 'X' ? '<span class="badge bg-success">C</span>' : '' ?></td>
            <td class="text-center col-2" data-order="<?= $row->order_d ?>" ><?= $row->order_d ?></td>
            <td class="text-center"><?= (new DateTime($row->last_vendor_update_at))->format('m-d-Y') ?></td>
            <!-- <td class="text-center col-2">
              <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $row->percentage_complete ?>" aria-valuemin="0" aria-valuemax="100">
              <?php 
                if( $row->percentage_complete <= 25 ){
                  $color = "bg-success"; 
                } elseif( $row->percentage_complete >= 26 && $row->percentage_complete <= 50 ){
                  $color = 'bg-primary';
                }  elseif( $row->percentage_complete >= 51 && $row->percentage_complete <= 79 ){
                  $color = 'bg-warning text-dark';
                } elseif( $row->percentage_complete >= 80 && $row->percentage_complete <= 99 ){
                  $color = 'bg-danger text-dark'; 
                } elseif( $row->percentage_complete >= 100  ){
                  $color = 'bg-muted-danger text-white'; 
                }
              ?>
              
              <div class="progress-bar <?=$color ?>" style="width: <?= $row->percentage_complete ?>%"> <?= ($row->percentage_complete <= 99 ) ? $row->percentage_complete.'%' : '100%' ?> </div>
              </div>
            </td> -->
            <td class="text-center col-1"><?= $row->buyer ?></td>

            <td class="text-start text-truncate col-3"> 
                <table >
                  <tr>
                    <td class="pe-3"> <span class="fw-bold"><?= $row->vendor_id ?></span></td>
                    <td class="ps-3"><?= $row->name ?></td>
                  </tr>
                </table>
            </td>
            <td class="text-center col-2"><?= $row->phone ?></td>
            <!-- <td class="d-grid"><button class="btn btn-primary btn-sm">Open</button></td> -->
            </div>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal"  id="waiting_modal" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
            <div class="d-flex justify-content-center align-items-center">
                <div class="spinner-border text-success"  style="width: 6rem; height:6rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="email_modal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <form action="" id="email-form">
        <div class="modal-content p-2">
        </div>
    </form>
  </div>
</div>

