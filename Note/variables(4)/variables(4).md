

<div class="body" dir="rtl">
در ترمینال phpstorm دستور php -S localhost:8888 را نوشته و یک آدرس به ما میدهد با کلیک بر روی آن وارد مرورگر شده و خروجی را میبینیم.

یک فایل index.html ایجاد کرده و درون آن html:5 را مینویسیم تا قالب آماده دستورات html بیاید. دو تا تگ meta را حذف میکنیم.
فایل را به index.php تغییر داده و در تگ body بین دو تگ h1 کد زیر را مینویسیم:
<div dir="ltl"> 

```html
        <div>
            <h1>
                hello
            </h1>
        </div>
 ```
<div dir="rtl">


رشته ها را هم میتوان بین دو تا " " و ' ' نوشت.
در دابل کوتیشن متغیرها رو میتوان interpolate کرد ولی در سینگل کوتیشن به صورت یه رشته خام دریافت کرده و به خروجی میدهد.
برای الحاق رشته ها باید از . نقطه استفاده کرد نه از + .
<div dir="ltl">

```php
    echo "hello" . " " . "world";//true
    echo "hello" + " " + "world";//false
```
<div dir="rtl">

برای الحاق رشته و متغییر رشته ای به صورت زیر عمل میکنیم.
<div dir="ltl">

```php
    $greeting = "hello";
    echo $greeting . " " . "world"; 
   
```
<div dir="rtl">
برای استفاده از متغیرها داخل رشته ها فقط میتوان آنها را در " " استفاده کرد.
<div dir="ltl">

```php
    echo " $greeting world  ";
```