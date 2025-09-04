### معنی Refactoring
بازنویسی و تمیز کردن کد بدون تغییر در عملکرد.
- توی مرحله اول برنامه‌نویسی، مهم‌ترین چیز اینه که کد کار کنه.
- اما بعداً متوجه می‌شی فقط "کار کردن" کافی نیست؛ باید خوانا، تمیز، قابل استفاده مجدد و خلاقانه باشه در واقع :
- **مرحله اول یادگیری برنامه‌نویسی** → فقط می‌خوای کد کار کنه، هرجور شد!
- **مرحله بعدی** → می‌فهمی که صرفاً "کار کردن" کافی نیست؛ کد باید خوانا، شفاف، قابل استفاده مجدد و قابل فهم برای خودت و دیگران باشه.
  معنی **Refactoring** دقیقاً همینه:  
  بازنویسی و تمیزکاری کد **بدون تغییر در عملکرد نهایی**، برای اینکه:
- واضح‌تر بشه
- خواناتر بشه
- قابل توسعه و استفاده مجدد بشه
- خلاقیتت رو نشون بده
---
در مرحله ی بعدی به پوشه controller/sessions و فایل store.php رفته و میگه:
کدی که در جلسه قبل نوشتیم کار می‌کنه، اما **واضح و تمیز نیست**.
- وظیفه‌ی کد فعلی:
1. اعتبارسنجی فرم لاگین
2. تلاش برای ورود کاربر
3. ریدایرکت یا بازگشت به صفحه‌ی لاگین        
   مشکل: فهمیدن کد سخت و گیج‌کننده است.
