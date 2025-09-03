این جلسه از دوره PHP Laracasts به صورت عملی و قدم به قدم نحوه پیاده‌سازی **سیستم ورود (Login) و خروج (Logout)** کاربران را پوشش می‌دهد و نکات امنیتی، ساختاری و تجربه کاربری مهم را توضیح می‌دهد.

---
#### ساخت فایل های این جلسه
در پوشه controller یک پوشه با نام sessions ایجاد کرده و درونش فایل ها ی create.php-store.php و destroy.php را ایجاد میکنیم.
- فایل create.php برای مدیریت و نمایش صفحه log in
- فایل store.php برای پردازش و بررسی اطلاعات log in
- فایل destroy.php برای پردازش اطلاعات برای log out
  در پوشه controller/views هم یک فایل با نام create.view.php را ایجاد کرده تا فرم log in  را نمایش دهیم.

---
### فایل create
این فایل برای نمایش فایل create.view و در صورت نیاز برای ارسال داده هایی به این ویو مورد استفاده قرار میگیرد.

### ساخت منو log in  و register
در جلسات قبل در فایل nav کدی نوشته بودیم که اگر سشن user مقداردهی شده بود یک تصویر در بالای سایت نمایش داده شود در غیر اینصورت یک لینک register حالا ما اینجا این تیکه در غیر اینصورتش رو میگیم منوهای register و login رو نشون بده پس کد زیر را در فایل nav مینویسیم:
```php
<?php if($_SESSION['user'] ?? false): ?>  
    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full" />  
    <?php else: ?>  
    //link login
    <a href="/laracast-php/public/login" class="rounded-md <?= ($current == "/laracast-php/public/login") ? " bg-gray-900 text-white " : " text-gray-300 hover:bg-gray-700 hover:text-white ";?> z-50 relative px-3 py-2 text-sm font-medium " <?= ($current == "/laracast-php/public/login") ? "aria-current=page" : "" ;?>> Login</a>  
    //link register
    <a href="/laracast-php/public/register" class="rounded-md <?= ($current == "/laracast-php/public/register") ? " bg-gray-900 text-white " : " text-gray-300 hover:bg-gray-700 hover:text-white ";?> z-50 relative px-3 py-2 text-sm font-medium " <?= ($current == "/laracast-php/public/register") ? "aria-current=page" : "" ;?>> Register</a>  
    
<?php endif; ?>

```
#### نکته
کد لینک های منو register و login رو از کد منوها کخ جلسات قبل ایجاد کردیم برداشتم.
بعد از نوشتن کدبالا به فایل routes.php رفته و مسیر زیر را تعریف میکنیم:
```php
$router->get('/laracast-php/public/login' , "controller/sessions/create.php")->only('guest');
```
یادآوری:متد only("guest") یعنی اگر سشن user مقداردهی شده یا کاربر log in کرده این صفحه رو نشون نده ولی اگر log in یا سشن user مقداردهی نشده این صفحه رو نشون بده.
به صورت امتحانی در فایل create.php یک var_dump میزنیم بعد آدرس بالا را در مرورگر درخواست میدیم اگه خروجی var_dump رو نشون داد پس درست کارکرده.

---
### نمایش فرم ورود
برای نمایش فرم log in از فایل create.view.php استفاده میکنیم محتوای این فایل را از فایل create.view.php ای که برای ثبت نام کاربر نوشته بودیم بر میداریم فقط مقدار متن دکمه و عنوان صفحه را log in کرده و مقدار action فرم را برابر با laracast-php/public/login بعد در فایل routes مسیر زیر را تعریف میکنیم:
```php
$router->post('/laracast-php/public/login' , "controller/sessions/store.php")->only('guest');
```
باز متد only نشان دهنده اینست که کاربری که log in کرده یا سشنuser براش مقداردهی شده نمیتواند از این مسیر استفاده کند و اگر این مسیر را بزند به صفحه اصلی هدایت میشود.
در فایل create.view زیر دکمه فرم کد زیر را میزارم تا اگر کاربرپیدا نشد اینجا خطا بدهد:
```php
<?php if(isset($error['user'])): ?>
    <p class="text-red-500"><?=$error['user'] ?></p>
<?php endif; ?>
```
محتوای فایل ceate.view.php
```php
  
<?= view("partials/nav.php"); ?>  
<?= view("partials/header.php",['heading' => 'Log in']); ?>  
<main>  
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">  
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">  
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Log in</h2>  
        </div>  
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">  
            <form action="/laracast-php/public/login" method="POST" class="space-y-6">  
                <div>                    <label for="email" class="block text-sm/6 font-medium text-black-100">Email</label>  
                    <div class="mt-2">  
                        <input id="email" type="email" name="email" required autocomplete="email" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-green outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />  
                    </div>                    <?php if(isset($error['email'])): ?>  
                        <p class="text-red-500"><?=$error['email'] ?></p>  
                    <?php endif; ?>  
                </div>  
  
                <div>                    <div class="flex items-center justify-between">  
                        <label for="password" class="block text-sm/6 font-medium text-black-100">Password</label>  
                    </div>                    <div class="mt-2">  
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-green outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />  
                    </div>                    <?php if(isset($error['password'])): ?>  
                        <p class="text-red-500"><?=$error['password'] ?></p>  
                    <?php endif; ?>  
                </div>  
  
                <div>                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Log in</button>  
                </div>                <?php if(isset($error['user'])): ?>  
                    <p class="text-red-500"><?=$error['user'] ?></p>  
                <?php endif; ?>  
            </form>  
        </div>    </div>  
</main>  
  
  
<?= view("partials/footer.php"); ?>
```

