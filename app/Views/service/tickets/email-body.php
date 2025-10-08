<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ticket Notification</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">
  <!-- Container -->
  <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f4f6f8;padding:24px 12px;">
    <tr>
      <td align="center">
        <!-- Email Card -->
        <table role="presentation" cellpadding="0" cellspacing="0" width="800" style="max-width:600px;background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 18px rgba(15,23,42,0.06);">
          
          <!-- Header -->
          <tr>
            <td style="padding:20px 24px;background: #3b82f6 ;color:#fff;">
              <h1 style="margin:0;font-size:20px;font-weight:600;">New Ticket: <?= $ticket->title ?? ''  ?></h1>
              <p style="margin:6px 0 0;font-size:13px;opacity:0.95;">A ticket was submitted — details below.</p>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:20px 24px;color:#0f172a;">
              <!-- Summary row -->
              <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:14px;">
                <tr>
                  <td style="vertical-align:top;padding-right:12px;">
                    <strong style="display:block;font-size:13px;color:#334155;margin-bottom:6px;">Priority</strong>
                    <div style="display:inline-block;padding:6px 10px;border-radius:6px;background:#f1f5f9;font-size:13px;color:#0f172a;"><?= $ticket->priority ?? '' ?></div>
                  </td>
                  <td style="vertical-align:top;">
                    <strong style="display:block;font-size:13px;color:#334155;margin-bottom:6px;">Submitted by</strong>
                    <div style="font-size:13px;color:#0f172a;"><?= $user->first_name ? $user->first_name : $ticket->first_name ?> <?= $user->last_name ? $user->last_name : $ticket->last_name ?></div>
                    <div style="font-size:13px;color:#475569;margin-top:6px;">Email: <a href="mailto:$email" style="color:#3b82f6;text-decoration:none;"><?= $user->email ? $user->email : $ticket->email ?></a></div>
                  </td>
                  <td style="vertical-align:top;">
                    <strong style="display:block;font-size:13px;color:#334155;margin-bottom:6px;">Department</strong>
                    <div style="display:inline-block;padding:6px 10px;border-radius:6px;background:#f1f5f9;font-size:13px;color:#0f172a;"><?= $ticket->dept->name ?? '' ?></div>
                  </td>
                </tr>
              </table>

              <!-- Description -->
              <section style="margin-bottom:14px;">
                <strong style="display:block;font-size:13px;color:#334155;margin-bottom:8px;">Description</strong>
                <div style="font-size:14px;line-height:1.5;color:#0f172a;padding:12px;border-radius:6px;background:#fbfcfd;border:1px solid #eef2f7;"><?= $ticket->description ?? '' ?></div>
              </section>

              <!-- Message -->
              <section style="margin-bottom:18px;">
                <strong style="display:block;font-size:13px;color:#334155;margin-bottom:8px;">Message</strong>
                <div style="font-size:14px;line-height:1.6;color:#0f172a;padding:12px;border-radius:6px;background:#ffffff;border:1px solid #f1f5f9;"><?= $message ?? '' ?></div>
              </section>

              <!-- CTA -->
              <div style="text-align:left;margin-top:6px;">
                <a href="<?= base_url( $route ) ?>" style="display:inline-block;padding:12px 18px;border-radius:8px;background:#0ea5a3;color:#ffffff;text-decoration:none;font-weight:600;font-size:14px;">
                  View Ticket Request
                </a>
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:14px 24px;background:#f8fafc;color:#64748b;font-size:12px;">
              <div style="margin-bottom:6px;">Ticket: <strong><?= $ticket->title ?? '' ?></strong></div>
              <div style="color:#94a3b8;">If you did not expect this message, please contact your IT support.</div>
            </td>
          </tr>
        </table>
        <!-- /Email Card -->
      </td>
    </tr>
  </table>
</body>
</html>
