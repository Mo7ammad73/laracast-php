### ۱. مرور جلسه قبلی
- جلسه قبل (۴۲) اومدیم  در فایل store که شامل چند بخش بود و ما میخواستیم refactorش کنیم بخش **اعتبارسنجی ورودی‌ها** (ایمیل و پسورد) رو در یک کلاس جدا (`LoginForm`) قرار دادیم.
- این باعث شد که کد مرتب‌تر و قابل‌خواندن‌تر بشه.
---
### ۲. ادامه Refactoring – ایجاد `Authenticator`
- حالا جفری میگه: قسمت بعدی مربوط به **اعتبارسنجی کاربر** هست (یعنی پیدا کردن کاربر در دیتابیس و بررسی رمز).
- پس یک کلاس جدید به نام `Authenticator` در پوشه `core` می‌سازیم.
  کد اولیه:
```php
<?php
namespace core;

class Authenticator
{
    public function attempt($email, $password)
    {
        //
    }
}

```
و در فایل store کد به صورت زیر میشود :
```php
$auth = new authenticator();  
if( $auth->attempt($email, $password) ) {  
    
}else  
{  
    
}
```
توابع login و logout رو هم از فایل function برداشته و در کلاس authenticator قرار میدهیم:
```php
<?php  
    namespace core\authenticator;  
  
    class authenticator  
    {  
        public function attempt($email, $password){  
  
        }  
  
        public function login($user){  
            $_SESSION['user'] = [  
                'email'=>$user['email']  
            ];  
            session_regenerate_id(true);  
        }  
        public function logout(){  
            $_SESSION = [];  
            session_destroy();  
            $params = session_get_cookie_params();  
            setcookie('PHPSESSID', '', time() - 3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);  
  
        }  
    }
```
---
### ۳. تغییر در `store.php`

قبلاً کدی مثل زیر داشتیم:
```php
if (! $form->validate($email, $password)) {
    view("sessions/create.view.php", ['error' => $form->getErrors()]);
    return;
}
```
حالا بعد از اعتبارسنجی ورودی، میریم سراغ احراز هویت کاربر با `Authenticator`:
```php
$auth = new Authenticator();

if ($auth->attempt($email, $password)) {
    redirect('/laracast-php/public/');
} else {
    return view("sessions/create.view.php", [
        'error' => ['email' => "No Matching Account Found for that email address and password"]
    ]);
}

```
---
### ۴. تکمیل متد `attempt`

الان باید منطق تلاش برای لاگین داخل `attempt` پیاده بشه:
- کاربر رو بر اساس ایمیل پیدا کن.
- اگه پیدا شد، پسورد رو بررسی کن.
- اگه درست بود، `login()` رو صدا بزن و **true** برگردون.
- در غیر این صورت **false** برگردون.

کد درست‌شده:
```php
public function attempt($email, $password)
{
    $db = \core\App::resolve(\core\Database::class);

    $user = $db->query("SELECT * FROM users WHERE email = :email", [
        ':email' => $email
    ])->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $this->login($user);
        return true;
    }

    return false;
}

```
🔑 نکته مهم:  
جفری تاکید می‌کنه که **`Authenticator` نباید بدونه ریدایرکت کجا باید انجام بشه**.  
این وظیفه‌ی کنترلر (`store.php`) هست که تصمیم بگیره اگر لاگین موفق بود چه کنه (مثلا ریدایرکت به صفحه اصلی)، و اگر ناموفق بود چه کنه (مثلا نمایش view با خطا).  
بنابراین `attempt` فقط یک **Boolean** برمی‌گردونه.

---
### ۵. تابع `redirect`
چون هربار کد header و  exit تکرار میشد پس جفری یک تابع به عنوان helper ایجاد کرد تا از تکرار جلوگیری شود.
```php
function redirect($path)
{
    header("Location: {$path}");
    exit();
}
```
---
### ۶. جمع‌بندی منطق جدید

- فایل`LoginForm` → اعتبارسنجی **ورودی‌ها** (ایمیل و پسورد خالی نباشه و…).
- فایل`Authenticator` → اعتبارسنجی **کاربر واقعی** (بررسی در دیتابیس + پسورد).
- فایل`Controller (store.php)` → تصمیم‌گیری درباره اینکه بعد از لاگین موفق یا ناموفق چه اتفاقی بیفته.
---
در فایل LoginForm یک متد adderror ایجاد میکنیم تا اگر داخل کلاس خواستیم error را نگه داریم از این متد استفاده کنیم:
```php
public function adderror($field ,  $message){  
    $this->errors[$field] = $message;  
}
```
حالا در فایل store برای استفاده از این متد:
```php
$auth = new authenticator();  
if( $auth->attempt($email, $password) ) {  
    Redirect("laracast-php/public");  
}
$form->adderror('email','No Matching Account Found for that email address and password');  //مقداردهی آرایه 
return view("sessions/create.view.php" ,['error' => $form->getErrors()] ); //errorبرداشتن مقدارداده شده به آرایه
```
حتما دقت شود مقدار را بین دوبراکت [] قرار داد یعنی:
```php
return view("sessions/create.view.php" ,['error' => $form->getErrors()] );//درست
return view("sessions/create.view.php" ,'error' => $form->getErrors() );//خطا
```

