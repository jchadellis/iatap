
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Purchase Order Confirmation Request</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; padding: 20px;">
  <h2 style="color: #004085;">ATAP, Inc –  Purchase Order Confirmation Request</h2>

    <p>Greetings,</p>

    <p>Our records indicate that the following purchase order includes one or more line items that remain unconfirmed:</p>

    <p><b>Purchase Order:</b> <?= $data->purchase_order ?> </p>

    <p><b>Promised Delivery date:</b> <?= ( new DateTime($data->promise_date))->format('m-d-Y') ?></p>

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

  <p>Please review the information provided and respond so we may update our records accordingly.</p>
  <p>If there are multiple delivery dates scheduled, please reference the line number, part number, and nomenclature from our purchase order when replying.</p>

  <p><strong>We encourage all our vendors to meet a 90% on-time delivery target.</strong></p>
  <p>Your current on-time delivery percentage is:  <b><?=$data->performance['metric'] ?>%</b> for the period of <b> <?= ( new \DateTime($data->performance['start_date'] ))->format('m-d-Y') ?> - <?= ( new \DateTime($data->performance['end_date'] ))->format('m-d-Y') ?></b></p>
  <p>We kindly ask you to confirm that:</p>

  <ul>
    <li>You have received the purchase order</li>
    <li>You accept the terms and conditions</li>
    <li>You are able to meet the stated delivery date</li>
  </ul>

  <p style="margin-top: 30px;">If revisions are necessary, please indicate the affected line number(s), part number(s), and description(s) in your response.,<br>
  Thank you for your prompt attention to this request.</p>

  <p style="margin-top: 30px"><b>ATAP, inc. Purchase Dept.</b><br>P: 256-362-2221<br>F: 256-362-2220<br>130 Industry Way <br>Eastaboga, AL 36260</p>

</body>
</html>
