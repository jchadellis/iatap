<pre>
    <?php print_r($truck) ?>
</pre>

<div class="row">
    <div class="col-4 fw-bold">Workorder Number</div>
    <div class="col-4 fw-bold">Part ID</div>
    <div class="col-4 fw-bold">Description</div>
</div>
<div class="row">
    <div class="col-4"><?= $truck->base_id ?></div>
    <div class="col-4"><?= $truck->part_id ?></div>
    <div class="col-4"><?= $truck->description ?></div>
</div>
<div class="row">
    <div class="col-4 fw-bold">Created Date</div>
    <div class="col-4 fw-bold">Promise Date</div>
    <div class="col-4 fw-bold">Want Date</div>
</div>
<div class="row">
    <div class="col-4"><?= (($truck->created_date) ?? false ) ? (new \DateTime($truck->created_date))->format('m-d-Y') : '' ?></div>
    <div class="col-4"><?= (($truck->promise_date) ?? false ) ? (new \DateTime($truck->promise_date))->format('m-d-Y') : '' ?></div>
    <div class="col-4"><?= (($truck->want_date) ?? false ) ? (new \DateTime($truck->want_date))->format('m-d-Y') : '' ?></div>
</div>