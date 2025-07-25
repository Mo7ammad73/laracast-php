
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
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ورود</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <form action="check-login.php" method="POST">
        <label>نام کاربری:</label>
        <input type="text" name="username" autocomplete="off" required>

        <label>رمزعبور:</label>
        <input type="password" name="password" autocomplete="off" required>

        <div class="buttons">
            <button type="submit">ورود</button>
            <a href="../create.php"><button type="button">ثبت‌نام</button></a>
        </div>
    </form>
</div>
</body>
</html>
```

---

## فایل `check-login.php`

```php
<?php
session_start();
require_once "../database.php";
$config = require_once "../config.php";
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $db->query("SELECT * FROM users WHERE username = :u AND password = :p", [
        ':u' => $username,
        ':p' => $password
    ])->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user['username'];
        header("Location: ../dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "نام کاربری یا رمز عبور اشتباه است.";
        header("Location: login.php");
        exit;
    }
}
```

---

## فایل `create.php`

```php
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <form action="check-insert.php" method="POST">
        <label>نام کاربری:</label>
        <input type="text" name="username" autocomplete="off" required>

        <label>رمزعبور:</label>
        <input type="password" name="password" autocomplete="off" required>

        <div class="buttons">
            <button type="submit">ثبت‌نام</button>
        </div>
    </form>
</div>
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $exist = $db->query("SELECT * FROM users WHERE username = :u", [':u' => $username])->fetch(PDO::FETCH_ASSOC);

    if ($exist) {
        $_SESSION['error'] = "این نام کاربری قبلاً ثبت شده است.";
        header("Location: create.php");
        exit;
    }

    $db->query("INSERT INTO users (username, password) VALUES (:u, :p)", [
        ':u' => $username,
        ':p' => $password
    ]);

    $_SESSION['user'] = $username;
    header("Location: dashboard.php");
    exit;
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
if (!isset($_SESSION['user'])) {
    header("Location: login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>داشبورد</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>خوش آمدید، <?= htmlspecialchars($_SESSION['user']) ?></h2>
    <a href="logout.php"><button>خروج</button></a>
</div>
</body>
</html>
```

---

## نکات پایانی

- برای جلوگیری از پر شدن خودکار فیلدها توسط مرورگر، از `autocomplete="off"` استفاده شده.
- از فونت فارسی دلخواه مثل Vazir یا وزیرمتن استفاده شده است.
- با استفاده از Flexbox در CSS تمام فرم و دکمه‌ها در وسط صفحه قرار گرفته‌اند.
