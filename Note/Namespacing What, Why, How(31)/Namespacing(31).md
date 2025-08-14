<div dir="rtl">
در این جلسه یک namespace با نام core در ابتدای فایل های Database.php,validator.php,response.php اضافه کرده حالا در هر کجای پروژه که از این کلاس ها استفاده میشود باید عبارت use core را در ابتدای ان صفحات زد.فقط وقتی در صفحه ای عبارت use core را میزنیم اگه از کلاس های داخلی php در ان صفحه استفاده کنیم برای آن کلاس خطا رخ میده که بهتره قبل از نام کلاس از \forward slash استفاده کنیم.
<div dir="ltr">

# Database.php
<div dir="rtl">
اضافه کردن کد تعریف فضای نام در ابتدای فایل
<div dir="ltr">

```php
namespace core;
    use PDO;
    class Database {
        public $connection;
        public $statement;
        public function __construct($config , $username="root", $password="")
        .
        .
        .
        ,بقیه کدها
```

# create.php

```php
<?php
use core\Database;
use core\Validator;
....
وبقیه کدها
```