---
###  پردازش لاگین (store.php)
در این فایل ابتدا فضای نام های مورد نیاز را اضافه کرده و متغیر های emai و password را برابر با مقادیر post شده قرار میدهیم.
```php
use core\Validator;  
use core\Database;  
use core\App;  
  
$email = $_POST['email'];  
$password = $_POST['password'];
```
بعد میریم برای بررسی اعتبارسنجی ایمیل و پسورد با `Validator` که اگر نامعتبر بودند خطلایشان توسط آرایه error به فایل create.view انتقال داده شده و کاربر خطای خود را مشاهده میکند.
```php
if( ! Validator::Validate_email($email) ){  
    $error['email'] = "Invalid email";  
}  
  
$result = Validator::Validate_password($password);  
if (! $result['valid']) {  
    $error['password'] = $result['message'];  
}  
  
if($error) {  
    view("sessions/create.view.php", ['error' => $error]);  
    return;  
}
```
دریافت کاربر از پایگاه داده :
```php
$db = App::resolve(Database::class);  
$user = $db->query("select * from users where email = :email", [':email' => $email])->fetch();
```
اگر کاربر وجود نداشت یعنی ایمیل ارسالی در پایگاه داده موجود نبود دوباره به صفحه log in رفته و پیغام ایمیل موجود نیست نمایش داده میشود:
```php
return view("sessions/create.view.php", ['error'=>["email" => "email not found"]] );
```
اما اگر کاربر وجود داشت رمزعبور بررسی میشود اگر رمزعبور هم درست بود تابع log in اجرا شده یعنی سشن user مقداردهی شده بعد ریدایرکت به صفحه اصلی و با exit یا return پایان کد  اما اگر رمز عبور اشتباه بود به صفحه log in رفته و خطا نمایش داده میشود پس:
اگر ایمیل پیدا نشد:
```php
return view("sessions/create.view.php", ['error'=>["email" => "email not found"]] );
```
اگر پسوورد اشتباه هست:
```php
return view("sessions/create.view.php", ['error'=>['password' => "password is wrong"]] );
```

---
#### نتیجه
پس وقتی کاربر میخواد log in کنه اگر اطلاعات درست وارد بشه وارد صفحه اصلی میشه ایمیلش هم در هدر صفحه نمایش داده میشه اگر ایمیل بزنه که تو پایگاه داده نباشه خطا میده اگر رمز عبور رو هم اشتباه بزنه خطا میده.

---
### تابع login
این تابع به صورت زیر تعریف میشود:
```php
function login($user){  
    $_SESSION['user'] = [  
        'email'=>$user['email']  
    ];  
    session_regenerate_id(true);  
}
```
در این تابع session را مقداردهی میکنیم یعنی کاربر log in کرده بعد به خاطر مسایل امنیتی از تابع session_regenerate_id استفاده میکنیم.

---


### تابع  session_regenerate_id
برای **تولید یک شناسه جدید برای سشن (Session ID)** استفاده می‌شه. در این دستور میتوان session_id قبلی رو هم داشت و یک session_id جدید هم ایجاد کرد در اینصورت قبلی هم هست ولی از این به بعد از جدیده استفاده میشه یا میتوان قبلیه رو کلا پاک کرد و از جدید استفاده کرد.

---
### ساختار تابع:
```php
session_regenerate_id(bool $delete_old_session = false): bool
```
**پارامتر `$delete_old_session`**
- اگر `true` باشه → شناسه قبلی سشن (Session ID) از بین میره و دیگه معتبر نیست.
- اگر `false` باشه → شناسه قبلی باقی می‌مونه و شناسه جدید هم ساخته میشه (یعنی هر دو وجود دارن).
- در هر دوصورت چه شناسه قبلی باشه یا پاک بشه اطلاعات داخل session هستش و پاک نمیشه فقط شناسه تغییر میکند که اینکار برای مسایل امنیتی خیلی خوبه.
  **خروجی تابع**
