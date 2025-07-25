<?php
    session_start();
?>
<!doctype html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ثبت نام</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <form class="login-box" method="post" action="check_insert.php">
        <lable>نام کاربری:</lable>
        <input type="text" name="username" required><br>
        <label>رمزعبور:</label>
        <input type="password" name="password" required><br>
        <div class="buttons">
            <button type="submit">ثبت</button>
            <button type="reset">لغو</button>
        </div>
        <br>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
    </form>
</body>
</html>
