<div class="body" dir="rtl">

<div dir="ltr">

```php

    function FilterByAuthor($books , $author){
            $filteredbook = [];
            foreach($books as $book) {
                if ($book['author'] == $author){
                    $filteredbook[] = $book ;
                }
            }
            return $filteredbook;
        }
        $filteredbook=FilterByAuthor($books,'a')
    
    <ul>
        <?php foreach ($filteredbook as $book) {
            echo "<li>" . $book['name'] . "</li>";
        }
        ?>
    </ul>
```
<div dir="rtl">

در مثال بالا خروجی تابع را در آرایه filteredbook ریختیم سپس با حلقه foreach این آرایه را پیمایش کردیم. قبلا خود فراخوانی تابع را در ابتدای حلقه foreach گذاشته و پیمایش میکردیم.

#### تابع ناشناس(Anonymous Function)
در تعریف این تابع کل تابع را در یک متغیر ریخته و در انتهای تعریف تابع سمی کالن گذاشته و برای فراخوانی تابع هم از نام متغییر استفاده میکنیم.

<div dir="ltr">

``` php
$variable-name = function( ,..., ) {

};
$variable-name( ,..., )// for call function
```

<div dir="rtl">

ایجاد تابع فیلتر که به صورت کلی تعریف شده و میتوان هرچیزی لیست - دیتا - آیتم و ... را بهش داد و یک مقدار و کلید را هم داده تا عمل فیلتر را انجام دهد.

<div dir="ltr">

```php
    function filter($items , $key , $value){
            $filtereditem = [];
            foreach($items as $item) {
                if ($item[$key] == $value){
                    $filtereditem[] = $item ;
                }
            }
            return $filtereditem;
        }
     $filteredbook = filter($books,'author','a');
```

<div dir="rtl">
حالا به جای آرگومان های کلید و مقدار میتوان یک تابع را به عنوان آرگومان به تابع داده و از طریق مقدار برگشتی تابع عملیات فیلتر را انجام داد.

<div dir="ltr">

```php
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
    <ul>
        <?php foreach ($filteredbook as $book) {
            echo "<li>" . $book['name'] . "</li>";
        }
        ?>
    
    </ul>
```
<div dir="rtl">
میتوان تابع را یکجا تعریف کرد و نامش را برای فراخوانی تایع فیلتر داد به صورت زیر :

<div dir="ltr">

```php

$s = function ($book) {
        return $book['name'] == "web";
};
$filteredbook = filter($books, $s );
```
<div dir="rtl">
تابع  تابع داخلی array_filter برای حذف داده های نامطلوب از آرایه استفاده میشه که یا ما بهش میگیم چه داده ها یی رو از ارایه حذف کن توسط ارکون دوم تابع و تابعی که تعریف میکنیم یا اگه خالی بذاریم خودش داده های falsy یعنی صفر و null و ... رو حذف میکنه.
<div dir="ltr">
تابع array_map
<div dir="rtr">
این تابع دو ورودی میگیره یکی تابع و یکی هم آرایه سپس اون تابعی که به عموام ورودی میگیره روی تک تک اعضای آرایه اعمال میکنه فرق این تابع با array_filter اینه که array_filter برای حذف داده های مطلوب هست یعنی به آرایه میگیره و داده های مطلوبش رو حذف میکنه ولی array_map تابعی که برای تبدیل یا تغییر هر عضو آرایه استفاده میشه مثلا آرایه ای از اعداد داریم توسط این تابع همه ی اعضای ان را به توان 2 میرسانیم.
<div dir="ltr">

```php
    $numbers = [1, 2, 3, 4];
    
    $squares = array_map(function($n) {
        return $n * $n;
    }, $numbers);
    
    print_r($squares);
       //output:Resourceful Naming Conventions(29),4,9,16
       
       
    //other example
            $users = [
            ['name' => 'Ali', 'age' => 25],
            ['name' => 'Sara', 'age' => 17]
            ];
        
            $names = array_map(function($user) {
                return strtoupper($user['name']);
            }, $users);
            
            print_r($names);
 
```
<div dir="rtl">
یه مثال خیلی خوب از ترکیب array_filter , array_map
در این مثال خواسته شده که نام و قیمت مصولاتی که دسته الکترونیک هستند رو با افزایش قیمت 10 درصدی نمایش بده یعنی خروجی زیر را از ما میخواد :
<div dir="ltr">

```php
[
    ['name' => 'Laptop', 'price' => 1650],
    ['name' => 'Phone', 'price' => 880],
]

```
```php
$products = [
        ['name' => 'Laptop', 'price' => 1500, 'category' => 'Electronics'],
        ['name' => 'Shoes', 'price' => 100, 'category' => 'Fashion'],
        ['name' => 'Phone', 'price' => 800, 'category' => 'Electronics'],
        ['name' => 'T-Shirt', 'price' => 25, 'category' => 'Fashion'],
        ['name' => 'Book', 'price' => 20, 'category' => 'Books'],
    ];
```
```php
    $product = array_filter($products, function ($p) { return $p["category"] == "Electronics"; });
    $product = array_values($product);
    $product = array_map(function($p){ return ["name" => $p["name"] , "price"=> $p["price"] * 1.1];} , $product);
    echo "<pre>";
            print_r($product);
    echo "</pre>";
```
<div dir="rtl">
تابع anonymous , lambda به توابعی که درون array_map , array_filter و یا توابعی که جلوی نام متغیر به صورت $x=function(){} تعریف میشن گفته میشود.