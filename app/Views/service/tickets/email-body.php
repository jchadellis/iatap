<?php
/**
 * @var string $message
 * @var object $user
 */
?>
<div style="font-family: Arial, sans-serif; color:#333; line-height:1.5;">

  <h4 style="color:#2c3e50; margin-bottom:0.5em;">
    <?= strtoupper($ticket->title) ?>
  </h4>

  <p style="margin:0 0 1em 0; font-size:14px;">
    <strong>Description:</strong><br>
    <?= nl2br($ticket->description) ?>
  </p>

  <p style="margin:0 0 1em 0; font-size:14px;">
    <strong>Priority:</strong>
    <span style="color:<?= $ticket->priority === 'High' ? 'red' : ($ticket->priority === 'Medium' ? '#e67e22' : 'green') ?>;">
      <?= ucfirst($ticket->priority) ?>
    </span>
  </p>

  <?php if (!empty($message)): ?>
  <p style="margin:0 0 1em 0; font-size:14px;">
    <strong>Message:</strong><br>
    <?= esc($message) ?>
  </p>
  <?php endif; ?>

  <p style="margin:0 0 1em 0; font-size:14px;">
    <strong>Submitted by:</strong><br>
    <?= esc($ticket->first_name) ?> <?= esc($ticket->last_name) ?><br>
    <a href="mailto:<?= esc($ticket->email) ?>" style="color:#2980b9; text-decoration:none;">
      <?= esc($ticket->email) ?>
    </a>
  </p>

  <p style="margin-top:2em;">
    <a href="<?= base_url($route) ?>" 
       style="background:#2980b9; color:#fff; padding:10px 16px; text-decoration:none; border-radius:5px;">
      View Ticket Request
    </a>
  </p>

</div>
