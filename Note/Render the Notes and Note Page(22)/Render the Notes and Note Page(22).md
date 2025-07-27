<div dir="rtl">

خلاصه هدف جلسه ۲۲:
در این جلسه می‌خوایم:

یادداشت‌های یک کاربر خاص را نمایش دهیم.

وقتی روی یک یادداشت کلیک کردیم، محتوای کامل همان یادداشت را در صفحه‌ای جدید ببینیم.

با استفاده از GET، اطلاعات یادداشت را از URL بگیریم.

بخش جدیدی به منو اضافه کنیم (Notes).

با ایجاد view و controller جدید، سیستم را گسترش بدهیم.

<div dir="rtl">

# Notes
ابتدا باید منو notes را به بخش nav اضافه کرد .پس به پوشه partials بعد views بعد nav.php رفته و کد زیر را مینویسیم :
<div dir="ltr">

```php
<?php
                        $pages =[
                            "/laracast-php/" => "Dashboard",
                            "/laracast-php/about" => "About",
                            "/laracast-php/contact"=> "Contact",
                            "/laracast-php/notes"=> "Notes"
                        ]
                    ?>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <?php foreach ($pages as $key => $value): ?>
                                <a href=<?=$key ?> aria-current="page" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white"><?= $value ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
```
<div dir="rtl">
با توجه به کد بالا منوی notes به صفحه اصلی اضافه شده که طبق قوانین router که قبلا داشتیم با /notes میتوان وارد صفحه یادداشتها شد.
حالا در فایل index.php موجود در ریشه کد زیر را مینویسیم :
<div dir="ltr">

```php

<?php

    $routes =[
        "/laracast-php/" => "controller/index.php",
        "/laracast-php/about" => "controller/about.php",
        "/laracast-php/contact" => "controller/contact.php",
        "/laracast-php/notes" => "controller/notes.php",//جدید
        "/laracast-php/notes/note" => "controller/note.php"//جدید
    ];
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];
    echo $url;
    if(array_key_exists($url,$routes)){
    
        require $routes[$url];
    }else{
        echo "404";
        header("location: /laracast-php/");
    }

```
<div dir="rtl">
 به پوشه controller رفته و دو فایل note.php,notes.php را ایجاد میکنیم سپس کنار این دو فایل فایلهای database.php,config.php هم باید باشه بعد به پوشه views رفته و note.view.php,notes.view.php را ایجاد میکنیم
حالا داخل این فایل ها کدهای مورد نظرمان را مینویسیم :

<div dir="ltr">

# notes.php 

```php
    <?php
    $config = require_once 'config.php';
    require_once "Database.php";
    $notes = new Database($config['database'], "root", "");
    $notes = $notes->query("SELECT * FROM notes where user_id=:id",["id"=>3])->fetchAll(PDO::FETCH_ASSOC);
    require_once "views/notes.view.php";
```

# note.php

```php
<?php
    $config = require_once 'config.php';
    require_once "Database.php";
    $note = new Database($config['database'], "root", "");
    $note = $note->query("SELECT * FROM notes where id=:id",["id"=>$_GET['id']])->fetch();
    var_dump($note);
    require_once "views/note.view.php";
```

# notes.view.php

```php
<?php
    $current_page="Notes";
    require_once "partials/nav.php";
    require_once "partials/header.php";
    require_once "partials/footer.php";
```

# note.view.php

```php
<?php
    $current_page="Note";
    require_once "partials/nav.php";
    require_once "partials/header.php";
    require_once "partials/footer.php";
```
<div dir="rtl">
حالا در فایل header.php موجود در پوشه partials محل نمایش یادداشت ها کد زیر را مینویسیم :

<div dir="ltr">

```php
    <header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900"><?=$current_page ?></h1>
        <br>
        <?php if($current_page == "Notes"): ?>
            <ul style="list-style-type: disc">
                <?php
                    foreach($notes as $note){
                        echo "<li>" . "<a href=/laracast-php/notes/note?id={$note['id']} class=text-blue-500 hover:underline > " . $note['body'] . "</a></li>";
                    }
                ?>
            </ul>
        <?php endif; ?>
        <?php if($current_page == "Note"): ?>
            <?= $_GET['id']; ?>
            <ul style="list-style-type: disc">
                <?php
                    echo  $note['body'] ;
                ?>
            </ul>
        <?php endif; ?>
    </div>
</header>
```
<div dir="rtl">
حالا با رفتن به بخش notes تمام یادداشتهای فعلا کاربر با id=3 رو میبینیم و اگر بر روی هر کدام از یادداشت ها کلیک کنیم آن یادداشت را جداگانه میبینیم.