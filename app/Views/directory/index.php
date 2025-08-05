<table class="table table-striped table-border">
    <thead>
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Extension</th>
            <th class="text-center">Department</th>
            <th class="text-center">Location</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($contacts as $c ) : ?>
        <tr>
            <td class="text-center"><?= $c->fname . '  ' . $c->lname ?></td>
            <td class="text-center"><?= $c->extension ?></td>
            <td class=""><?= $c->department ?></td>
            <td class="text-center"><?= $c->building ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>