---
---
## 🔹 بخش دوم – بحث `if/else` اضافه

جفری میگه وقتی داخل شرط `if` ریدایرکت می‌کنیم، عملاً اسکریپت `exit()` میشه.  
پس کدی که بعدش توی `else` بیاد هیچ‌وقت اجرا نمیشه.
یعنی این:
```php
if ($auth->attempt($email, $password)) {
    redirect('/');
} else {
    return view("sessions/create.view.php", [
        'error' => ['email' => "No Matching Account Found for that email address and password"]
    ]);
}
```
میتونه این بشه:
```php
if ($auth->attempt($email, $password)) {
    redirect('/');
}

return view("sessions/create.view.php", [
    'error' => ['email' => "No Matching Account Found for that email address and password"]
]);
```
📌 اینجا `else` اضافه است، چون ریدایرکت اسکریپت رو قطع می‌کنه.

---
## 🔹 بخش سوم – تمیز کردن Importها

قبلاً متغیر `$db` رو داشتیم، ولی چون رفت داخل کلاس `Authenticator` دیگه لازم نیست.  
پس importهای اضافی مثل `Database` رو هم حذف می‌کنیم.یعنی useهایی که اون بالا زدیم بعضیاش رو باید پاک کرد.

---
## 🔹 بخش چهارم – مشکل تکرار کد (Duplication)

الان دو جای مختلف داریم که کار مشابهی می‌کنن:
1. وقتی اعتبارسنجی فرم (`LoginForm`) شکست بخوره → برگردیم به ویو با خطاها.
2. وقتی کاربر در دیتابیس پیدا نشه → دوباره برگردیم به ویو، این بار با پیام خطای جدید.

🔴 مشکل: هر دو برمی‌گردن به یک view، فقط متن خطا فرق می‌کنه.
همینجا در بخش هفتم این مشکل حل میشود.

---
## 🔹 بخش پنجم – استراتژی ریفکتور

جفری میگه: وقتی دو کد **۹۰٪ مشابه** و **۱۰٪ متفاوت** داری، سعی کن اون ۱۰٪ متفاوت رو طوری تغییر بدی که هر دو **کاملاً یکسان** بشن.  
بعدش می‌تونی کد رو ادغام کنی.

---

## 🔹 بخش ششم – اضافه کردن متد `error` به LoginForm

ایده: به جای اینکه خطای دوم رو مستقیم هاردکد کنیم، بیایم به `LoginForm` یک خطا **اضافه کنیم**.
```php
public function adderror($field, $message)
{
    $this->errors[$field] = $message;
}
```
حالا وقتی لاگین ناموفق بود:
```php
$form->adderror('email', 'No Matching Account Found for that email address and password');
```
البته کد بالا فقط مقدار رو در خاصیت error میریزه برای استفاده از مقدار ریخته شده بایدبعد از adderror از متد geterror استفاده کنیم.

---
## 🔹 بخش هفتم – یکپارچه‌سازی کد
الان هر دو حالت (اعتبارسنجی ناموفق یا احراز هویت ناموفق) یک خروجی دارن:
- بازگشت به ویو `sessions/create.view.php`
- ارسال لیست خطاها از `LoginForm`
  به کد زیر توجه کنید که چه کدهایی تکرار میشود:
```php
if (! $form->validate($email, $password)){  
    view("sessions/create.view.php", ['error' => $form->getErrors()]);  
    exit();  
}  
$auth = new authenticator();  
if( $auth->attempt($email, $password) ) {  
    Redirect("/laracast-php/public");  
}  
$form->adderror('email','No Matching Account Found for that email address and password');  
return view("sessions/create.view.php" ,['error' => $form->getErrors()] );
```
کد زیر تکرار شده است:
```php
view("sessions/create.view.php", ['error' => $form->getErrors()]);  
```
پس میشه کد رو اینطوری مرتب کرد اگر بعد validate فیلدهای ورودی خطایی وجود نداشت بیاد احراز هویت رو بررسی کند اما اگر خطایی وجود داشت بیرون if برود و خطاها را نمایش دهد حالا در احراز هویت اگر خطایی وجود نداشت redirect میشه در نتیجه کد این صفحه همینجا تمام میشود اما اگر مشکل داشت خطا را توسط متد adderror مینویسیم بعد بیرون if نمایش میدهیم.کد مرتب شده را در زیر میبینید:
```php
$form = new LoginForm();

if ($form->validate($email, $password)) {
    $auth = new Authenticator();

    if ($auth->attempt($email, $password)) {
        redirect('/');
    }

    // اگر پسورد یا ایمیل در دیتابیس پیدا نشد
    $form->error('email', 'No Matching Account Found for that email address and password');
}

// در نهایت، چه اعتبارسنجی فرم شکست بخوره چه احراز هویت
return view("sessions/create.view.php", [
    'error' => $form->getErrors()
]);
```
---
## 🔹 بخش هشتم – نکات سبک (Style Choices)

