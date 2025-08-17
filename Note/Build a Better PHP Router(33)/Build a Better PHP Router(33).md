<div dir="rtl">
در پوشه core یک فایل با نام Router.php ایجاد کرده و برای عملیات مسیریابی از این به بعد از این فایل استفاده میکنیم.
پس محتویات فایل Router به صورت زیر میشود:
<div dir="ltr">

# Router.php

```php

    <?php
    
        namespace core;
        class Router {
            protected $routes = [];
            public function get($uri , $controller) {
                $this->add('GET', $uri, $controller);
            }
    
            public function post($uri , $controller) {
                $this->add('POST', $uri, $controller);
            }
    
            public function delete($uri , $controller) {
                $this->add('DELETE', $uri, $controller);
            }
    
            public function patch($uri , $controller) {
                $this->add('PATCH', $uri, $controller);
            }
    
            public function put($uri , $controller) {
                $this->add('PUT', $uri, $controller);
            }
    
            public function route($uri , $method) {
                foreach ($this->routes as $route) {
                    if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                        return require_once base_path($route['controller']);
                    }
                }
                $this->abort();
            }
    
            public function add($methods , $uri , $controller) {
                foreach ((array)$methods as $method) {
                    $this->routes[] = [
                        'uri' => $uri,
                        'controller' => $controller,
                        'method' => $method
                    ];
                }
    
            }
    
            protected function abort($code=404){
                http_response_code($code);
                require_once base_path("controller/{$code}.php");
                die();
            }
        }
    
```
<div dir="rtl">
در این کلاس در ابتدا آرایهroutes را برای نگهداری مسیرهای فایل ها و آدرس های url استفاده میشود.یعنی وقتی کاربر یک صفحه جدید در سایت ایجاد میکند توسط متد add در این کلاس اون اطلاعات را در آرایه routes ذخیره میکند و بعدا هم برای مسیریابی باید اطلاعات داخل این آرایه را بررسی کنیم.
توسط متد get یک آدرس با متد get مثل صفحه index,about,contact,note رو در آرایه قرار میدهیم و توسط متد post یک آدرس با متد post مثل فایل های create,show قرار میدهیم.

# متد route
بریم سراغ توضیح خط به خط این متد:
تعریف متد 
<div dir="ltr">

```php
 public function route($uri , $method) 
```
<div dir="rtl">
this->routes همون خاصیتی هست که قبلا مسیرها را درونش ریختیم
<div dir="ltr">

```php
    foreach ($this->routes as $route) {
```
<div dir="rtl">
هر route یک آرایه هست مثل :
<div dir="ltr">

```php
[
  'uri' => '/notes',
  'method' => 'GET',
  'controller' => 'controllers/notes/index.php'
]

```
<div dir="rtl">
پس با foreach  یکی یکی همه ی مسیرهای تعریف شده رو بررسی میکنیم.

<div dir="ltr">

```php
    if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
```
<div dir="rtl">
اینجا داره چک می‌کنه که:

آدرس درخواست شده ($uri) دقیقاً با route تعریف‌شده یکی باشه.

متد هم یکی باشه.

👉 دقت کن:

strtoupper($method) حتماً متد رو به حروف بزرگ تبدیل می‌کنه (چون گاهی post یا get کوچیک هم ممکنه بیاد).

پس مثلاً اگر درخواست کاربر این باشه:

/notes   با متد get


بعد از strtoupper میشه:

/notes   با متد GET


و این با route تعریف‌شده مطابقت پیدا می‌کنه.

# اجرای کنترلر
اگر شرط بالا برقرار بود فایل مربوط به همون کنترلر اجرا میشه.
<div dir="ltr">

```php
     return require_once base_path($route['controller']);
```
<div dir="rtl">
اگر شرط بالا برقرار بود، فایل مربوط به همون کنترلر اجرا میشه.

base_path() کمک می‌کنه مسیر فایل به درستی از ریشه پروژه گرفته بشه.

require_once تضمین می‌کنه فایل فقط یک بار لود بشه.

یعنی اینجا دقیقاً داره کنترلر مرتبط با route رو صدا می‌زنه.
در نهایت اگر هیچ route پیدا نشد تابع abort اجرا میشه.
<div dir="ltr">

```php
     $this->abort();
```
<div dir="rtl">
خلاصه:
این متد route() کارش اینه:

همه routeها رو بررسی می‌کنه.

اگر uri و method با درخواست کاربر جور بود → فایل کنترلر مربوطه رو اجرا کن.

اگر هیچ route مطابقی نبود → خطای 404 برگردون.

# متد add
خیلی خوب 👌 بیا همین متد add رو هم مو به مو مثل معلم جفری بررسی کنیم:

<div dir="ltr">

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
<div dir="rtl">
۱. تعریف متد
<div dir="ltr">

```php
    public function add($methods , $uri , $controller)
```
<div dir="rtl">

متد public از کلاس Router.

سه ورودی می‌گیره:

$methods → متد یا متدهای HTTP مثل "GET" یا ["GET", "POST"].

$uri → مسیر (route) مثل /notes یا /contact.

$controller → مسیری که باید به فایل کنترلر اشاره کنه، مثلاً:

'controllers/notes/index.php'

۲. تبدیل به آرایه
<div dir="ltr">

```php
    foreach ((array)$methods as $method) {
```
<div dir="rtl">
(array)$methods خیلی مهمه 👇

اگر $methods فقط یک رشته باشه (مثلاً "GET")، با این تبدیل به آرایه تبدیل میشه مثل ["GET"].

اگر از اول آرایه باشه (مثلاً ["GET", "POST"])، همونطور آرایه باقی می‌مونه.

👉 این باعث میشه متد همیشه بتونه با foreach روی $methods حلقه بزنه، چه یک متد باشه، چه چندتا.

۳. اضافه کردن route
<div dir="ltr">

```php
    $this->routes[] = [
    'uri' => $uri,
    'controller' => $controller,
    'method' => $method
    ];
```
<div dir="rtl">

هر بار در حلقه، یک route جدید ساخته میشه و داخل آرایه $this->routes ذخیره میشه.

اینجا یک آرایه انجمنی (associative array) ساخته میشه با سه کلید:

'uri' → مسیر route

'controller' → مسیر فایل کنترلر

'method' → متد HTTP

مثلاً اگر بنویسی:
<div dir="ltr">

```php
    $router->add('GET', '/notes', 'controllers/notes/index.php');
```

<div dir="rtl">
بعد از اجرا این ذخیره میشه:
<div dir="ltr">

```php
    [
    'uri' => '/notes',
    'controller' => 'controllers/notes/index.php',
    'method' => 'GET'
    ]
```

<div dir="rtl">
و اگر متد رو اینجوری بدی:
<div dir="ltr">

```php
    $router->add(['GET', 'POST'], '/notes', 'controllers/notes/index.php');
```
<div dir="rtl">
دو تا route اضافه میشه: یکی برای GET و یکی برای POST.

۴. پایان
}


بعد از حلقه foreach، متد تمام میشه.

هیچ چیزی return نمی‌کنه → فقط route جدید رو به $this->routes اضافه می‌کنه.

✅ خلاصه کار متد add():

هر بار که صدا زده میشه، یک یا چند route جدید (بسته به تعداد methodها) ساخته و به لیست مسیرها ($this->routes) اضافه می‌کنه.

این لیست بعداً توی متد route() بررسی میشه تا بفهمه باید کدوم کنترلر اجرا بشه.
