در ابتدا در نرم افزار table plus  به جدول notes داده وارد کرده سپس در بخش history آخرین کد Sql را مشاهده میکنیم و از این کد در پروژه خودمان بهره میبریم به فایل note_create.php  رفته و کد زیر را مینویسیم:
<div dir="ltr">

```php

    <?php
        $config = require_once 'config.php';
        require_once "Database.php";
        require_once "Response.php";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $db = new Database($config['database']);
            $db->query("INSERT INTO notes (body,user_id) VALUES (:body ,:user_id)" , ['body' => $_POST['body'], 'user_id' => 3 ]);
        }
    
        require_once "views/notes_create.view.php";

```
<div dir="rtl">
حالا توسط کد بالا اطلاهات در جدول note ذخیره میشود . فقط برای نمایش یادداشت ها حتما $note['body'] رو داخل تابع htmlspactialchars قرار باید داد تا در هنگام نمایش به صورت کد html  نمایش داده نشود و در query که به پایگاه داده میدهیم باید مقدار ها را به صورت بایند شده :  ارسال کرد تا از حملات sql injection  جلوگیری شود