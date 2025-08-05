

<?php if ( $data->has_lines ) : ?>
<?php $today = new DateTime(); ?>

  <div class="row">
    <div class="col-12">
      <h5 class="h5" style="color: #004085;"> <?= $data->name ?> / PO <?= $data->purchase_order ?> Status Updates</h5>
    </div>
  </div>
  <div class="row mb-5">
      <?php if( $po->next_vendor_update_at === 'Due Today' ) : ?>

            <div class="alert alert-warning text-center">
                <h4 class="h4">ORDER DUE TODAY!</h4>
            </div>


      <?php elseif(  $po->next_vendor_update_at === 'Past Due') : ?>

            <div class="alert alert-danger text-center">
                ORDER IS LATE!
            </div>

      <?php else : ?>
    <div class="col-12">
      <table class="table table-borderless ">
        <tr>
          <td></td>
          <td colspan="4"  class="text-center fw-bold bg-warning">Percentages of Target Date : <?= $promise_date ?></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="4">
            <?php  
                if( $po->percentage_complete <= 49 ){
                  $color = "bg-success"; 
                } elseif( $po->percentage_complete >= 50 && $po->percentage_complete <= 79 ){
                  $color = 'bg-primary';
                } elseif( $po->percentage_complete >= 80 && $po->percentage_complete <= 100 ){
                  $color = 'bg-warning text-dark'; 
                } elseif( $po->percentage_complete > 100 ){
                  $color = 'bg-info  ';
                }
            ?>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $po->percentage_complete?>" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar <?= $color; ?>" style="width: <?= $po->percentage_complete?>%"><?= $po->percentage_complete?>%</div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center">Confirmed</td>
          <td class="text-center  bg-warning-subtle fw-bold">25%</td>
          <td class="text-center  bg-warning-subtle fw-bold">50%</td>
          <td class="text-center  bg-warning-subtle fw-bold">80%</td>
          <td class="text-center  bg-warning-subtle fw-bold">90%</td>
        </tr>

        <tr>
          <td class="text-center"></td>
          <td class="text-center  bg-warning-subtle"><?= $po->followup_25_target_date->format('m-d-Y') ?></td>
          <td class="text-center  bg-warning-subtle"><?= $po->followup_50_target_date->format('m-d-Y') ?></td>
          <td class="text-center  bg-warning-subtle"><?= $po->followup_80_target_date->format('m-d-Y') ?></td>
          <td class="text-center  bg-warning-subtle"><?= $po->followup_90_target_date->format('m-d-Y') ?><td>
        </tr>
        <tr>
          <td class="text-center">
            <?php if ( $po->confirmed == 'X' ) : ?>
              <button class="btn btn-success" disabled> Confirmed </button>
            <?php else : ?>
              <button class="btn btn-outline-success">Not Cofirmed</button>
            <?php endif; ?>
          </td>
          <?php
              function getFollowupButton($targetDate, $updatedAt, $today)
              {
                  if ($targetDate < $today) {
                      return ['btn-danger', 'Date Passed', true];
                  } elseif ($updatedAt) {
                      return ['btn-primary', 'Updated', true];
                  } else {
                      return ['btn-outline-primary', 'Update', false];
                  }
              }
          ?>
        <?php list($class25, $label25, $disabled25) = getFollowupButton($po->followup_25_target_date, $po->followup_25_updated_at, $today); ?>
        <?php list($class50, $label50, $disabled50) = getFollowupButton($po->followup_50_target_date, $po->followup_50_updated_at, $today); ?>
        <?php list($class80, $label80, $disabled80) = getFollowupButton($po->followup_80_target_date, $po->followup_80_updated_at, $today); ?>
        <?php list($class90, $label90, $disabled90) = getFollowupButton($po->followup_90_target_date, $po->followup_90_updated_at, $today); ?>

          <td class="text-center bg-warning-subtle">
              <button data-po="<?= $data->purchase_order ?>" data-percentage="25" class="updateBtn btn <?= $class25 ?>" <?= $disabled25 ? 'disabled' : '' ?>><?= $label25 ?></button>
          </td>
          <td class="text-center  bg-warning-subtle">
              <button data-po="<?= $data->purchase_order ?>" data-percentage="50" class="updateBtn btn <?= $class50 ?>" <?= $disabled50 ? 'disabled' : '' ?>><?= $label50 ?></button>
          </td>
          <td class="text-center  bg-warning-subtle">
              <button data-po="<?= $data->purchase_order ?>" data-percentage="80" class="updateBtn btn <?= $class80 ?>" <?= $disabled80 ? 'disabled' : '' ?>><?= $label80 ?></button>
          </td>
          <td class="text-center  bg-warning-subtle">
              <button data-po="<?= $data->purchase_order ?>" data-percentage="90" class="updateBtn btn <?= $class90 ?>" <?= $disabled90 ? 'disabled' : '' ?>><?= $label90 ?></button>
          </td>
        </tr> 
      <?php endif; ?>
      </table>
    
      
    </div>
  </div>
  <?php if($data->is_late) :  ?> 
    <h5 style="color: #004085;">ATAP, Inc – Delivery Status Request</h5>

    <p>Greetings,</p>

    <p>We are requesting a delivery update regarding a recent purchase order(s). Our records indicate that one or more line items are approaching their scheduled delivery date, and we would appreciate your confirmation on the current status.</p>



    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
      <thead style="background-color: #f2f2f2;">
        <tr>
          <th align="center">PO #</th>
          <th align="center">Line</th>
          <th align="center">Order Date</th>
          <th align="center">Promise Date</th>
          <th align="center">Part #</th>
          <th align="left">Description</th>
          <th align="right">Ordered</th>
          <th align="right">Received</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data->lines as $item): ?>
          <?php $item = (object) $item ?>
          <tr>
            <td align="center"><?= esc($item->id) ?></td>
            <td align="center"><?= esc($item->line_no) ?></td>
            <td align="center"><?= esc( (new DateTime( $item->order_date ))->format('m/d/Y') ) ?></td>
            <td align="center"><?= esc( (new DateTime( $item->line_promise_date ))->format('m/d/Y') ) ?></td>
            <td align="center"><?= esc($item->part_id) ?></td>
            <td><?= esc($item->description) ?></td>
            <td align="right"><?= esc($item->order_qty) ?></td>
            <td align="right"><?= esc($item->received_qty) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      </table>

    <p>Please review the information we have provided and respond with an update indicating when the item(s) will be delivered to our facilities.</p>
    <p>If there are multiple delivery dates scheduled, please reference the line number, part number, and nomenclature from our purchase order when replying.</p>

    <p><strong>We encourage all our vendors to meet a 90% on-time delivery target.</strong><br>
    As of <?= esc($data->todays_date) ?> your on-time delivery percentage is <strong><?= esc( ( $data->performance ) ?? '' ) ?>%</strong>.</p>

    <p style="margin-top: 30px;">Thank you,<br>
    ATAP, Inc. Purchasing Department</p>


    <form action="<?= base_url( "vendor/send_email/$data->id/$data->purchase_order" ) ?>">
    <label for="from">From:</label>
    <input type="form-control" type="email" name="email" style="border-radius: 10px; padding: .5em; width: 20rem; border-color:#DCDCDC " value="<?=  auth()->user()->email; ?>">
    <button style="background-color: #42699b; color: white; padding: .5em; border-radius: 10px; width: 100px" type="submit" > Send Email </button>
    </form>

  <?php else : ?>
    <p>As of <?= esc($data->todays_date) ?> <span class="fw-bold"><?= $data->name ?></span> on-time delivery percentage is <strong><?= esc( ( $data->performance ) ?? '' ) ?>%</strong>.</p>
    <p>Purchase Order : <span class="fw-bold"><?= $data->purchase_order ?></span> currently in on time.</p>
    <div class="alert alert-success">
      <h5 style="color: #004085;">Order Lines On Time</h5>
      <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
      <thead style="background-color: #f2f2f2;">
        <tr>
          <th align="center">PO #</th>
          <th align="center">Line</th>
          <th align="center">Order Date</th>
          <th align="center">Promise Date</th>
          <th align="center">Part #</th>
          <th align="left">Description</th>
          <th align="right">Ordered</th>
          <th align="right">Received</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data->lines as $item): ?>
          <?php $item = (object) $item ?>
          <tr class="pb-3" >
            <td align="center"><?= esc($item->id) ?></td>
            <td align="center"><?= esc($item->line_no) ?></td>
            <td align="center"><?= esc( (new DateTime( $item->order_date ))->format('m/d/Y') ) ?></td>
            <td align="center"><?= esc( (new DateTime( $item->line_promise_date ))->format('m/d/Y') ) ?></td>
            <td align="center"><?= esc($item->part_id) ?></td>
            <td><?= esc($item->description) ?></td>
            <td align="right"><?= esc($item->order_qty) ?></td>
            <td align="right"><?= esc($item->received_qty) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>

  <?php endif; ?>

<?php else: ?>
<div class="alert alert-info d-flex justify-content-center align-items-center">
  <h5 class="h5">No trackable parts found on this PO — some vendors like Amazon may not list part numbers.</h5>
</div>
<?php endif; ?>

<script>
  $(document).ready(function(){
    $('.updateBtn').on('click', function(){
      btn = $(this); 
      po = btn.data('po'); 
      percentage = btn.data('percentage'); 
      btn.attr('disabled', true); 
      btn.removeClass('btn-outline-primary').addClass('btn-primary').html('Updated'); 
      url = "<?= base_url('purchasing/updatestatus/') ?>" + po + '/' + percentage; 
      console.log( url) ;
      $.get(url, function(response){
        console.log(response); 
      })
    }); 
  })
</script>