<div dir="rtl">
در ابتدای این جلسه یک پوشه public  ایجاد کرده و فایل index.php و فایل .htaccess را داخل آن قرار میدهیم سپس به فایل .htaccess رفته و مسیر جاری را تغییر میدهیم:

<div dir="ltr">

```php
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /laracast-php/public#اینجا تغییر داده میشود

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
```
<div dir="rtl">
حالا در مرورگر با آدرس  http://localhost/laracast-php/public/ میتوان وارد سایت شد.
البته در این بخش برای تغییر ریشه سایت سرورداخلی php storm هم در خط فرمان دستور زیر نوشته شد:
<div dir="ltr">

```
php -S localhost:8888 -t public
```
<div dir="rtl">
در ستور بالا public نام پوشه جاری هست.
دستور __DIR__ اشاره به پوشه جاری داره اگه با دستور بالا کار کنیم این دستور خروجی بالا را میدهد اما به صورت عادی در هر فایلی نوشته شود آدرس آن فایل را میدهد که بهتر هست در فایل index.php موجود در پوشه public نوشته شود .

حالا با توجه به تغییر ریشه سایت ما ابتدا یک ثابت تعریف میکنیم سپس دو تابع تعریف کرده و با استفاده از این دو تابع فایل های خودمان را require میکنیم:
<div dir="ltr">

# index.php

```php
<?php

    const BASE_PATH = __DIR__ . '/../';
    echo BASE_PATH;//نمایش مسیر جاری
    echo '<br>';
    require_once BASE_PATH."function.php";
    spl_autoload_register(function ($class) {
        // مسیر فایل کلاس را بر اساس نام کلاس بساز
        $path = base_path("/core/"). $class . '.php';

        if (file_exists($path)) {
            require_once $path;
        }
    });

    $routes = require_once base_path('routes.php');
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];
    echo $url;//نمایش urlجاری

    if(array_key_exists($url,$routes)){

        require $routes[$url];
    }else
    {
            http_response_code(404);
            echo "404 - Page not found";
            exit;
        }

```
## spl_autoload_register:

<div dir="rtl">
توسط این دستور ما میگوییم که برای استفاده از فایلهای کلاس ها مثل کلاس Database دیگر نیاز نیست آنها را require کنیم بلکه در ابتدای فایل index.php ریشه سایت این دستور را نوشته و در هر فایلی میتوان از کلاس ها استفاده کرد بدون require کردن فایل آنها

# function.php

```php
<?php
    function base_path($path){
        return BASE_PATH.$path;
    }
    function view($path , $attributes = []){
        extract($attributes);
        require base_path("controller/views/".$path);
    }
```
<div dir="rtl">
اما در مورد extract  این تابع یک ارایه انجمنی دریافت کرده کلیدهای آرایه را تبدیل به نام متغیر و مقدار کلیدها تبدیل به مقدار متغیر میشود 
<div dir="ltr">

```php
 view ("index.view.php",["heading"=>"index"]);
```
<div dir="rtl">
در دستور بالا متغییر $heading با مقدار index به فایل index.view.php ارسال میشود.