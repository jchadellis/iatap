<table class="table table-warning table-stripped table-bordered">
    <thead>
        <tr>
            <th class="text-center">PO#</th>
            <th class="text-center">Line</th>
            <th class="text-center">Part</th>
            <th class="text-center">Promise</th>
            <th class="text-center">Delivery</th>
            <th class="text-center">On Time</th>
            <th class="text-center">Early/Late</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($lines as $line) : ?>
        <tr>
            <td class="text-center"><?= $line->purchase_id ?></td>
            <td class="text-center"><?= $line->line_no ?></td>
            <td><?= $line->part_id ?></td>
            <td class="text-center"><?= $line->line_promise_date ?? $line->order_promise_date ?></td>
            <td class="text-center"><?= $line->last_received_date ?? '' ?></td>
            <td class="text-center"><?= $line->on_time ? 'Y' : 'N' ?></td>
            <td class="text-center"><?= $line->message ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>