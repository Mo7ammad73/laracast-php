اگر بر روی هر یک از کلاس ها اشاره گر ماوس را ببریم و کلید ctrl را بزنیم اشاره گر به صورت دست شده و میتوان وارد فایل کلاس مورد نظر مثل PDO شد.اگر وارد فایل کلاس PDO بشویم میبینیم که متد سازنده اش 4 آرگومان dsn,username,password,options رو دارد. پس دستور زیر این 4 آرگومان را دارد.
<div dir="ltr">

```php
    $this->connection  = new PDO($dsn,username,password,options[]);
```
<div dir="rtl">
در فایل کلاس PDO یک سری ثابت با نام های param هست .
ثابت‌های PARAM_* در PDO برای تعیین نوع داده‌ها هنگام استفاده از bindParam() و bindValue() ضروری هستند تا از مشکلات مربوط به نوع داده در پایگاه داده جلوگیری شود.

# PDO::FETCH_ASSOC
این دستور شیوه دریافت داده ها از پایگاه داده را با استفاده از PDO مشخص میکند.هنگامی که از FETCH_ASSOC استفاده میکنیم یعنی داده های بازیابی شده به صورت یک آرایه انجمنی بازگردانده میشود که کلیدهای آن نام ستون های جدول هست.
<div dir="ltr">

```php
    <?php
        // اتصال به دیتابیس
        $pdo = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
        
        // آماده‌سازی و اجرای کوئری
        $stmt = $pdo->query("SELECT id, name, email FROM users");
        
        // دریافت داده‌ها به‌صورت آرایه انجمنی
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        print_r($rows);
?>

```
<div dir="rtl">
خروجی مثال بال به صورت زیر هست :
<div dir="ltr">

```php
Array (
    [0] => Array ( [id] => 1, [name] => "Ali", [email] => "ali@example.com" )
    [1] => Array ( [id] => 2, [name] => "Sara", [email] => "sara@example.com" )
)

```
<div dir="rtl">


تفاوت PDO::FETCH_ASSOC با PDO::FETCH_BOTH و PDO::FETCH_OBJ:
<hr>
PDO::FETCH_ASSOC → فقط آرایه انجمنی برمی‌گرداند (کلیدها برابر با نام ستون‌ها).
<hr>
PDO::FETCH_BOTH → هم آرایه انجمنی و هم عددی برمی‌گرداند.(مقدار پیش فرض)
<hr>
PDO::FETCH_OBJ → خروجی را به‌صورت یک شیء برمی‌گرداند.
<hr>

تغییر مقدار پیش‌فرض:
<hr>
اگر بخواهید مقدار پیش‌فرض fetch() را تغییر دهید، می‌توانید هنگام ایجاد PDO، گزینه ATTR_DEFAULT_FETCH_MODE را تنظیم کنید:

<div dir="ltr">

```php
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
```
<div dir="rtl">
اکنون تمام fetch()ها بدون نیاز به مشخص کردن PDO::FETCH_ASSOC، خروجی را به‌صورت آرایه انجمنی برمی‌گردانند.
<hr>
در کلاس database  یک آرایه با نام config تعریف کرده و مقادیر dsn را درون آن قرار میدهیم.
سپس مقدار dsn را به صورت زیر تغییر میدهیم.
<div dir="ltr">

```php
    $config = [
              "host" => "localhost",
              "port" => 3306,
              "dbname" => "mydb1",
              "username" => "root",
              "charset" => "utf8mb4"
            ];
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']};charset={$config['charset']}";
```
<div dir="rtl">
در کلاس database به متد سازنده رفته و کد داخلش را تغییر میدهیم .
<div dir="ltr">

```php
$this->connection  = new PDO($dsn,"root","",[
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC//تعیین مقدار پیش فرض واکشی داده ها اط پایگاه داده به صورت آرایه انجمنی
    ]);
```
<div dir="rtl">

# http_biuld_query()
این تابع یک آرایه را به یک رشته کویری تبدیل میکند که میتوان آنها را در url یا درخواست http  استفاده کرد.
<div dir="ltr">

