<table class="table table-striped table-border">
    <thead>
        <tr>
            <th>Truck Num</th>
            <th>Part Num</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($trucks as $row) : ?>
        <tr data-id="<?= $row->id ?>">
            <td><?= $row->base_id ?></td>
            <td><?= $row->part_id ?></td>
            <td><?= $row->description ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>