- راه‌حل: شروع refactoring با جدا کردن بخش‌ها و نام‌گذاری بهتر.
- اولین قدم: ساخت **کلاس LoginForm** برای مدیریت اعتبارسنجی.
---
یک پوشه http ایجاد کرده و پوشه controller را به این پوشه انتقال میدهیم بعد به فایل routes رفته و آدرس ها رو به صورت زیر تغییر میدهیم:
#### آدرس های قدیم:
```php
$router->add('GET','/laracast-php/public/', "controller/index.php");  
$router->add('GET','/laracast-php/public/about', "controller/about.php");  
$router->add('GET','/laracast-php/public/contact', "controller/contact.php");  
$router->add('GET','/laracast-php/public/notes', "controller/note/index.php")->only('auth');  
$router->add(['GET' , 'POST'],'/laracast-php/public/notes/create', "controller/note/create.php");  
$router->add(['GET' , 'POST'],'/laracast-php/public/notes/note', "controller/note/show.php");  
$router->delete('/laracast-php/public/notes/note' , "controller/note/destroy.php");  
$router->post('/laracast-php/public/notes/store', "controller/note/store.php");  
$router->add('GET','/laracast-php/public/notes/edit', "controller/note/edit.php");  
$router->patch('/laracast-php/public/notes/update', "controller/note/update.php");  
$router->get('/laracast-php/public/register' , "controller/registeration/create.php")->only('guest');  
$router->post('/laracast-php/public/register' , "controller/registeration/store.php");  
$router->get('/laracast-php/public/login' , "controller/sessions/create.php")->only('guest');  
$router->post('/laracast-php/public/login' , "controller/sessions/store.php")->only('guest');  
$router->delete('/laracast-php/public/logout' , "controller/sessions/destroy.php")->only('auth');
```
### آدرس های جدید:
```php
$router->add('GET','/laracast-php/public/', "http/controller/index.php");  
$router->add('GET','/laracast-php/public/about', "http/controller/about.php");  
$router->add('GET','/laracast-php/public/contact', "http/controller/contact.php");  
$router->add('GET','/laracast-php/public/notes', "http/controller/note/index.php")->only('auth');  
$router->add(['GET' , 'POST'],'/laracast-php/public/notes/create', "http/controller/note/create.php");  
$router->add(['GET' , 'POST'],'/laracast-php/public/notes/note', "http/controller/note/show.php");  
$router->delete('/laracast-php/public/notes/note' , "http/controller/note/destroy.php");  
$router->post('/laracast-php/public/notes/store', "http/controller/note/store.php");  
$router->add('GET','/laracast-php/public/notes/edit', "http/controller/note/edit.php");  
$router->patch('/laracast-php/public/notes/update', "http/controller/note/update.php");  
$router->get('/laracast-php/public/register' , "http/controller/registeration/create.php")->only('guest');  
$router->post('/laracast-php/public/register' , "http/controller/registeration/store.php");  
$router->get('/laracast-php/public/login' , "http/controller/sessions/create.php")->only('guest');  
$router->post('/laracast-php/public/login' , "http/controller/sessions/store.php")->only('guest');  
$router->delete('/laracast-php/public/logout' , "http/controller/sessions/destroy.php")->only('auth');
```
در آدرس های جدید http/ به همه ی کنتربر ها اضافه شده بعد به فایل function.php رفته و کد تابع view رو هم تغییر میدهیم:
```php
function view($path , $attributes = []){  
    extract($attributes);  
    require base_path("http/controller/views/".$path);  
}
```
بعد به فایل Bootstrap.php رفته و اون قسمتی که config را require میکنیم هم آدرسش رو تغییر میدیم:
```php
$config = require base_path('http/controller/config.php');
```
میتوان به جای اینکه در فایل routes به تک تک مسیرها http/ را اضافه کنیم میتوانستیم controllerها رو از اینجا حذف و بعد به فایل router متد route رفته واونجا یه http/controller اضافه کنیم:
```php
public function route($uri , $method) {  
    foreach ($this->routes as $route) {  
        if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {  
            if($route['middleware']) {  
                Middleware::resolve($route['middleware']);  
            }  
            return require_once base_path("http/controller/" . $route['controller']);  
        }  
    }  
    $this->abort();  
}
```
وبعد مسیرها به صورت زیر میشدند:
```php
$router->add('GET','/laracast-php/public/', "index.php");  
$router->add('GET','/laracast-php/public/about', "about.php");  
$router->add('GET','/laracast-php/public/contact', "contact.php");  
$router->add('GET','/laracast-php/public/notes', "note/index.php")->only('auth');  
$router->add(['GET' , 'POST'],'/laracast-php/public/notes/create', "note/create.php");  
$router->add(['GET' , 'POST'],'/laracast-php/public/notes/note', "note/show.php");  
$router->delete('/laracast-php/public/notes/note' , "note/destroy.php");  
$router->post('/laracast-php/public/notes/store', "note/store.php");  
$router->add('GET','/laracast-php/public/notes/edit', "note/edit.php");  
$router->patch('/laracast-php/public/notes/update', "note/update.php");  
$router->get('/laracast-php/public/register' , "registeration/create.php")->only('guest');  
$router->post('/laracast-php/public/register' , "registeration/store.php");  
$router->get('/laracast-php/public/login' , "sessions/create.php")->only('guest');  
$router->post('/laracast-php/public/login' , "sessions/store.php")->only('guest');  
$router->delete('/laracast-php/public/logout' , "sessions/destroy.php")->only('auth');
```
---
حالا میریم سراغ کلاس LoginForm
درپوشه http یک پوشه با نام Forms ایجاد و درونش یک فایل کلاس با نام LoginForm ایجاد میکنیم:
کدش به صورت زیر هست:
```php
<?php  
	namespace Forms;  
	class LoginForm  
	{  
	}
```
به قسمت namespace یک http اضافه میکنیم:
```php
<?php  
namespace http\Forms;  
class LoginForm  
{  
}
```
چون قبلا هم گفته بودم به خاطر استفاده از spl_autoload_register باید مسیر و نام کلاس و فضای نام یکی باشد.
حالا به پوشه sessions فایل store.php رفته و اون تیکه کدی که مربوط به validate هست را برمیداریم یعنی کد زیر :
```php
$error = [];  
  
if( ! Validator::Validate_email($email) ){  
    $error['email'] = "Invalid email";  
}  
  
$result = Validator::Validate_password($password);  
if (! $result['valid']) {  
    $error['password'] = $result['message'];  
}  
```
بعد به فایل کلاس LoginForm رفته یک متد validate تعریف کرده و درون آن کد بالا را قرار میدهیم:
```php
public function validate($email, $password){  
    $error = [];  
  
    if( ! Validator::Validate_email($email) ){  
        $error['email'] = "Invalid email";  
    }  
  
    $result = Validator::Validate_password($password);  
    if (! $result['valid']) {  
        $error['password'] = $result['message'];  
    }  
    return empty($error);  
}
```
فقط خط آخر را خودمان اضافه کردیم تا نتیجه اینکه error داریم یا نه را برگردانیم.
حالا به فایل store.php رفته و به صورت زیر از کلاس مورد نظر استفاده میکنیم:
```php
$form = new \http\Forms\LoginForm();  
if ($form->validate($email, $password)){  
  
}
```
فقط یک مشکلی که داریم اینست که ما از کلاس LoginForm نمیتوانیم مقدار error$ را به اینجا انتقال بدیم برای حل این مشکل در کلاس یک خاصیت error تعریف میکنیم به جای آرایه Error بعد داخل این خاصیت خطاها رو میریزیم بعد توسط یه متد دیگه از این کلاس مثلا geterrorsاین خاصیت رو برمیگردونیم پس در کلاس کد زیر را مینویسیم:
```php
<?php  
  
namespace http\Forms;  
use core\Validator;  
class LoginForm  
{  
   protected $errors = [];  
    public function validate($email, $password){  
        if( ! Validator::Validate_email($email) ){  
            $this->$errors['email'] = "Invalid email";  
        }  
  
        $result = Validator::Validate_password($password);  
        if (! $result['valid']) {  
            $this->$errors['password'] = $result['message'];  
        }  
        return empty($this->$errors);  
    }  
  
    public function getErrors(){  
        return $this->errors;  
    }  
}
```
و در فایل store.php به شکل زیر از کلاس استفاده میکنیم:
```php
$form = new \http\Forms\LoginForm();  
if (! $form->validate($email, $password)){  
    view("sessions/create.view.php", ['error' => $form->getErrors()]);  
    return;  
}
```
---

