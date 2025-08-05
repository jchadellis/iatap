<!-- <div class="row">
    <div class="col m-2 text-center"><h4 class="h4" >Weather / Upcoming / Goals</h4></div>
</div> -->
<div class="row mt-2">
    <div class="grid gap-0 row-gap-3">
    <div class="p-2 g-col-12">
        <?= view_cell('App\Cells\SideCards\WeatherCell') ?>
    </div>
    <div class="p-2 g-col-12">
        <?= view_cell('App\Cells\SideCards\UpcomingEventsCell') ?>
    </div>
    <!-- <div class="p-2 g-col-12">
        <?= view_cell('App\Cells\SideCards\OnTimeDeliveryCell') ?>
    </div>
    <div class="p-2 g-col-12">
        <?= view_cell('App\Cells\SideCards\MonthlyGoalsCell') ?>
    </div> -->
</div>
</div>