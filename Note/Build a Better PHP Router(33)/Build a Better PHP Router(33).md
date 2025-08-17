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
# نکته در مورد متد های get و post
اگر از این متدها استفاده کنیم و در یک صفحه هم نیاز به متد get و هم نیاز به متد post باشد باید در فایل routes.php دوبار دستور بنویسیم یعنی یه بار برای post و یه بار هم برای get در نتیجه ما اومدیم متد add را تعریف کردیم تا در اینجور مواقع در قسمت متد هم post و هم get را مینویسیم در یک خط تا از تکرار کد جلوگیری کنیم.ضمنا وقتی کاربر یک آدرس را در مرورگر تایپ میکند مثل localhost/laracast-php/public این یک درخواست http با متد get به صفحه index هست اما اگر در این صفحه یک فرم باشد که اطلاعات را ارسال میکند با کلیک بر روی دکمه اطلاعات با متد post ارسال میشوند.

🔹 متد get
<div dir="ltr">

```php
    public function get($uri , $controller) {
        $this->add('GET', $uri, $controller);
    }
```
<div dir="rtl">
اسمش get ـه چون مخصوص درخواست‌های HTTP GET هست.
یعنی وقتی مرورگر یا کاربر میاد یه صفحه رو باز می‌کنه (مثلاً /about یا /notes) → درخواست GET می‌فرسته.

ورودی‌هاش:

$uri: مسیر URL (مثلاً /about).

$controller: آدرس فایل کنترلر (مثلاً controllers/about.php).

توی خط داخلش، متد add رو صدا می‌زنه:
<div dir="ltr">

```php
    $this->add('GET', $uri, $controller);
```
<div dir="rtl">

یعنی این مسیر رو با متد GET ذخیره کن.

در نتیجه مسیر و کنترلرش میره می‌شینه توی آرایه‌ی routes.

🔹 متد post
<div dir="ltr">

```php
    public function post($uri , $controller) {
        $this->add('POST', $uri, $controller);
    }
```
<div dir="rtl">

اسمش post ـه چون مخصوص درخواست‌های HTTP POST هست.
معمولا وقتی یه فرم رو submit می‌کنیم، اطلاعات به صورت POST ارسال می‌شن.

ورودی‌هاش همون دوتاست:

$uri: مسیر URL (مثلاً /note/create).

$controller: کنترلری که بعد از ارسال فرم باید اجرا بشه.

این خط:
<div dir="ltr">

```php
    $this->add('POST', $uri, $controller);
```
<div dir="rtl">

یعنی این مسیر رو با متد POST به آرایه‌ی مسیرها اضافه کن.

✅ پس get و post فقط میانبر هستن برای اینکه مجبور نشیم دستی مقدار متد رو هر بار به add بدیم.
به جای این:
<div dir="ltr">

```php
    $router->add('GET', '/about', 'controllers/about.php');
```
<div dir="rtl">
می‌نویسیم:

<div dir="ltr">

```php
    $router->get('/about', 'controllers/about.php');
```

بریم ببینیم این متدهای get و post دقیقاً کجا استفاده می‌شن:

🔹 فایل routes.php

این فایل در واقع لیست تمام مسیرهای اپلیکیشن رو نگه می‌داره.
داخلش چیزی مثل این می‌نویسیم:
<div dir="ltr">

```php
<?php
    $router->get('/', 'controllers/index.php');
    $router->get('/about', 'controllers/about.php');
    $router->get('/contact', 'controllers/contact.php');
    $router->post('/notes', 'controllers/notes/store.php');

```
<div dir="rtl">
🔸 توضیح خط به خط
<div dir="ltr">

```php
    $router->get('/', 'controllers/index.php');
```
<div dir="rtl">

یعنی اگه کسی آدرس / (صفحه اصلی سایت) رو باز کرد → برو فایل controllers/index.php رو اجرا کن.
<div dir="ltr">

```php
    $router->get('/about', 'controllers/about.php');
```
یعنی اگه کسی صفحه‌ی /about رو باز کرد → کنترلر about.php اجرا بشه.

<div dir="ltr">

```php
    $router->get('/contact', 'controllers/contact.php');
```
<div dir="rtl">

یعنی برای /contact → برو به فایل contact.php.

<div dir="ltr">

```php
    $router->post('/notes', 'controllers/notes/store.php');
```
<div dir="rtl">
اینجا دیگه ماجرا فرق می‌کنه:

وقتی کاربر یه فرم رو پر می‌کنه و submit می‌کنه، مرورگر یه درخواست POST به /notes می‌فرسته.

این خط میگه: "باشه، وقتی یه POST به /notes اومد، برو فایل controllers/notes/store.php رو اجرا کن."

داخل اون فایل معمولاً داده‌ها توی دیتابیس ذخیره می‌شن.

✅ پس می‌بینی که متدهای get و post فقط یه نقشه راه (Route Map) درست می‌کنن.
کاربر هر آدرسی رو بزنه، یا هر فرمی رو بفرسته، این Router تصمیم می‌گیره کدوم فایل باید اجرا بشه.

اما در نهایت ما از متد add برای ذخیره آدرس ها استفاده میکنیم بریم سراف فایل routes.php خودمان در پروژه 
<div dir="ltr">