### مروری بر جریان جلسه 42 (Refactoring Login Form)

1. **شروع Refactoring**
    - جفری می‌گه کدی که در جلسه قبل نوشتیم (login validation) کار می‌کنه اما شفاف نیست.
    - هدف: کد رو بازنویسی کنیم تا **خواناتر و قابل فهم‌تر** باشه.
2. **ایده‌ی کلاس `LoginForm`**
    - تصمیم می‌گیره یک کلاس `LoginForm` بسازه.
    - وظیفه‌ی این کلاس: مدیریت اعتبارسنجی (validation) فرم ورود.
3. **انتقال منطق اعتبارسنجی به `LoginForm`**
    - به جای اینکه درون Controller دستی چک کنیم، یک متد `validate()` می‌نویسه.
    - ابتدا به صورت ساده ورودی‌ها (ایمیل و پسورد) رو پاس می‌ده و چک می‌کنه.
4. **بهبود خروجی متد `validate`**
    - اول `validate` آرایه‌ی خطاها رو برمی‌گردونه.
    - اما جفری تغییرش می‌ده که فقط یک **Boolean (true/false)** برگردونه:
    - اگر خطا نبود → `true` (اعتبارسنجی موفق)
    - اگر خطا بود → `false`
5. **مدیریت خطاها با property و getter**
- یک property به نام `errors` تعریف می‌کنه.
- این property محافظت‌شده (`protected`) هست.
-  برای دسترسی بیرونی یک **getter method** می‌سازه (`errors()`) تا بیرون بتونن خطاها رو بگیرن بدون دستکاری مستقیم.
1. **سادگی و وضوح بیشتر**
- حالا در Controller می‌تونه خیلی شفاف بگه:
  `if (! $form->validate(email, password)) {     return view('login.view.php', [         'errors' => $form->errors()     ]); }`
  این خیلی ساده‌تر و قابل فهم‌تر از حالت قبلیه که پر از شرط و آرایه‌سازی بود.
7. **تست Refactor**
- جفری پسورد رو عمداً محدود به ۵ کاراکتر می‌کنه تا خطا بخوره و ببینه درست کار می‌کنه.
- وقتی درست شد، محدودیت رو برمی‌داره و ورود موفقیت‌آمیز رو تست می‌کنه.
1. **پایان جلسه (Cliffhanger)**
- می‌گه: "این اولین refactor ما بود، کار می‌کنه، ولی هنوز خیلی چیزها برای تمیز کردن داریم که در جلسه بعد ادامه می‌دیم."