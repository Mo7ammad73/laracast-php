در این جلسه قراره تو صفحه ای که یک یادداشت خاص نمایش داده میشد و زیرش یک دکمه delete بود یک دکمه یا لینک  update بذاریم تا با کلیک بر روی آن وارد صفحه ویرایش یادداشت بشویم و آنجا بتوانیم یادداشت مورد نظر را ویرایش کنیم.
3 فایل باید ایجاد کنیم فایل edit.php در پوشه controller/note/edit  و فایل edit.view.php در پوشه controller/view/note/ و فایل update.php در controller/note .

---

## فایل edit.php

این فایل  یادداشت موردنظر را از پایگاه داده گرفته و آن را به edit.view.php ارسال کند.
```php
$db = \core\App::resolve(Database::class);  
$note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->fetch();
```

---

### نکته :
در دستور بالا  مقدار بایند شده برای فیلد id در دستور sql توسط متد get که در Url هست  بدست میاد حالا این id  چطوری در url اضافه شده؟پاسخش اینکه در فایل show.view.php که یک لینک به فایل edit گذاشته بودیم اونجا در قسمت herf لینک id یادداشت جاری را گرفته و از طریق url و متد get به فایل edit.php انتقال دادیم.


---

بعد از دریافت یادداشت مورد نظر بررسی میکنیم که کاربر مجوز دارد آن را تغییر دهد:
```php
$current_userid = 3;  
Authorize($note['user_id'] === $current_userid);
```
سپس آن یادداشت را به فایل edit.view.php انتقال میدهیم و میخواهیم که صفحه ویرایش یادداشت نمایش داده شود:
```php
view("note/edit.view.php", ["note"=>$note]);
```
در فایل edit.view.php برای اینکه پیش فرض شامل یادداشتی باشد که کاربر درخواست کرده آن را ویرایش کند باید ازمتغیر note ای که توسط فایل edit انتقال داده شده استفاده کنیم.
## خلاصه
- ابتدا با کوئری یادداشت با id مشخص‌شده و متعلق به user با id=3 پیدا می‌شود.
- اگر user_id متعلق به یادداشت برابر با user فعلی نباشد، Authorize اجرا می‌شود؛ پس امنیت کاملاً رعایت شده.
- در نهایت، اطلاعات یادداشت به ویو ارسال می‌شود تا فرمی با مقداردهی قبلی نمایش داده شود.

---

## محتوای فایل edit.php

```php
<?php  
    use core\Database;  
  
    $db = \core\App::resolve(Database::class);  
    $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->fetch();  
  
    $current_userid = 3;  
  
    Authorize($note['user_id'] === $current_userid);  
  
    view("note/edit.view.php", ["note"=>$note]);
```

---
## فایل edit.view.php

در این فایل ما یک فرم داریم که یک جعبه متن دارد که مقدار پیش فرضش برابر با متن یادداشت جاری هست که قراره ویرایش شود یک دکمه برای ویرایش و یک دکمه هم برای انصراف از ویرایش
- جعبه متن `textarea` با مقدار فعلی نوت پر می شود.
```php
<textarea><?= isset($note['body']) ? $note['body'] : '' ; ?></textarea>
```
- فرم با `POST` برود ولی با `_method=PATCH` شبیه PATCH رفتار کند. یعنی فرم ما با متد post ارسال میشود ولی داخلش یک input مخفی میگذاریم برای اینکه متد PATCH رو بفرستد  تا router متوجه شود نوع درخواست PATCH میباشد.
```php
<form method="post" action="/laracast-php/public/notes/update">
	<input type="hidden" name="_method" value="PATCH">
```
- مقدار`id` را به صورت مخفی از طریق note که از فایل edit انتقال دادیم می فرستیم تا در فایل update برای انجام عملیات ویرایش استفاده کنیم.
```php
<input type="hidden" name="id" value=<?= $note['id']; ?>>
```
در دکمه انصراف از ویرایش هم به صفحه نمایش تمام یادداشت ها برمیگردیم که کدش به صورت زیر هست:
```php
<a href="/laracast-php/public/notes" class="text-sm text-blue-500 ">Cancel</a>
```
دکمه save هم چون type برابر با submit هست وقتی کلیک شود اطلاعات داخلش از طریق متد post  به فایل update.php ارسال میشود .

