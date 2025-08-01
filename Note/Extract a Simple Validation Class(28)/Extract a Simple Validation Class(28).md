<div dir="rtl">
همان طور که در جلسه قبل قصد معتبر کردن فرم افزودن یادداشت رو داشتیم مثلا جعبه متن خالی نباشه یا بیش از یه مقداری نباشه تو این جلسه همه ی این چک کردن ها رو داخل یک کلاس به نام validator تعریف میکنیم سپس از این کلاس داخل صفحه افزودن یادداشت برای بررسی معتبر بودن استفاده میکنیم.
پس 3 تا عمل معتبر سازی را داخل کلاس مینویسم .

# خالی بودن جعبه متن
<div dir="ltr">

```php
    public function Is_Empty($value){
        return strlen(trim($value)) == 0;
    }
```
<div dir="rtl">

# تعداد کاراکتر مشخص یادداشت
<div dir="ltr">

```php
     public static function Count_Char($value , $min=1 , $max=INF){
        return strlen(trim($value)) >= $min && strlen(trim($value)) <= $max;
     }   
```
<div dir="rtl">

# معتبر بودن ایمیل

<div dir="ltr">

```php
    public static function Validate_email($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
```
# validator.php

```php
<?php
    class Validator {
        public function Is_Empty($value){
            return strlen(trim($value)) == 0;
        }
        public static function Count_Char($value , $min=1 , $max=INF){
            return strlen(trim($value)) >= $min && strlen(trim($value)) <= $max;
        }
        public static function Validate_email($value){
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }
    }
```
<div dir="rtl">
حالا در فایل note_create.php  کد فرم را به صورت زیر مینویسیم:

<div dir="ltr">

```php
<?php
    $config = require_once 'config.php';
    require_once "Database.php";
    require_once "validator.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error =[];
        $validator = new Validator();
        if($validator->Is_Empty($_POST['body'])){
            $error["body"] = "Body is required";
        }
        if(validator::Count_Char($_POST["body"],1,1000)){
            $error["body"] = "body is too long ";
        }

        if(empty($error)){
            $db = new Database($config['database']);
            $db->query("INSERT INTO notes (body,user_id) VALUES (:body ,:user_id)" , ['body' => $_POST['body'], 'user_id' => 3 ]);
        }
    }

    require_once "views/create.view.php";
```
<div dir="rtl">
نکته ی مهمی که تو این جلسه گفته شد این بود که متد را به صورت static تعریف کنیم و بعد با نام متد:: نام کلاس پروژه بدون ایجاد یک شی از کلاس استفاده کنیم.