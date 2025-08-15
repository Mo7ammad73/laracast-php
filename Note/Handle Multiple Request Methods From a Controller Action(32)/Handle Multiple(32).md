<div dir="rtl">
در این قسمت به صفحه ای که یک یادداشت خاص را نشان میده رفته و یک دکمه برای حذف آن یادداشت گذاشتیم اگر کاربر بر روی آن کلیک کند یادداشت حذف شده و دوباره به صفحه ی یادداشت ها برمیگردیم
<div dir="ltr">

# show.php

```php
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $db = new Database($config['database'], "root", "");
        $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->findOrFail();
        Authorize($note['user_id'] === 3);
        $db->query("DELETE FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->fetch();
        header("location:/laracast-php/public/notes");
        exit();
    }else
    {
        $db = new Database($config['database'], "root", "");
        $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->findOrFail();
        $current_userid = 3;
        Authorize($note['user_id'] === $current_userid);
        view("note/show.view.php", ["note"=>$note]);

    }
```
<div dir="rtl">
فقط برای حذف باید از متد fetch و برای نمایش باید از متد findorfail استفاده کرد.