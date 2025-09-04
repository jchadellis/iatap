<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>iATAP Account Information</title>
</head>
<body>
    <h2>iATAP Account</h2>
    
    <p>Hello <?= $data->first_name ?> <?= $data->last_name ?>,</p>
    
    <p>Your account information is provided below. Please find your login credentials:</p>

    <p>Click <a href="http://connectportal/login">here</a> to login. </p>
    
    <div style="padding: 15px; border-radius: 5px; margin: 20px 0;">
        <strong>Username:</strong> <?= $data->email ?> <br>
        <strong>Password:</strong> <?= $password ?>
    </div>
    
    <p>Please keep this information secure.</p>
    
    <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>
    
    <p>ATAP IT Dept.</p>
</body>
</html>