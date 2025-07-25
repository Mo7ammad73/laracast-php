<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:login.php");
        exit;
    }
    ?>
<!doctype html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>صفحه اصلی</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>سلام<?=htmlspecialchars($_SESSION["user"]) ?></h2>
    <a href="login.php">خروج</a>
</body>
</html>