```php
<?php

        $router->add('GET','/laracast-php/public/', "controller/index.php");
        $router->add('GET','/laracast-php/public/about', "controller/about.php");
        $router->add('GET','/laracast-php/public/contact', "controller/contact.php");
        $router->add('GET','/laracast-php/public/notes', "controller/note/index.php");
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/create', "controller/note/create.php");
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/note', "controller/note/show.php");

```
<div dir="rtl">
حالا بریم به سراغ فایل index.php که در پوشه public قرار دارد:
<div dir="ltr">

```php
<?php
    const BASE_PATH = __DIR__ . '/../';
    require_once BASE_PATH . "core/function.php";
    spl_autoload_register(function ($class) {
        $class = str_replace("\\", "/", $class);
        // مسیر فایل کلاس را بر اساس نام کلاس بساز
        $path = base_path("{$class}.php");

        if (file_exists($path)) {
            require_once $path;
        }
    });
    $router = new \core\Router();
    $routes = require_once base_path('core/routes.php');
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];



    $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'] ;
    $router->route($url, $method);

```
<div dir="rtl">
این تکه کد زیر که قبلا هم بود و کاری باهاش نداریم:
<div dir="ltr">

```php
<?php
    const BASE_PATH = __DIR__ . '/../';
    require_once BASE_PATH . "core/function.php";
    spl_autoload_register(function ($class) {
        $class = str_replace("\\", "/", $class);
        // مسیر فایل کلاس را بر اساس نام کلاس بساز
        $path = base_path("{$class}.php");

        if (file_exists($path)) {
            require_once $path;
        }
    });
```
<div dir="rtl">
اما قراره که درمورد کدهای زیر صحبت کنیم:
<div dir="ltr">

```php
<?php

    $router = new \core\Router();
    require_once base_path('core/routes.php');
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];
    $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'] ;
    $router->route($url, $method);

```
<div dir="rtl">
در خط زیر یک شی از کلاس router ایجاد کردیم و چون این کلاس در فضای نام core قرار دارد و از use استفاده نکردیم پس با \ آدرس فضای نام را میدهیم:
<div dir="ltr">

```php
    $router = new \core\Router();
```
<div dir="rtl">
اما در خط زیر فایل routes.php که شامل مسیرهای ما هست را require میکنیم تا مسیرها توسط متد add در شی router ریخته بشه و بعدا بتوانیم مسیریابی کنیم.
<div dir="ltr">

```php
    require_once base_path('core/routes.php');
```

<div dir="rtl">
در خط زیر آدرس url که کاربر در مرورگر وارد کرده دریافت شده و در متغیر url ذخیره میشود.
<div dir="ltr">

```php
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];
```
<div dir="rtl">
در خط زیر بررسی میشه که متد چیست اگر کاربر در یک فرم مثل فرمی که برای حذف یادداشت در فایل show.view.php نوشتیم توسط یک input مخفی  متدی فرستاده باشد آن متد در method ریخته میشه اما اگر نفرستاده باشد همان درخواست کاربر که get یا post هست در method ریخته میشود.
<div dir="ltr">

```php
    $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'] ;
```

```php
//فایل show.view.php که متد DELETE را فرستادیم
    <form method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $note['id']; ?>">
        <input type="hidden" name="user_id" value="<?= $note['user_id']; ?>">
        <button class="text-sm text-red-500">Delete</button>
    </form>
```

<div dir="rtl">
توسط دستور زیر با توجه به مقدار url و method به فایل router برای بررسی آدرس میرویم که این کار را متد route میکند اگر آدرس بود صفحه مورد نظر نمایش در غیر اینصورت با توجه به تابع abort پیغام 404 نمایش داده میشود.
<div dir="ltr">

```php
    $router->route($url, $method);
```
<img title="a title" alt="Alt text" src="ChatGPT%20Image%20Aug%2017,%202025,%2010_19_41%20PM.png">
<div dir="rtl">
ین تصویر یک فلوچارت (نمودار گردشی) را نشان می‌دهد که فرآیند تعیین متد HTTP در یک سیستم مسیریابی (Router) را توضیح می‌دهد:
1. Request URI (درخواست URI):
فرآیند با دریافت یک URI (شناسه‌ی یکنواخت منبع) آغاز می‌شود.
2. Get HTTP method (دریافت متد HTTP):
سپس متد HTTP مربوط به این درخواست (مانند GET، POST) دریافت می‌شود.
3. Is $_POST['\_method'] set? (آیا $_POST['\_method'] تنظیم شده است؟):
در این مرحله بررسی می‌شود که آیا متغیر _method در آرایه $_POST تنظیم شده است یا خیر. این معمولاً برای شبیه‌سازی متدهای HTTP مانند PUT یا DELETE در فرم‌های HTML که فقط از GET و POST پشتیبانی می‌کنند، استفاده می‌شود.
Yes (بله): اگر _method تنظیم شده باشد، از مقدار آن برای تعیین متد استفاده می‌شود.
No (خیر): اگر _method تنظیم نشده باشد، از متد HTTP اصلی درخواست استفاده می‌شود.
4. Router (مسیریاب):
پس از تعیین متد، درخواست به مسیریاب ارسال می‌شود.
5. GET, POST, DELETE:
در نهایت، مسیریاب درخواست را بر اساس متد تعیین شده (مانند GET، POST، DELETE) به مسیر مربوطه هدایت می‌کند.