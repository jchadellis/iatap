<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Purchase Order Delivery Request</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; padding: 20px;">

    <?php if( isset($data) ) : ?>
    <?php 
        $vendor_id = $data[0][0]->id;
        $vendor_name = $data[0][0]->name;  
        $percent = $data[0][0]->performance['on_time_percentage']; 
        $start_date = $data[0][0]->performance['start_date'];
        $end_date = $data[0][0]->performance['end_date'];
        $color = $data[0][0]->po_status_color; 
        $today = new \DateTime(); 
    ?>

    <?= $start_message ?? '' ?>

    <?php foreach($data as $po ) : ?>

        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;  margin-bottom: 15px;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th colspan="5">Purchase Order Number : <?= $po[0]->purchase_order ?> / Promise Date: <?= (isset($po[0]->effective_promise)) ? $po[0]->effective_promise : 'N/A' ?></th>
                </tr>
                <tr>
                    <th>Line No.</th>
                    <th>Part Number</th>
                    <th>Description</th>
                    <th>Ordered</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($po[0]->lines as $line ): ?>
                <tr class="<?= $line['status_color'] ?>">
                    <td><?= $line['line_no'] ?></td>
                    <td><?= $line['part_id'] ?></td>
                    <td><?= $line['description'] ?></td>
                    <td><?= $line['user_order_qty'] ?></td>
                    <td><?= $line['user_received_qty'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>&nbsp;</p>

    <?php endforeach; ?>
    <?php endif; ?>

    <?= $end_message ?? '' ?>

</body>
</html>
