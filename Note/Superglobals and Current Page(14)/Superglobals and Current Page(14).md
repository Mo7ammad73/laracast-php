<div dir="rtl">

## $_SERVER
#### یک آرایه پیش ساخته هست که اطلاعات مختلفی در مورد محیط سرور و درخواست های php  که به سرور ارسال میشود را برمیگرداند

#### $_SERVER['HTTP_USER_AGENT']  اطلاعات مربوط به مرورگر کاربر
#### $_SERVER['REQUEST_URI'] url کاملی که درخواست کرده اید
#### $_SERVER['PHP_SELF] نام فایل php فعلی به همراه مسیرش نسبت به ریشه سایت
#### برای نمایش تمام داده های $_SERVER به صورت کد زیر عمل میکنیم

<div dir="ltr">

```html

<?php
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
die();//برای قطع کد از این نقطه به بعد کد اجرا نمیشود

```
<div dir="rtl">

#### همان کدهای جلسه قبل برای منوها رو اینجا با REQUEST_URI نوشتیم

<div dir="ltr">

```html
<a href="/" class="rounded-md <?php echo (basename($_SERVER['REQUEST_URI'])== "/") ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ; ?>   px-3 py-2 text-sm font-medium " aria-current="page">Home</a>
<a href="/Code/views/about.php" class="rounded-md <?php echo (basename($_SERVER['REQUEST_URI'])== "about.php") ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ; ?>   px-3 py-2 text-sm font-medium ">About</a>
<a href="/Code/views/contact.php" class="rounded-md <?php echo (basename($_SERVER['REQUEST_URI']) == "contact.php") ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ; ?> px-3 py-2 text-sm font-medium ">Contact</a>

```
<div dir="rtl">

####  در این قسمت ما یک فایل تابع را در پوشه partials ایجاد کرده و درون آن یک تابع برای بررسی صفحه فال تعریف میکنیم سپس در هر کدام از فایل های about-index-contact این فایل تابع را require_once میکنیم بعد کد مربوط به بخش منوها در فایل nav را تغییر میدهیم
<div dir="ltr">

## function.php

```html
<?php

    function activePage($url){
        return $_SERVER['REQUEST_URI']==$url;
    }

```

## about.php index.php contact.php

```html
<?php
    require_once "partials/function.php";
    $heading = "index or about or Contact";
    require_once "index.view.php or contact.view.php or about.view.php";
```
## nav.php
```html
<a href="/" class="rounded-md <?php echo (activePage("/")) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ; ?>   px-3 py-2 text-sm font-medium " aria-current="page">Home</a>
<a href="/Code/views/about.php" class="rounded-md <?php echo (activePage("about.php")) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ; ?>   px-3 py-2 text-sm font-medium ">About</a>
<a href="/Code/views/contact.php" class="rounded-md <?php  echo (activePage("contact.php")) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ; ?> px-3 py-2 text-sm font-medium ">Contact</a>
```

<div dir="rtl">
فرق PHP_SELF با REQUEST_URI در این هست که PHP_SELF مسیر فایل جاری رو برمیگردونه و شامل query string نمیشه ام REQUEST_URI مسیرجاری همراه با QUERY STRING رو برمیگردونه پس بهتره از $_SERVER['REQUEST_URI'] استفاده کرد.