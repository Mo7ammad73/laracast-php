<?php
    session_start();
?>
<!doctype html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>صفحه ورود</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form class="login-box" method="post" action="checklogin.php" autocomplete="off">
        <lable>نام کاربری:</lable>
        <input type="text" name="username" required><br>
        <label>رمزعبور:</label>
        <input type="password" name="password" required><br>
        <div class="buttons">
            <button type="submit">ورود</button>
            <button type=button onclick="window.location.href='create.php'">ثبت نام</button>
        </div>
        <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
        ?>
    </form>
</body>
</html>
