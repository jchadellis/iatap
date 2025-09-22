<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Group Access Request</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: auto; padding: 24px; background: #f9f9f9; border-radius: 8px; }
        .header { font-size: 20px; font-weight: bold; margin-bottom: 16px; }
        .details { margin-bottom: 16px; }
        .footer { font-size: 13px; color: #888; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Group Access Request</div>
        <div class="details">
        <p>
            Hello Admin,<br><br>
            I would like to request access to the following group(s): <strong><?= htmlspecialchars(ucwords($group)) ?></strong>.<br>
            My details are below:
        </p>
        <ul>
            <li><strong>Name:</strong> <?= htmlspecialchars($user->first_name . ' ' . $user->last_name ) ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></li>
        </ul>
        <p>
            Please let me know if you need any additional information.<br>
            Thank you for your assistance.
        </p>
        </div>
        <div class="footer">
            This is an automated message from the IATAP system.
        </div>
    </div>
</body>
</html>