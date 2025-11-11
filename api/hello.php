<?php

date_default_timezone_set('Asia/Ho_Chi_Minh'); 

$welcome_message = "Chào mừng đến với ứng dụng Nhà Thuốc An Tâm!";
$current_time = date("H:i:s, d/m/Y");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello An Tâm</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; background-color: #f4f4f4; }
        .container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); display: inline-block; }
        h1 { color: #004aad; }
        p { color: #555; font-size: 16px; }
        .time { font-weight: bold; color: #d9534f; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $welcome_message ?></h1>
        <p>Hôm nay là ngày: <span class="time"><?= $current_time ?></span></p>
        <p>Tệp này nằm trong thư mục gốc của dự án.</p>
    </div>
</body>
</html>