
# پروژه ورود و ثبت‌نام ساده با PHP

این پروژه یک سیستم ساده‌ی مدیریت کاربران است که شامل امکانات زیر می‌باشد:

- صفحه ورود (login.php)
- بررسی اطلاعات ورود (check-login.php)
- صفحه ثبت‌نام (create.php)
- بررسی و ثبت اطلاعات در دیتابیس (check-insert.php)
- خروج از حساب کاربری (logout.php)
- داشبورد پس از ورود موفق (dashboard.php)
- فایل CSS برای زیباسازی صفحات (style.css)

---

## فایل `style.css`

```css
body {
    background: linear-gradient(to right, #a8edea, #fed6e3);
    font-family: 'Vazir', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.container {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    text-align: right;
}
input {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
    margin-bottom: 20px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
.buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}
button {
    width: 120px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    font-family: 'Vazir', Arial;
}
```

---

## فایل `login.php`

```php
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

```

---

## فایل `check-login.php`

```php
<?php
    session_start();
    require_once "database.php";
    $config = require_once "config.php";
    $db = new Database($config["database"]);
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $username = isset($_POST["username"]) ? $_POST["username"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
    }
    $statement = $db->query("select * from users where username= :u and  password= :p",["u"=>$username,"p"=>$password]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user){
        $_SESSION["user"] = $username;
        header("location:dashbord.php");
        exit;
    }else{
        $_SESSION["error"]= "نام کاربری یا رمز عبور اشتباه هست";
        header("location:login.php");
        exit;
    }

```

---

## فایل `create.php`

```php

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

```

---

## فایل `check-insert.php`

```php
<?php
    session_start();
    require_once "database.php";
    $config = require_once "config.php";
    $db = new Database($config['database']);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $statement = $db->query("SELECT * FROM users WHERE username = :u", [':u' => $username])->fetch(pdo::FETCH_ASSOC);
        if($statement) {
            $_SESSION['error'] = "این نام کاربری قبلا ثبت نام کرده";
            header("location:create.php");
            exit;
        }else{
            $db->query("INSERT INTO users (username, password) VALUES (:u, :p)", [':u' => $username, ':p' => $password]);
            $_SESSION['user'] = $username;
            header("location:dashbord.php");
            exit;
        }
    }


```

---

## فایل `logout.php`

```php
    <?php
    session_start();
    session_destroy();
    header("Location: login/login.php");
    exit;
```

---

## فایل `dashboard.php`

```php
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


```

---

## نکات پایانی

- برای جلوگیری از پر شدن خودکار فیلدها توسط مرورگر، از `autocomplete="off"` استفاده شده.
- از فونت فارسی دلخواه مثل Vazir یا وزیرمتن استفاده شده است.
- با استفاده از Flexbox در CSS تمام فرم و دکمه‌ها در وسط صفحه قرار گرفته‌اند.