---
## کنترلر update.php

در اینجا ابتدا یادداشت postشده با id مشخص را که از فرم ویرایش یادداشت فایل edit.view.php ارسال شده بدست میاوریم  پس مقدار بایند شده برای id در دستور sql با post['id']  مشخص میشود بر خلاف فایل edit.view.php که آنجا از طریق متد get فیلد id دریافت میشد.
```php
$db = \core\App::resolve(Database::class);  
$note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->fetch();
```
مجوز اینکه کاربر میتونه این فایل را ویرایش کند یا نه بررسی میشود:
```php
$current_userid = 3;  
Authorize($note['user_id'] === $current_userid);
```
در مرحله بعد یک آرایه با نام error تعریف میکنیم و با توجه به متدهای که در کلاس Validator تعریف کردیم بررسی میکنیم اگرجعبه متن خالی بود یا بیش از طول مشخص شده داشت error بده یعنی خطا را در همون فرم ویرایش نمایش بدهد و اطلاعات ویرایش نشود ولی اگر همه چی درست بود یعنی آرایه error خالی بود بیاد عمل ویرایش را انجام بدهد بعد به صفحه یادداشت ها هدایت شود.
```php
$error =[];  
if($_SERVER["REQUEST_METHOD"] == "POST"){  
  
    if(validator::Is_Empty($_POST['body'])){  
        $error["body"] = "Body is required";  
    }else if(!validator::Count_Char($_POST["body"],1,1000)){  
        $error["body"] = "body is too long ";  
    }  
    if(empty($error)){  
        $db = \core\App::resolve(Database::class);  
        $db->query("UPDATE  notes SET body=:body where id=:id" , ['body' => $_POST['body'], 'id' => $_POST['id'] ]);  
        $_POST['body'] = null;  
        header('Location: /laracast-php/public/notes');  
        exit();  
    }else  
    {  
        view("note/edit.view.php",['error'=>$error , 'note'=>$note]);  
    }  
}
```

## خلاصه
- ابتدا یادداشت از دیتابیس گرفته می‌شود و امنیت با تابع Authorize تأمین می‌گردد.
- اعتبارسنجی روی فیلد body انجام می‌شود: نباید خالی باشد، طولش نباید بیش از 1000 کاراکتر باشد.
- اگر همه ‌چیز درست بود، متنی که کاربر وارد کرده با کوئری UPDATE جایگزین می‌شود و کاربر به صفحه‌ی لیست یادداشت‌ها منتقل می‌شود.
- اگر خطا بود، مجدد فرم با خطا نمایش داده می‌شود.
---

## محتوای کلی فایل update.php

```php
<?php  
    use core\Database;  
    use core\Validator;  
    $db = \core\App::resolve(Database::class);  
    $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->fetch();  
  
    $current_userid = 3;  
  
    Authorize($note['user_id'] === $current_userid);  
  
    $error =[];  
    if($_SERVER["REQUEST_METHOD"] == "POST"){  
  
        if(validator::Is_Empty($_POST['body'])){  
            $error["body"] = "Body is required";  
        }else if(!validator::Count_Char($_POST["body"],1,1000)){  
            $error["body"] = "body is too long ";  
        }  
        if(empty($error)){  
            $db = \core\App::resolve(Database::class);  
            $db->query("UPDATE  notes SET body=:body where id=:id" , ['body' => $_POST['body'], 'id' => $_POST['id'] ]);  
            $_POST['body'] = null;  
            header('Location: /laracast-php/public/notes');  
            exit();  
        }else  
        {  
            view("note/edit.view.php",['error'=>$error , 'note'=>$note]);  
        }  
    }
```

---
## مسیریابی

