<div class="row">
    <div class="col">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer ID</th>
                    <th>Sales Rep</th>
                    <th>Order Date</th>
                    <th>Desired Date</th>
                    <th>Total Amt.</th>
                </tr>
            </thead>
            <tbody>
                <?php if( $orders ) : ?>
                <?php foreach($orders as $row ) : ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->customer_id ?></td>
                    <td><?= $row->salesrep_id ?></td>
                    <td><?= $row->order_date ?></td>
                    <td><?= $row->desired_ship_date ?></td>
                    <td><?= $row->total_amt_ordered ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>