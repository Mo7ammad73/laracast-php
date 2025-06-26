<div class="body" dir="rtl">
کدهای html نوشته شده در بخش های قبل را از کدهای php جداکرده و در یک فایل جدا با نام مثلا index.view.php ریخته سپس با دستور  require به فایل اصلی اضافه میکنیم.

کدهای فایل اصلی

<div dir="ltr">

```php
<?php
    $books = [
        [
            "name" => "english" ,
            "author" => "a" ,
            "purchaseurl" => "https://google.com"
        ],
        [
            "name" => "web" ,
            "author" => "b" ,
            "purchaseurl" => "https://bing.com"
        ],
        [
            "name" => "css" ,
            "author" => "a" ,
            "purchaseurl" => "https://w3school.com"
        ]
    ];
    function filter($items ,$fn){
        $filtereditem = [];
        foreach($items as $item) {
            if ($fn($item)){
                $filtereditem[] = $item ;
            }
        }
        return $filtereditem;
    }
    $filteredbook = filter($books,function ($book) {
        return $book['name'] == "web";
    });
    require "index.partials.php" ;
?>

```
<div dir="rtl">
کدهای نوشته شده در فایل index.view.php

<div dir="ltr">

```php

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Episode10</title>
    </head>
    <body>

        <ul>
            <?php foreach ($filteredbook as $book) {
                echo "<li>" . $book['name'] . "</li>";
            }
            ?>

        </ul>

    </body>
</html>

```
<div dir="rtl">

در فایل index.view.html متغیرها - توابع و سایر چیزهایی که در فایل اصلی تعریف کرده و در این فایل استفاده میکنیم به صورت زیرخط قرمز به معنی عدم وجود این چیز بر میخوریم البته برنامه به درستی اجرا میشود فقط به صورت ظاهری که برای حل این قضیه در نرم افزار  php storm مراحل زیر را دنبال میکنیم

<div dir="ltr">

menu File==>Settings==>Editor==>Inspections==>Php==>Undefined Symbols ==>Undefined Variable