با توجه به متد add در کلاس Router ما برای تعریف یک مسیر
- متد مثلا post,get یا هرچیز دیگه ای که در کلاس Router تعریف شده
- آدرس url  یعنی آدرسی که کاربر درخواست میکند
- کنترلر که مسیر فایل را مشخص میکند میگیریم
  بعد این سه مورد را در آرایه routes که شامل تمام مسیر های پروژه هست قرار میدهیم تا بعدا برای مسیریابی از این آرایه استفاده کنیم.
 ```php
 public function add($methods , $uri , $controller) {  
      foreach ((array)$methods as $method) {  
         $this->routes[] = [  
	        'uri' => $uri,  
            'controller' => $controller,  
            'method' => $method  
            ];  
        }  
    }
 ```
حالا کلاس Router یک متد route هم برای مسیریابی دارد که url و متد درخواستی کاربر را میگیرد و با توجه به این دو مورد کنترلر مورد نظر را از آرایه routes بدست آورد و require میکند.
 ```php
 public function route($uri , $method) {  
    foreach ($this->routes as $route) {  
        if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {  
            return require_once base_path($route['controller']);  
        }  
     }  
        $this->abort();  
    }
 ```
ما ابتدا یک مسیر با متد get یعنی وقتی کاربر در نوار آدرس url درخواست داد  برای نمایش فرم ویرایش یادداشت تعریف میکنیم
 ```php
 $router->add('GET','/laracast-php/public/notes/edit', "controller/note/edit.php");
 ```
دستور بالا  به روتر می‌گوید که وقتی یک درخواست GET به آدرس /laracast-php/public/notes/edit ارسال شد، فایل کنترلر controllers/notes/edit.php را بارگذاری کند.
بعد یک مسیر هم تعریف میکنیم که اگر متد PATCH بود یعنی یک درخواست PATCH به مسیر /laracast-php/public/notes/update شد   کنترلر update.php بارگذاری کن.
 ```php
 $router->patch('/laracast-php/public/notes/update', "controller/note/update.php");
 ```
---
## یادآوری
در فایل index.php موجود در پوشه public ما قبل از اینکه توسط متد route شی router مسیریابی کنیم مقدار متد را جوری تعریف کردیم که اگر _method توسط برنامه نویس postشده بود مقدار متد برابر با این متد postشده اما اگر post نشده مقدار متد برای request کاربر که post یا get خواهد بود سپس با توجه به متد و url مسیریابی به درستی انجام میشود.
```php
$router = new \core\Router();  
require_once base_path('core/routes.php');  
$url =parse_url($_SERVER['REQUEST_URI'])['path'];  
  
$method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'] ;  
$router->route($url, $method);
```


### توضیح Method Spoofing (فریب متد)
مرورگرها به طور native فقط از متدهای GET و POST پشتیبانی می‌کنند.
برای استفاده از متدهای صحیح RESTful مانند PATCH، PUT، یا DELETE، از تکنیک "Method Spoofing" استفاده می‌کنیم.
یک فیلد مخفی در فرم قرار داده می‌شود:

```html
<input type="hidden" name="_method" value="PATCH">
```
روتر ما (که در اپیزودهای قبل پیاده‌سازی شد) این فیلد را بررسی می‌کند و درخواست POST معمولی را به عنوان یک درخواست PATCH تفسیر می‌کند و آن را به مسیر و کنترلر صحیح (update.php) route می‌کند.

---
#### خلاصه ای از فایل های موجود در پوشه controller/note

فایلGET /notes -> index.php -> لیست همه منابع (Read)
فایل GET /notes/show -> show.php ->   نمایش یک منبع خاص (Read)
فایل GET /notes/create -> create.php -> نمایش فرم ایجاد (Create)
فایل POST /notes -> store.php -> ذخیره منبع جدید (Create)
فایل GET /notes/edit -> edit.php -> نمایش فرم ویرایش (Update)
فایل PATCH /notes -> update.php -> به‌روزرسانی منبع (Update)
فایل  DELETE /notes -> destroy.php -> حذف منبع (Delete)

