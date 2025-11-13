<pre>
  <?php //print_array($request); return; ?>
</pre>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Work Request Notification</title>
</head>




<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;font-size:14px">
  <!-- Container -->
  <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f4f6f8;padding:24px 12px;">
    <tr>
      <td align="center">
        <!-- Email Card -->
        <table role="presentation" cellpadding="0" cellspacing="0" width="800" style="max-width:800px;background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 18px rgba(15,23,42,0.06);">
          
          <!-- Header -->
          <tr>
            <td style="padding:20px 24px;background: #3b82f6 ;color:#fff;">
              <h1 style="margin:0;font-size:20px;font-weight:600;"><?= $request->title ?? ''  ?></h1>
              <p style="margin:6px 0 0;opacity:0.95;"><?= $request->demand_type ?? '' ?> <?= $request->demand_id ? ' - '.$request->demand_id : '' ?> </p>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:20px 24px;color:#0f172a;">
              <!-- Summary row -->
              <table role="presentation" cellpadding="1" cellspacing="1" width="100%" style="margin-bottom:14px;">
                <tr>
                  <th style="width:10%; text-align:left;">Status:</th>
                  <td colspan="4"><?= $request->status_badge ?? '' ?></td>
                </tr>
              </table>
              <table role="presentation" cellpadding="1" cellspacing="1" width="100%" style="margin-bottom:14px;">
                <tr>
                  <td style="vertical-align:top;">
                    <strong style="display:block;color:#334155;margin-bottom:6px;">Submitted by</strong>
                    <div style=;color:#0f172a;"><?= $request->created_by_name ?? '' ?></div>
                    <div style=;color:#475569;margin-top:6px;">Email: <a href="mailto:<?= $request->created_by_email ?? '' ?>?subject=<?= urlencode('Work Request Information Request #'.$request->id) ?>" style="color:#3b82f6;text-decoration:none;"><?= $request->created_by_email ?? '' ?></a></div>
                  </td>
                  <?php if( !is_null($request->updated_by_id)) : ?>
                  <td style="vertical-align:top;">
                    <strong style="display:block;color:#334155;margin-bottom:6px;">Updated by</strong>
                    <div style=;color:#0f172a;"><?= $request->updated_by_name ?? '' ?></div>
                    <div style=;color:#475569;margin-top:6px;">Email: <a href="mailto:<?= $request->updated_by_email ?? '' ?>?subject=<?= urlencode('Work Request Information Request #'.$request->id) ?>" style="color:#3b82f6;text-decoration:none;"><?= $request->updated_by_email ?? '' ?></a></div>
                  </td>
                  <?php endif; ?>
                </tr>
              </table>

              <?php if( $request->work_order !== '' ) : ?>
              <table role="presentation" cellpadding="1" cellspacing="1" width="100%" style="margin-bottom:14px;;">
                <tr>
                  <th style="width:15%;">Work Order</th>
                  <td style="vertical-align:top; width:25%;">
                    <div style="display:inline-block;padding:6px 10px;border-radius:6px;background:#f1f5f9;color:#0f172a;"> <?= $request->work_order ?? '' ?></div>
                  </td>
                  <th style="width:15%;">Demand Type</th>
                  <td style="vertical-align:top; width:45%;">
                    <div style="display:inline-block;padding:6px 10px;border-radius:6px;background:#f1f5f9;color:#0f172a;"> <?= $request->demand_type_id == 2 ? "Customer Order: ". $request->demand_id : $request->demand_type ?> </div>
                  </td>
                </tr>
              </table>
              <?php else: ?>
              <table role="presentation" cellpadding="1" cellspacing="1" width="100%" style="margin-bottom:14px;">
                <tr>
                  <th style="width:15%;">Demand Type</th>
                  <td style="vertical-align:top; width:45%;">
                    <div style="display:inline-block;margin-left: 8px;padding:6px 10px;border-radius:6px;background:#f1f5f9;color:#0f172a;"> <?= $request->demand_type_id == 2 ? "Customer Order: ". $request->demand_id : $request->demand_type ?> </div>
                  </td>
                  <th></th>
                  <td></td>
                </tr>
              </table>
              <?php endif; ?>
 
              <hr style="border:1px solid #ecececff;">
              <table role="presentation" cellpadding="1" cellspacing="1" width="100%" style="margin-bottom:18px; margin-top:10px;">
                <tr>
                  <th style="text-align:left;">CONTRACT:</th>
                  <td><?= $request->contract_no ?? '' ?></td>
                  <th style="text-align:left;">DUE DATE:</th>
                  <td><?= isset($request->want_date) ? date('Y-m-d', strtotime($request->want_date)) : '' ?></td>
                </tr>
                <tr>
                  <th style="text-align:left;">END USER:</th>
                  <td><?= $request->end_user ?? '' ?></td>
                  <th  style="text-align:left;">INSPECTION LEVEL</th>
                  <td><?= $request->inspection_level ?? '' ?></td>
                </tr>
                <tr>
                  <th style="text-align:left;">QAR SIGNOFF</th>
                  <td><?= isset($request->qar_signoff)
                    ? ($request->qar_signoff === 't' ? 'YES' : 'NO')
                    : '' ?></td>    
                  <th style="text-align:left;">DPAS RATING</th>
                  <td><?= $request->dpas_rating ?? '' ?></td>
             
                </tr>
                <tr>
                  <th style="text-align:left;">COC REQURIED</th>
                  <td>
                    <?= isset($request->coc_required)
                    ? ($request->coc_required === 't' ? 'YES' : 'NO')
                    : '' ?>
                  </td>
                </tr>
              </table>

              <!-- Description -->
              <section style="margin-bottom:14px;">
                <strong style="display:block;color:#334155;margin-bottom:8px;">Notes</strong>
                <div style=;line-height:1.5;color:#0f172a;padding:12px;border-radius:6px;background:#fbfcfd;border:1px solid #eef2f7;"><?= $request->notes ?></div>
              </section>

              <!-- Message -->
              <!-- <section style="margin-bottom:18px;">
                <strong style="display:block;font-size:13px;color:#334155;margin-bottom:8px;">Message</strong>
                <div style=;line-height:1.6;color:#0f172a;padding:12px;border-radius:6px;background:#ffffff;border:1px solid #f1f5f9;"></div>
              </section> -->

              <!-- CTA -->
              <div style="text-align:center;margin-top:6px;">
                <a href="<?= base_url( 'production/work-request/view/'.$request->id ?? '' ) ?>" style="display:inline-block;padding:12px 18px;border-radius:8px;background:#0ea5a3;color:#ffffff;text-decoration:none;font-weight:600;">
                  View Work Request
                </a>
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <?php if(true) : ?> 
          <tr>
            <td style="padding:14px 24px;color: #666666ff;font-size:12px;">
              <div style="margin-bottom:6px;"><strong>History: </strong></div>
              <div style="">
                  <table style="width:100%; border-collapse:collapse; margin-top:0.25rem; font-size:0.875rem;">
                  <?php foreach($request->history as $update): ?>
                      <tr style="background-color: #e3f7fcff; border-top:1px solid #dee2e6;">
                          <th style="padding:0.25rem; text-align:left; width:15%;">Updated :</th>
                          <td style="padding:0.25rem; width:25%;"><?= (new \DateTime($update->created_at))->format('Y-m-d') ?></td>
                          <th style="padding:0.25rem; text-align:left; width:15%;">Updated By:</th>
                          <td style="padding:0.25rem; text-align:left; width:25%;">
                              <a href="mailto:<?=$update->user_email ?>?subject=<?= urldecode('Work Request Info:'.$update->work_request_id) ?>"
                                style="text-decoration:none; color:#212529;">
                                <?= $update->user_name ?>
                              </a>
                          </td>
                      </tr>
                      <tr style="border-top:1px solid #dee2e6;">
                          <td colspan="4" style="padding:0.25rem;">
                              <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                                  <tr>
                                      <th style="padding:0.25rem; text-align:center; border-bottom:1px solid #dee2e6;">Field</th>
                                      <th style="padding:0.25rem; text-align:center; border-bottom:1px solid #dee2e6;">Old Value</th>
                                      <th style="padding:0.25rem; text-align:center; border-bottom:1px solid #dee2e6;">New Value</th>
                                  </tr>
                                  <?php foreach( $update->updated_fields as $field ) : ?>
                                  <tr style="border-top:1px solid #dee2e6;">
                                      <td style="padding:0.25rem; text-align:center;">
                                          <span><?= $field->field_name ?></span>
                                      </td>
                                      <td style="padding:0.25rem; text-align:center;">
                                          <span><?= $field->old_value ?></span>
                                      </td>
                                      <td style="padding:0.25rem; text-align:center;">
                                          <span><?= $field->new_value ?></span>
                                      </td>
                                  </tr>
                                  <?php endforeach; ?>
                              </table>
                          </td>
                      </tr>
                  <?php endforeach; ?>
                  </table>
              </div>
            </td>
          </tr>
          <?php endif; ?>
        </table>
        <!-- /Email Card -->
      </td>
    </tr>
  </table>
</body>
</html>