```php
<?php
    $data = [
        'name' => 'Ali',
        'age' => 30,
        'city' => 'Tehran'
    ];
    
    $queryString = http_build_query($data);
    
    echo $queryString;
    //name=Ali&age=30&city=Tehran
    //این رشته‌ی کوئری می‌تواند برای ارسال اطلاعات در یک URL یا درخواست‌های API استفاده شود:
    //https://example.com/profile.php?name=Ali&age=30&city=Tehran


$data = [
    'user' => [
        'name' => 'Ali',
        'age' => 30
    ],
    'city' => 'Tehran'
];

$queryString = http_build_query($data);

echo $queryString;


//user%5Bname%5D=Ali&user%5Bage%5D=30&city=Tehran

//در اینجا، PHP کلیدهای آرایه را به فرمت URL-Encoded (%5B و %5D معادل [ ] در URL هستند) تبدیل کرده است.

http_build_query($data, '', '&', PHP_QUERY_RFC3986);

//پارامتر دوم: Prefix (معمولاً خالی '' است)
//پارامتر سوم: جداکننده بین پارامترها (& یا ;)
//پارامتر چهارم: RFC3986 یا RFC1738 برای نوع URL Encoding
?>

```
<div dir="rtl">
 با توجه به تابع http biuld query آرایه config  را به این تابع داده تا رشته مورد نظرمان را بگیریم فقط کاراکتر جداکننده را سمی کالن میگذاریم چون در dsn با سمی کالن جدا میشوند.
<div dir="ltr">

```php
$dsn = "mysql:" . http_build_query($config,'',';');
```
<div dir="rtl">
برای داینامیک کردن کار بهتر است آرایه config را در فایل index تعریف کرده و به کلاس database به عنوان آرگومان بدهیم پس:
<div dir="ltr">

```php
//construc method in class dtabase:
 public function __construct($config) {
        
    $dsn = "mysql:" . http_build_query($config,'',';');
    $this->connection  = new PDO($dsn,"root","",[
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    }

//file index.php

require_once "database.php";
$config = [
    "host" => "localhost",
    "port" => 3306,
    "dbname" => "mydb1",
    "username" => "root",
    "charset" => "utf8mb4"
];
$db = new Database($config);
$post = $db->query("SELECT * FROM tb2")->fetchAll(PDO::FETCH_ASSOC);;
show_print($post);

foreach ($post as $key => $value){
    echo $value['title']."<br>";
}
```
<div dir="rtl">
یک فایل تنظیمات config.php ایجاد کرده و درون آن کد زیر را مینویسیم:
<div dir="ltr">

```php
<?php
    return [
    "host" => "localhost",
    "port" => 3306,
    "dbname" => "mydb1",
    "username" => "root",
    "charset" => "utf8mb4"
    ];

//index.php 


require_once "database.php";
$config = require_once "config.php";//notic
$db = new Database($config);
$post = $db->query("SELECT * FROM tb2")->fetchAll(PDO::FETCH_ASSOC);;
show_print($post);

foreach ($post as $key => $value){
    echo $value['title']."<br>";
}
```
<div dir="rtl">
متد سازنده در فایل database را تغییر داده و آرگومان نام کاربری و پسوورد را به آن اضافه میکنیم سپس وقتی یک شی PDO ایجاد کردیم از آرگومان های متدسازنده در آن استفاده می کنیم.
<div dir="ltr">

```php
public function __construct($config,$username='root',$password='') {

    $dsn = "mysql:" . http_build_query($config,'',';');
    $this->connection  = new PDO($dsn,$username,$password,[
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
```
<div dir="rtl">
به فایل config.php  رفته  محتوایش را تغییر میدهیم

<div dir="ltr">

```php
<?php
    return [
        "database"=> [
            "host" => "localhost",
            "port" => 3306,
            "dbname" => "mydb1",
            "username" => "root",
            "charset" => "utf8mb4"
        ]
    ];
```
<div dir="rtl">
دلیل تغییر بالا برای ساماندهی بهتر کدها هست و اینکه اگر بعدا تنظیمات دیگری به این فایل اضافه کردیم به مشکل برنخوریم.

حالا در هنگام ایجاد کلاس Database به صورت زیر عمل میکنیم
<div dir="ltr">

```php
$db = new Database($config['databases']);//add key database to $config
```