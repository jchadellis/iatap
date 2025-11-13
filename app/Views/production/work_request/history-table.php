<table class="table mt-1 table-sm">
<?php foreach($history as $update): ?>
    <tr class="table-info">
        <th>Updated :</th>
        <td><?= (new \DateTime($update->created_at))->format('Y-m-d') ?></td>
        <th>Updated By:</th>
        <td class="text-start"><a class="text-decoration-none text-dark" href="mailto:<?=$update->user_email ?>?subject=<?= urldecode('Work Request Info:'.$update->work_request_id) ?>"><?= $update->user_name ?></a></td>
    </tr>
    <tr>
        <td colspan="4">
            <table class="table table-sm">
                <tr>
                    <th class="text-center">Field</th>
                    <th class="text-center">Old Value</th>
                    <th class="text-center">New Value</th>
                </tr>
                <?php foreach( $update->updated_fields as $field ) : ?>
                <tr>
                    <td class="text-center">
                        <span><?= $field->field_name ?></span>
                    </td>
                    <td class="text-center">
                        <span class=""><?= $field->old_value ?></span>
                    </td>
                    <td class="text-center">
                        <span class=""><?= $field->new_value ?></span> 
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </td>
    </tr>
    
<?php endforeach; ?>
</table>