- اگر موفق باشه `true` برمی‌گردونه، اگر نه `false`.
---
اگر دستور زیر را بنویسیم :
```php
<?php  
	session_start();  
	$_SEESION['set']="first";  
	echo session_id();
```
خروجی چیزی شبیه به متن زیر هست:
```php
efu4iciipg7h4bkjfvvo57offj
```

این همان value مربوط به PHPSESSID  هست.در مرورگر راست کلیک inspect بعد گزینه Application بعد در سمت چپ گزینه Cookies  و بعد کلیک بر روی آدرس اگر session ایجاد کرده باشیم میبینیم که یک PHPSESSID هست که مقدارش برابر با خروجی که دیدیم هست حالا برای تغییر این شناسه یعنی خروجی بالا از تابع session_regenerate_id  استفاده میکنیم پس اگر کد زیر را بزنیم:
```php
<?php  
	session_start();   
	$_SEESION['set']="first";  
	echo session_id();  
	echo "<br>";  
	session_regenerate_id(true);  
	echo session_id();
```
خروجی به صورت زیر میشود:
```php
m7hf742d8u5tjl35dc4itg1dh1  
6v64eudpcsi2db33tvehuipt49
```
حالا اگر مقدار PHPSESSID رو نگاه کنیم میبینم id دومی هست.
در نهایت این تابع  جهت **افزایش امنیت** سایت است (مثلاً جلوگیری از حملات Session Fixation). با این کار اگر هکر ID قبلی را بدست آورده باشد، دیگر قابل سوء‌استفاده نیست چون اون ID پاک شده.

---
### دکمه Log out
به جای یک لینک عادی، باید دکمه لاگ‌اوت در یک فرم با متد POST و هیدن فیلد `_method=delete` قرار گیرد (مطابق اصول REST و امنیت). با کلیک بر روی این دکمه وارد فایل destroy.php داخل پوشه sessions شده و عملیات logout آنجا انجام میشود.
```php
<form action="/laracast-php/public/logout" method="post">  
    <input type="hidden" name="_method" value="delete">  
    <button class="text-white-500">Logout</button>  
</form>
```
با توجه به مقدار action و فیلد مخفی با متد delete به فایل routes.php رفته و مسیر جدید را تعریف میکنیم:
 ```php
 $router->delete('/laracast-php/public/logout' , "controller/sessions/destroy.php")->only('auth');
 ```
 ---
### فایل destroy.php
در این فایل عملیات مربوط به log out یک کاربر انجام میشود.
 ```php
 <?php  
    logout();  
    header('Location: /laracast-php/public');  
    exit;
 ```
### تابع logout
 ```php
 function logout(){  
    $_SESSION = [];  
    session_destroy();  
    $params = session_get_cookie_params();  
    setcookie('PHPSESSID', '', time() - 3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);  
  
}
 ```
بریم سراغ توضیح خط به خط
 ```php
 $_SESSION = [];  
 ```
- اینجا همه‌ی داده‌های داخل **آرایه‌ی سشن** رو پاک می‌کنیم.
- یعنی اگر چیزی مثل `SESSION['user']_$` یا `SESSION['cart']_$` وجود داشت، خالی میشه.
- ❗ اما این فقط متغیرهای سشن داخل PHP رو پاک می‌کنه، فایل سشن روی سرور همچنان وجود داره.
- اگر به پوشه Xampp/tmp  مراجعه کنیم فایل ها موجود هست.
```php
session_destroy();  
```
- این خط میاد و **کل سشن فعال رو در سمت سرور نابود می‌کنه**.
- یعنی فایل فیزیکی مربوط به Session ID توی پوشه‌ی `sessions` (مسیر پیش‌فرض PHP) پاک میشه.
- ولی همچنان **کوکی مرورگر کاربر** (`PHPSESSID`) باقی می‌مونه.
```php
$params = session_get_cookie_params();  
```
- اینجا تنظیمات فعلی کوکی‌های سشن رو برمی‌گردونه.
- خروجی یک آرایه‌ست مثل این:
```php
[
  "lifetime" => 0,
  "path" => "/",
  "domain" => "",
  "secure" => false,
  "httponly" => true
]
```
ما این اطلاعات رو می‌گیریم تا دقیقاً همون ویژگی‌هایی که قبلاً برای کوکی سشن تنظیم شده بود رو دوباره استفاده کنیم.

