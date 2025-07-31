<div dir="rtl">
<div dir="ltr">
<div dir="rtl">
یک فایل با نام routes.php ایجاد کرده و درون آن محتویات آرایه routes موجود در فایل index.php را ریخته تا مسیرها در در یک فایل جدا مدیریت کنیم پس :

<div dir="ltr">

# routes.php

```php
    <?php
    
        return [
        "/laracast-php/" => "controller/index.php",
        "/laracast-php/about" => "controller/about.php",
        "/laracast-php/contact" => "controller/contact.php",
        "/laracast-php/notes" => "controller/notes.php",
        "/laracast-php/notes/create" => "controller/note_create.php",
        "/laracast-php/notes/note" => "controller/note.php"
        ];

```
# index.php

```php
    <?php
        $routes = require_once 'routes.php';
        $url =parse_url($_SERVER['REQUEST_URI'])['path'];
        if(array_key_exists($url,$routes)){
        
            require $routes[$url];
        }else{
            echo "404";
            header("location: /laracast-php/");
        }
```
<div dir="rtl">
حالا ما میخواهیم یک صفحه افزودن یادداشت ایجاد کنیم پس فایل note_create.php را در پوشه controller و فایل note_create_view.php را در پوشه views ایجاد میکنیم محتویات این دو فایل به صورت زیر میشود:

<div dir="ltr">

# note_create.php
```php
<?php
    require_once "views/notes_create.view.php";
```

# note_create.view.php
```php
<?php $current_page="Create Notes"; ?>
<?php require_once "partials/nav.php"; ?>
<?php require_once "partials/header.php"; ?>

<?php require_once "partials/footer.php"; ?>
```
<div dir="rtl">
در صفحه ای که یادداشت ها نمایش داده میشود که در فایل notes.view.php باید باشد که در این پروژه در فایل header.php قرار دادیم زیر یادداشت ها میخواهیم یک لینک ایجاد کنیم که به صفحه ایجاد یادداشت برود پس :

<div dir="ltr">
    
```php
    <div class="mt-6">
        <a href="/laracast-php/notes/create" class=text-blue-500 hover:underline> Create Note </a>
    </div>
```
<div dir="rtl">
href بر حسب مسیرهای موجود در فایل routes.php  داده میشود .آدرس صفت 
به سایت tailwindui رفته و عبارت form layout را جستجو میکنیم سپس کدش را کپی کرده و در فایل note_create.view.php به صورت زیر اضافه میکنیم:
<div dir="ltr">

```php
    
    <?php $current_page="Create Notes"; ?>
    <?php require_once "partials/nav.php"; ?>
    <?php require_once "partials/header.php"; ?>
    
        <div class="mt-6">
            <form method="post">
                <div class="space-y-12">
    
                    <div class="col-span-full">
                        <label for="body" class="block text-sm/6 font-medium text-gray-900">Body</label>
                        <div class="mt-2">
                            <textarea id="body" name="body" placeholder="note text" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                        </div>
                        <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences  for notes.</p>
                    </div>
    
    
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
            </form>
    
        </div>
    
    
    <?php require_once "partials/footer.php"; ?>
```
<div dir="rtl">
در کد بالا بخشی از کدهای فرم را پاک کردیم و فقط آن بخش مورد نظر را نگه داشتیم. 

# فقط باید پلاگین form سایت tailwindui را فعال کنیم که برای انجام اینکار به فایل nav.php رفته و کد script که قبلا نوشته بودیم را تغییر میدهیم

<div dir="ltr">

```php

    <script src="https://cdn.tailwindcss.com"></script>//old code
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>//new code

```
<div dir="rtl">
در فایل note_create.view.php در قسمت form  صفت id مربوط به برچسب lable را body و name,id برچسب text را body قرار میدهیم و هم چنین صفت method فرم را post قرار میدهیم حالا برای امتحان اینکه کد ما کار میکند محتویات فایل های note_create.php و note_create.view.php به صورت زیر هست :

<div dir="ltr">

# note_create.php

```php
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        var_dump($_POST);
    }
    
    require_once "views/notes_create.view.php";
```

# note_create.view.php

```php
<?php $current_page="Create Notes"; ?>
<?php require_once "partials/nav.php"; ?>
<?php require_once "partials/header.php"; ?>

    <div class="mt-6">
        <form method="post">
            <div class="space-y-12">

                <div class="col-span-full">
                    <label for="body" class="block text-sm/6 font-medium text-gray-900">Body</label>
                    <div class="mt-2">
                        <textarea id="body" name="body" placeholder="note text" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                    </div>
                    <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences  for notes.</p>
                </div>


                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
        </form>

    </div>


<?php require_once "partials/footer.php"; ?>
```