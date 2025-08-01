<div dir="rtl">

# Forbidden 403
کاربر اجازه ی دسترسی به صفحه یا اطلاعات را ندارد

# Not Found 404
یادداشت مورد نطر یافت نشد
<div dir="rtl">
در این ویدیو گفته میشه وقتی وارد صفحه note میشیم با تغییر id  در url میتونیم یادداشت ها رو تغییر داده و مشاهده کنیم در اینصورت اولا اگر یادداشت با id  مورد نظر وجود نداشته باشد خطا رخ میدهد دوما اگر یادداشت برای یک کاربر دیگه هست باز از لحاظ منطقی خطا دارد پس یک راه اینست که یک کد sql نوشته که فیلدuser_id
رو چک کنه در اینصورت فقط نیاز به بررسی وجود یادداشت هست و به forbidden نیازی نیست مثال:

<div dir="ltr">

```php
<?php
    $config = require_once 'config.php';
    require_once "Database.php";
    require_once "Response.php";
    $note = new Database($config['database'], "root", "");
    $note = $note->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->fetch();
    
    if(!$note){
    
        http_response_code(Response::NOT_FOUND);
        require_once "404.php";
        exit();
    
    }

```
<div dir="rtl">
اما یه راه دیگر این هست که کد sql مثل سابق باشد با دو دستور if  این قضیه رو بررسی کنیم اگه یادداشت نبود not found اگه بود و با user_id مطایقت نداشت forbidden  مثل کد زیر :
<div dir="ltr">

```php

    
    require "Database.php";
    require "Response.php";
    
    $db = new Database();
    
    $current_userid = 3; // فرضی؛ بعداً از جلسه login واقعی میاد
    
    // Resourceful Naming Conventions(29). گرفتن یادداشت بر اساس فقط id
    $note = $db->query("SELECT * FROM notes WHERE id = :id", [
        'id' => $_GET['id']
    ])->fetch();
    
    // 2. اگر یادداشت وجود نداشت → 404
    if (!$note) {
        http_response_code(Response::NOT_FOUND);
        require "views/errors/404.php";
        exit();
    }
    
    // 3. اگر یادداشت برای کاربر فعلی نبود → 403
    if ($note['user_id'] != $current_userid) {
        http_response_code(Response::FORBIDDEN);
        require "views/errors/403.php";
        exit();
    }
    
    // 4. نمایش یادداشت
    require "views/show.view.php";
    

```