```php
setcookie('PHPSESSID', '', time() - 3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);
```
- این خط میاد و کوکی **`PHPSESSID`** (که شناسه سشن رو ذخیره می‌کنه) رو با مقدار خالی (`''`) و زمان انقضای گذشته (`time() - 3600`) دوباره می‌سازه.
- نتیجه → مرورگر کوکی مربوط به سشن رو حذف می‌کنه.
- استفاده از `$params` باعث میشه دقیقاً با همون تنظیمات قبلی (path, domain, secure, httponly) حذف بشه و مشکلی پیش نیاد.
### 📌 در کل این تابع:

1. همه داده‌های سشن در PHP پاک میشن.
2. فایل سشن روی سرور نابود میشه.
3. کوکی سشن از مرورگر کاربر حذف میشه.

➡️ بعد از این سه مرحله، کاربر دیگه هیچ دسترسی به سشن قبلی نداره و عملاً **کامل Logout شده**.

---

🔑 نکته:
- اگر فقط `session_destroy()` صدا بزنی، کاربر همچنان کوکی سشن توی مرورگرش رو داره.
- اگر فقط کوکی رو پاک کنی، فایل سشن سرور باقی می‌مونه.
- برای همین ترکیب این سه مرحله لازمه تا کامل Logout انجام بشه.
  سوال: من بعد از log out وقتی با inspect مقدار PHPSESSID رو نگاه میکنم میبنم logout  شناسه id قبلی رو پاک کرده ولی یه شناسه جدید هست ؟
  وقتی `logout()` رو صدا می‌زنی، کوکی قبلی پاک میشه (تست`print_r($_COOKIE)` → درست پاک شده).
  اما اگر **بعدش یا توی همون صفحه یا فایل دیگه‌ای** دوباره `session_start()` اجرا بشه، PHP به طور خودکار یک **سشن جدید** درست می‌کنه.
  برای همین توی DevTools می‌بینی دوباره یک `PHPSESSID` جدید ساخته شده.

- دستور`session_start()` یعنی:
1. اگر کاربر **کوکی سشن معتبر داشت** → همونو ادامه بده.
2. اگر **نداشت** → یک **Session ID جدید بساز** و کوکی جدید `PHPSESSID` بده.
   به همین دلیل بعد از لاگ‌اوت، چون کوکی پاک شده، PHP در اولین `session_start()` بعدی میگه:  
   «خب، کاربر هیچ سشنی نداره → پس براش یکی جدید می‌سازم.»

---
## سوال خیلی مهم
منوهای سایت رو جوری کنید که وقتی کاربر log in  کرده منوی notes نمایش داده شود وقتی log in نکرده نمایش داده نشود؟
آرایه زیر شامل عنوان و مسیر لینک منوها هست.
```php
<?php  
    $pages =[  
        "/laracast-php/public/" => "Dashboard",  
        "/laracast-php/public/about" => "About",  
        "/laracast-php/public/contact"=> "Contact",  
        "/laracast-php/public/notes"=> "Notes"  
    ];  
    $current = parse_url($_SERVER['REQUEST_URI'])['path'];  
?>
```

در کد زیر اگر مقدار value برابر با notes بود وارد شرطی میشیم که کاربر log in کرده یا نه که اگر کرده بود نمایش و اگر نه نمایش داده نشود بعد اگر value برابر notes نبود که هیچ منو نمایش داده شود.
```php
<?php foreach ($pages as $key => $value): ?>  
            <?php if ($value == "Notes"): ?>  
                <?php if ($_SESSION['user'] ?? false) : ?>  
                    <a href="<?=$key ?>" class="rounded-md <?= ($current == $key) ? " bg-gray-900 text-white " : " text-gray-300 hover:bg-gray-700 hover:text-white "; ?>  px-3 py-2 text-sm font-medium " <?= ($current == $key) ? "aria-current=page" : "" ;?>> <?= $value ?></a>  
                <?php endif; ?>  
            <?php else : ?>  
            <a href="<?=$key ?>" class="rounded-md <?= ($current == $key) ? " bg-gray-900 text-white " : " text-gray-300 hover:bg-gray-700 hover:text-white "; ?>  px-3 py-2 text-sm font-medium " <?= ($current == $key) ? "aria-current=page" : "" ;?>> <?= $value ?></a>  
        <?php endif; ?>  
    <?php endforeach; ?>  
</div>
```
یه روش دیگه هم اینست که در آرایه pages منوی notes ننویسیم بعد بگیم اگر کاربر log in کرده بود این مقدار را بریز اگر نه نریز:
```php
if($_SESSION['user'] ?? false){  
    $pages["/laracast-php/public/notes"]= "Notes";  
}
```