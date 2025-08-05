<div class="row">
    <div class="col-12">
        <table class="table table-border table-striped">
            <thead>
                <tr>
                    <th class="text-center">Page</th>
                    <th class="text-center">Total Visits</th>
                    <th class="text-center">Top User</th>
                    <th class="text-center">Last Accessed</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row ) : ?>
                <tr>
                    <td class="text-start"><a href="<?= $row['pageUrl'] ?>"><?= $row['page'] ?></a></td>
                    <td class="text-center"><?= $row['count'] ?></td>
                    <td class="text-center"><?= $row['userName'] ?></td>
                    <td class="text-center"><?= $row['lastAccess'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>