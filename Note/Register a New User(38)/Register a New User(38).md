# # جلسه ۳۸ (Register a New User)

## هدف:

- ساخت فرم **ثبت‌نام کاربر جدید (User Registration)**
- ذخیره کاربر در پایگاه داده
- مدیریت وضعیت ورود کاربر توسط **Session**

---

## 🔹 گام ۱: ایجاد ساختار فایل‌ها

در ابتدا برای سازمان‌دهی مسیرها و کنترلرها:

1. پوشه جدید در مسیر `controllers` می‌سازیم با نامregistration
2. داخل این پوشه، فایلی برای نمایش فرم ثبت‌نام با نام create.php ایجاد میکنیم.
   و بعد فایلی به اسم store.php برای پردازش داده های ارسالی فرم میسازیم.

---

## 🔹 گام ۲: ایجاد View برای فرم ثبت‌نام

در پوشه `views` نیز پوشه‌ی مشابه ایجاد می‌کنیم:

`views/registration/create.view.php`

مقدار اولیه با استفاده از یکی از ویوهای آماده (مثلا `index.view.php`) کپی می‌شود:

```php
  
<?= view("partials/nav.php"); ?>  
<?= view("partials/header.php",['heading' => 'Register']); ?>  
    <main>  
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">  
            <p>  Register Page   </p>  
        </div>  
    </main><?= view("partials/footer.php"); ?>
```
---
## 🔹 گام ۳: تعریف Route برای فرم

در فایل `routes.php`:
```php
$router->get('/laracast-php/public/register' , "controller/registeration/create.php");
```
اکنون با مراجعه به `/laracast-php/public/register، فرم خالی را داریم.

---
## 🔹 گام ۴: طراحی فرم (Tailwind)

یک فرم آماده از TailwindUI را باید کپی کنیم پس به سایت tailwindui رفته و کلمه form را جستجو کرده بعد  sign in and registerرا انتخاب کرده و کدش را کپی و در فایل create.view.php جای گذاری میکنیم.

**اصلاحات کلیدی فرم:**

- تغییر عنوان به Register
- حذف بخش _Forgot password_ و _Free trial_
  فقط دو فیلد پسوورد و ایمیل labale ,input و یک دکمه نگه داشته شود.
- مقدار `action` فرم:
```php
<form action="/laracast-php/public/register" method="POST" class="space-y-6">
```
---
## 🔹 گام ۵: اضافه کردن نمایش پیام خطا زیر فیلدها

اضافه کردن این قطعه زیر ایمیل:

```php
<?php if(isset($error['email'])): ?>  
    <p class="text-red-500"><?=$error['email'] ?></p>  
<?php endif; ?>
```
و مشابه آن برای پسورد.

**نکته:** آرایه error در صورت وجود خطا در اعتبارسنجی فرم در فایل store پرشده و دراینجا نمایش داده میشود.


---

## 🔹 گام ۶: مسیر POST برای ثبت‌نام

در `routes.php`:
```php
$router->post('/laracast-php/public/register' , "controller/registeration/store.php");
```
یعنی وقتی با آدرس مشخص شده متد post فرستاده شد وارد فایل store شویم.

---
## 🔹 گام ۷: کنترل داده‌های ارسال‌شده (store.php)

ابتدا داده‌ها را می‌گیریم:
```php
$email = $_POST['email'];  
$password = $_POST['password'];
```

---
## 🔹 گام ۸: اعتبارسنجی (Validation)

از کلاس Validator استفاده می‌کنیم   وابتدا یک آرایه error تعریف کرده سپس دو فیلد ایمیل و پسوورد را با کلاس Validatore و متدهایش اعتبارسنجی میکنیم در صورت وجود مشکل آرایه error شامل مقدار میشود و در غیر اینصورت خالی میماند :
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
اما با دستور زیر تعریف میکنیم  خطا وجود داشت یعنی error شامل مقدار بود پس کاربر دوباره به صفحه ثبت نام بره و علت خطاهایش رو هم بفهمه بعد با یه return  میگیم کد همینجا قطع بشه و کدهای بعدی اجرا نشود:

```php
if($error) {  
    view("registeration/create.view.php", ['error' => $error]);  
    return;  
}
```

---
## 🔹 گام ۹: بررسی وجود کاربر در دیتابیس

ابتدا اتصال به دیتابیس:

```php
$db = App::resolve(Database::class);  
$user = $db->query("select * from users where email = :email", [':email' => $email])->get();
```
توسط دستور بالا یک شی پایگاه داده ایجاد کرده و سپس یه دستور query وری این شی میزنیم که تمام رکوردهایی که فیلد ایمیلشان برابر با ایمیل post شده هست را برگرداند.
اگر **کاربر موجود بود** یعنی دستور بالا شامل رکورد شد → فعلا به صفحه اصلی هدایت کنیم (در آینده به login):
```php
if ($user){  
    header("Location:/laracast-php/public/");  
}
```
اما  اگر **کاربر جدید است** → اضافه به دیتابیس و ثبت اطلاعات در **Session** پس :
```php
else{  
    $db->query("INSERT INTO users (email, password) values (:email, :password)", [':email' => $email, ':password' => $password]);  
    $_SESSION['user'] =[  'email' => $email  ];  
    header("Location:/laracast-php/public/");  
}
```
---
## 🔹 گام ۱۰: تغییر در Navigation (nav.php)

در partial مربوط به Navigation (`partials/nav.php`)، جای تصویر را شرطی می‌کنیم یعنی اگر کاربر ثبت نام کرده بود تصویرنمایش داده شود در غیراینصورت یک لینک به صفحه ثبت نام گذاشته شود:
```php
<?php if($_SESSION['user'] ?? false): ?>  
    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full" />  
<?php else: ?>  
    <a href='/laracast-php/public/register' class="text-white z-50 relative">Register</a>  
<?php endif; ?>
```
---
## 🔹 گام ۱۱: مشکل باقی‌مانده – ماندگاری Session

- تا وقتی مرورگر باز است، نشست (Session) زنده می‌ماند.
- حتی اگر مرورگر بسته شود، چون **PHP Session با کوکی** کار می‌کند، ممکن است تا نوبت بعدی پاک نشود.
- راه‌حل حرفه‌ای:
    - استفاده از `session_regenerate_id()` بعد از ثبت‌نام/Login
    - تعیین زمان انقضا برای Session
    - ذخیره اطلاعات حساس در دیتابیس و تطبیق session_id در هر درخواست.

---

## 📌 جمع‌بندی

در این جلسه یاد گرفتیم:

1. ساخت فرم ثبت‌نام با Tailwind UI
2. گرفتن داده‌ها از فرم
3. اعتبارسنجی ورودی‌ها (ایمیل و پسورد)
4. بررسی وجود کاربر در دیتابیس
5. درج کاربر جدید در دیتابیس
6. ذخیره وضعیت ورود در Session
7. اجرای شرط در Navigation برای نمایش تصویر یا لینک ثبت‌نام
---
📖 تمرین پیشنهادی:

- رمز عبور ورودی را **هش (hash)** کن با `password_hash()`
- در زمان login با `password_verify()` بررسی کن.
- سیستم logout بساز (`session_unset(); session_destroy();`).

---