- جفری میگه بعضی وقتا متغیر `$auth` رو فقط یک‌بار استفاده می‌کنیم → پس میشه مستقیم `new Authenticator()` نوشت بدون تعریف متغیر.
- پرانتز خالی هم اجباری نیست:
```php
$auth = new Authenticator;
```
- همه اینا سلیقه‌ای هستن.
---

## 🔹 بخش نهم – جمع‌بندی

حالا جریان `store.php` اینطوری میشه:
1. ساخت `LoginForm`
2. اعتبارسنجی ورودی‌ها
3. اگر ورودی معتبر بود → تلاش برای لاگین (`attempt`)
4. اگر موفق بود → `redirect('/')`
5. اگر ناموفق بود → اضافه کردن خطا به فرم
6. در نهایت همیشه بازگشت به ویو `sessions/create.view.php` همراه با خطاها

---

✅ نتیجه: کدی داریم که هم ساده‌تر شده، هم بدون تکرار (DRY)، هم مسئولیت‌ها بین کلاس‌ها درست تقسیم شده.

---
---


نسخه نهایی سه فایل بعد از پایان جلسه ۴۳ رو یکجا مرور کنیم.

---

## 🔹 فایل `store.php`
```php
<?php  
 
use core\authenticator;  
use http\Forms\LoginForm;  
  
$email = $_POST['email'];  
$password = $_POST['password'];  
  
$form = new LoginForm();  
if ($form->validate($email, $password)){  
    $auth = new authenticator();  
    if( $auth->attempt($email, $password) ) {  
        Redirect("/laracast-php/public");  
    }  
    $form->adderror('email','No Matching Account Found for that email address and password');  
}  //اگر اعتبارسنجی فیلدها مشکل داشت یا احراز هویت کاربر به این خط زیر میرسیم
return view("sessions/create.view.php" ,['error' => $form->getErrors()] );
```

---

## 🔹 فایل `LoginForm.php`

```php
<?php  
  
namespace http\Forms;  
  
use core\Validator;  
  
class LoginForm  
{  
   protected $error = [];  
    public function validate($email, $password){  
        if( ! Validator::Validate_email($email) ){  
            $this->error['email'] = "Invalid email";  
        }  
  
        $result = Validator::Validate_password($password);  
        if (! $result['valid']) {  
            $this->error['password'] = $result['message'];  
        }  
        return empty($this->error);  
    }  
  
    public function getErrors(){  
        return $this->error;  
    }  
    public function adderror($field ,  $message){  
        $this->error[$field] = $message;  
    }  
}
```
---

## 🔹 فایل `Authenticator.php`
```php
<?php  
    namespace core;  
    use core\App;  
    use core\Database;  
  
    class authenticator  
    {  
        public function attempt($email, $password){  
  
            $db = App::resolve(Database::class);  
            $user = $db->query("select * from users where email = :email", [':email' => $email])->fetch();  
            if($user){  
                if(password_verify($password, $user['password'])) {  
                    $this->login(["email" => $email]);  
//                    header("location: /laracast-php/public");  
                    return true;  
                }  
            }  
            return false;  
        }  
  
        public function login($user){  
            $_SESSION['user'] = [  
                'email'=>$user['email']  
            ];  
            session_regenerate_id(true);  
        }  
        public function logout(){  
            $_SESSION = [];  
            session_destroy();  
            $params = session_get_cookie_params();  
            setcookie('PHPSESSID', '', time() - 3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);  
  
        }  
    }
```

---

## 🔹 فایل `functions.php` (آپدیت شده)

```php
<?php

function redirect($path)
{
    header("Location: {$path}");
    exit();
}

```
## نکته
مقدار آدرس وارد شده برای header مقابل location باید با / شروع شود یعنی
```php
Redirect("/laracast-php/public");//درست
Redirect("laracast-php/public");//غلط
```

---

✅ با این ساختار، ما الان:

- مسئولیت **اعتبارسنجی ورودی‌ها** رو به `LoginForm` سپردیم.
- مسئولیت **اعتبارسنجی کاربر واقعی** (دیتابیس + پسورد) رو به `Authenticator`.
- کنترلر (`store.php`) فقط تصمیم می‌گیره که بعد از موفقیت یا شکست چه اتفاقی بیفته.