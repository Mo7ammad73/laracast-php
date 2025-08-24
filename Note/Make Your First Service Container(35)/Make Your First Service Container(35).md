اگر به فایل های پروژه که از پایگاه داده استفاده میکنند مثل فایل های موجود در پوشه controller/note که شامل show.php-create.php-index.php-store.php-destroy.php و ... هستند مراجعه کنیم میبینیم که کدهای زیر در همه ی این فایل ها تکرار میشوند:
```php
$config = require_once base_path("controller/config.php");  
$db = new Database($config['database'], "root", "");
```
برای جلوگیری از تکرار این کدها DRY ما یک فایل container ایجاد میکنیم که قرارداد ساخت شی در یک متدش و ساخت شی در متد دیگرش تعریف میکنیم بعد هرجا نیاز به شی پایگاه داده بود از این کلاس container استفاده میکنیم.
## ==محتوای فایل container.php==
```php
<?php  
  
namespace core;  
  
class Container{  
  
    protected $bindings = [];  
    public function bind($key , $resolver){  
  
        $this->bindings[$key] = $resolver;  
  
    }  
  
    public function resolve($key){  
  
        if(! array_key_exists($key , $this->bindings)){  
            throw new \Exception("No Matching binding found for  $key");  
        }  
  
            $resolver = $this->bindings[$key];  
            return call_user_func($resolver);  
  
  
    }  
}
```
توسط این کانتینر میگیم وقتی کلید خاصی x  را خواستی  فلان تابع را اجرا کن و نتیجه اش را برگردون این دقیقاً مفهوم **Dependency Injection Container**  هست یعنی بجای اینکه خودمون همه‌جا new بزنیم، Container مسئول ساختن اشیاء و مدیریت وابستگی‌ها میشه.

بریم سراغ توضیح خط به خط کدهای بالا
```php
namespace core;  
  
class Container{  
```
توسط دو خط بالا میگیم که کلاسی با نام Container میخواهیم ایجاد کنیم که در فضای نام core قرار داشته باشه.
```php
protected $bindings = [];  
```
یک خاصیت که به صورت آرایه انجمنی قرار است بشود تعریف میکنیم تا کلید key و تابع سازنده آن کلید resolver را درون آن نگهداری کنیم  به صورت زیر:
```php
$bindings = [  
    "key"=>"closure"  or "core\Database" => function(){
	    $config = require base_path("controller/config.php");
		return new Database($config['database']);
    }
    ];
```
در مثال بالا و احتمالا پروژه ما $key  برابر با "core\Database"  و $resolver برابر با  محتوای زیر میشود:
```php
 function(){
		    $config = require base_path("controller/config.php");
			return new Database($config['database']);
		}
```
اما بریم سراغ توضیح بقیه کدها
```php
public function bind($key , $resolver){  
  
        $this->bindings[$key] = $resolver;  
  
    }  
```
در تابع بالا فقط قرارداد ساخت سرویس یا به عبارتی قرارداد ساخت شی پایگاه داده ذخیره میشه .
چه جوری ؟ میاد کلید و نحوه ی ساخت شی را میگیره و درون آرایه bindings قرار میده ولی اینجا هنوز شی ای نساخته.

اما کدهای تابع  resolve

```php
public function resolve($key){  
  
        if(! array_key_exists($key , $this->bindings)){  
            throw new \Exception("No Matching binding found for  $key");  
        }  
  
            $resolver = $this->bindings[$key];  
            return call_user_func($resolver);  
  
  
    }  
```
این تابع یک کلید از کاربر میگیره اگر این کلید تو آرایه bindings نباشه خطا میده اما اگه باشه مقدار اون کلید در آرایه bindings که معمولا یک closure یا تابع ناشناس هست برداشته و در متغییر resolver ذخیره میکند بعد توسط تابع call_user_func این تابع اجرا میشه و نتیجه اش که در اینجا ساخت شی پایگاه داده هست توسط تابع یا متد resolver  برگردانده میشه پس قرادادی که توسط متد bind در خاصیت bindings ریخته شده بود توسط متد resolve اجرا شد.

## نکته
آرایه bindings به صورت protected تعریف شده یعنی فقط در این کلاس و کلاس های فرزند قابل استفاده هست و بیرون از کلاس قابل استفاده نیست اما اگه public بود هم این کلاس هم کلاس های فرزند و هم بیرون از کلاس قابل استفاده بود و اگر private بود فقط در همین کلاس قابل استفاده بود و در کلاس های فرزند و بیرون کلاس قابل استفاده نبود.

---
برای استفاده از کدهای بالا  باید کدهای زیر را در فایل index.php نوشته و هرفایلی که نیاز به ساخت شی پایگاه داده داشت باید $container رو بهش انتقال داد یا container رو به صورت global کرد که این کار درست نیست پس یه فایل واسط Bootstrap ایجاد میکنیم کدهای زیر را داخلش مینویسیم بعد خود این فایل رو در index.php با require اضافه میکنیم:
```php
use 'core\Database';
$container = new Container();  
  
$container->bind('core\Database' , function (){  
    $config = require base_path('controller/config.php');  
    return new Database($config['database']);  
});  
  
$db = $container->resolve('core\Database');
```
البته بعد از تعریف فایل App کدهای فایل Bootstrap  تغییر میکند.
## ==محتوای فایل App.php==
```php
<?php  
  
    namespace core;  
    class App {  
        protected static $container;  
  
        public static function setcontainer(Container $container) {  
            static ::$container = $container;  
        }  
        public static function container() {  
            return static::$container;  
        }  
  
        public static function bind($key , $resolver) {  
            static::$container->bind($key , $resolver);  
        }  
  
        public static function resolve($key) {  
            return static::$container->resolve($key);  
        }  
  
    }
```
بریم سراغ توضیح خط به خط
```php
    namespace core;  
```
توسط این دستور میگیم کلاس App در فضای نام core قرار دارد و با core\App قابل استفاده میباشد یعنی برای استفاده از متد resolve این کلاس میتوان core\App::resolve نوشت.
```php
class App {  
        protected static $container;  
```
کلاس App را تعریف کرده و در خط بعدی یک خاصیت با نام container ایجاد میکنیم که ایستا هست یعنی به کلاس تعلق دارد نه نمونه ها. این خاصیت قراره یک کانتینر را در خود نگه دارد منظور از یک کانتینر یعنی یک شی از کلاس Container  پس میتوان نوع این خاصیت را Container گذاشت یعنی :
```php
protected static Container $container;
```
چون میخواهیم در هرجای پروژه بدون new کردن از این کانتینر سراسری استفاده کنیم  این خاصیت و متدهای این کلاس را static گذاشتیم یعنی ما در هر فایل میتوانیم به صورت زیر استفاده کنیم:
```php
$db = \core\App::resolve(Database::class);
```
اما بریم سراغ متد بعدی
```php
public static function setcontainer(Container $container) {  
            static ::$container = $container;  
        }  
    
```
این متد یک شی از نوع  کلاس container میگیره و درون خاصیت کانتینر جاری کلاس App قرار میده.
احتمالا توسط کد زیر که در فایل Bootstrap.php نوشته میشود یک شی از کلاس Container تعریف کرده و درون این کانتینر قرار میدهیم:
```php
$container = new \core\Container();
// ... bindها
\core\App::setContainer($container);

```
با توجه به کد بالا در Bootstrap از این لحظه به بعد App یک کانتینر یا ظرف معتبر داره.
اما بریم سراغ کد بعدی :
```php
public static function container() {  
            return static::$container;  
        }  
```
این متد کانتینر یا ظرف جاری را برمیگرداند.
کد static::container() در کلاس و App::container() در بیرون کلاس کانتینر جاری ما رو برمیگردونه برای بایند کردن در کانتینر جاری  میتوان میانبری به متد بایند خود کلاس کانتینر زد پس
```php
public static function bind($key , $resolver) {  
            static::$container->bind($key , $resolver);  
        }  
```
در اینصورت برای استفاده App::bind( ) میزنیم اما اگه استفاده نکنیم App::Container->bind میزنیم.
در مورد متد resolve هم همان توضیحات بالا صدق میکند.
در کل چون ما در پروژه میخواهیم با App  bind  یا resolve  کنیم پس بهتره داخل این کلاس متدهای میانبر به متدهای کلاس کانتینر بزنیم و گرنه درعمل فرقی ندارند:
```php
$container = new Container();  
App::setcontainer($container);  
App::bind('core\Database' , function (){  
    $config = require base_path('controller/config.php');  
    return new Database($config['database']);  
});
```

```php
$container = new Container();  
  
$container->bind('core\Database' , function (){  
    $config = require base_path('controller/config.php');  
    return new Database($config['database']);  
});  
  
$db = $container->resolve('core\Database');  
App::setcon
```
دو تیکه کد بالا فرقی با هم ندارند.
اما اینکه چرا از فایل App استفاده کردیم و بدون اون هم میتونستیم کدهامون رو بنویسیم اینه که اگر از App استفاده نمیکردیم کدمان به صورت زیر بود:
```php
$container = new Container();

$container->bind('core\Database' , function (){
    $config = require base_path('controller/config.php');
    return new Database($config['database']);
});

$db = $container->resolve('core\Database');

```
تو همه ی فایل ها باید $container رو انتقال میدادیم  چون فقط تو همین فایل در دسترسه یا global کنی که کار جالبی نیست اما اگه از فایل App استفاده کنی کدت به صورت زیر میشه :
```php
$container = new Container();
App::setContainer($container);

App::bind('core\Database' , function (){
    $config = require base_path('controller/config.php');
    return new Database($config['database']);
});

$db = App::resolve('core\Database');

```
اینجا چه اتفاقی افتاده؟

- فایل `App` مثل یک **wrapper (پوسته)** عمل می‌کنه که Container رو نگه می‌داره.
- الان دیگه نیاز نداری متغیر `$container` رو با خودت همه‌جا بکشی.
- هر وقت لازم داشتی، فقط `App::resolve(...)` صدا می‌زنی.

---

###  تفاوت‌ها به زبان ساده
<div dir="rtl">
1. **بدون App.php**:

    - وابسته به متغیر `$container`.
    - باید همیشه پاس بدی یا global کنی.
    - پروژه کوچیک باشه مشکلی نیست، ولی وقتی بزرگ میشه خیلی دردسر میشه.
2. **با App.php**:

    - ظرف Container میشه **سراسری (global)** ولی به شکل تمیز و کنترل‌شده.
    - دسترسی راحت از هرجای پروژه (`App::bind`, `App::resolve`).
    - خوانایی بیشتر (وقتی کسی کد رو ببینه سریع می‌فهمه که این یه کانتینر سراسریه).
---

### ✨ نتیجه

در اصل **هیچ تفاوتی در عملکرد نیست**. هر دو یکی هستن.  
اما **جفری App.php رو آورده برای تمیزتر شدن و راحتی دسترسی در پروژه‌های بزرگ**.

---
## فایل Bootstrap.php
اگه این فایل نبود کد زیر را در فایل index مینوشتیم :
```php
// index.php
require "core/Container.php";
require "core/App.php";
require "core/Database.php";

$container = new Container();
App::setContainer($container);

App::bind('core\Database', function () {
    $config = require base_path('controller/config.php');
    return new Database($config['database']);
});

// حالا برویم به router.php
require "router.php";

```
اینجا یه مشکل داری:

- هر بار که می‌خوای پروژه رو اجرا کنی، باید همه‌ی تنظیمات Container و Bind کردن‌ها رو **مستقیم تو index.php** یا جاهای دیگه تکرار کنی .
- ما نمی‌خوایم index.php شلوغ بشه و همه تنظیمات توش باشه، به همین خاطر Bootstrap جدا کردیم.
- پروژه که بزرگ بشه، index.php پر از شلوغی میشه.
  اما با استفاده از فایل Bootstrap که شامل کد زیر هست :
```php
// bootstrap.php
$container = new Container();
App::setContainer($container);

App::bind('core\Database', function () {
    $config = require base_path('controller/config.php');
    return new Database($config['database']);
});

```
و بعد در فایل index.php
```php
require 'bootstrap.php';
```
الان مزیتش چیه؟

1. **تمرکز تنظیمات** → همه‌ی کارهای اولیه (راه‌اندازی Container و Bindها) توی یک فایل مخصوص جمع شده.
2. **کد تمیزتر** → index.php خیلی سبک و ساده میشه.
3. **قابلیت گسترش** → بعداً اگه خواستی middleware اضافه کنی، route لود کنی یا logger بذاری، همه رو توی bootstrap جمع می‌کنی.
4. در واقع Bootstrap مثل استارت ماشینه: همیشه باید اول زده بشه ولی فقط یک‌بار نوشته میشه.
---

###  نتیجه‌گیری

- بدون `bootstrap.php` هم کدت کار می‌کنه، اما پخش و شلوغ میشه.
- فایل`bootstrap.php` فقط نقش **موتور استارت پروژه** رو داره:.
- هرچی برای راه‌اندازی اولیه لازمه (Container, App, Config, Database و …) توی همونجا ستاپ میشه.


# 🔟 تمرین Container و App

---

### 📝 تمرین ۱

یک Container بساز و داخلش یک سرویس ساده `Logger` (که فقط پیام چاپ کند) ثبت کن. بعد آن را resolve کن.

**جواب:**
```php
class Logger { 
    public function log($msg) {
		    echo "Log: $msg";     
	}
	}
	$container = new Container();  
	$container->bind('logger', function () {     return new Logger(); });  
	$logger = $container->resolve('logger'); 
	$logger->log("Hello World!");` 

```
- کلاس `Logger` یک کلاس ساده است با متد `log`.
- دستور `bind('logger', fn(){...})` یعنی: «وقتی کسی کلید `logger` را خواست، این closure را اجرا کن و خروجی‌اش را بده.»
  داخل closure هم `new Logger()` می‌سازیم؛ **فعلاً چیزی ساخته نمی‌شود** تا وقتی `resolve` صدا زده شود.
- دستور `resolve('logger')` تابع ذخیره‌شده را اجرا می‌کند و یک شیء تازه‌ی `Logger` برمی‌گرداند.
- حالا با `$logger->log(...)` خروجی می‌گیری.
> نکته: هر بار `resolve('logger')` کنی، Logger جدید ساخته می‌شود (الگوی transient).
---

### 📝 تمرین ۲

یک سرویس `Database` در کانتینر ثبت کن که config را از `config.php` بگیرد.

**جواب:**
```php
`$container->bind('db', function () {     
	$config = require base_path('controller/config.php');     
	return new Database($config['database']); 
	}); 
 $db = $container->resolve('db');`
```

- در closure، هر بار config را با `require` می‌خوانیم (چون چند بار نیاز داریم مقدار برگردد).

- از `config['database']` برای ساختن DSN استفاده می‌شود (طبق کلاس `Database` خودت).

- با `resolve('db')` یک اتصال PDO داخل `Database` ساخته می‌شود.


> دام رایج: اگر این فایل را با `require_once` چند جای دیگر هم خوانده باشی، بار دوم ممکن است `null` برگردد و DSN بهم بریزد.

---

### 📝 تمرین ۳

دو سرویس مختلف (`Mailer` و `Database`) در یک Container ثبت کن و هر دو را resolve کن.

**جواب:**

```php
$container->bind('db', function () {     
	$config = require base_path('controller/config.php');     
	return new Database($config['database']); 
	});  
	$container->bind('mailer', function () {     return new Mailer("noreply@test.com"); });
	 $db = $container->resolve('db'); 
	 $mailer = $container->resolve('mailer');`
```

- دو **کلید مستقل** درون container ثبت می‌شوند.

- هر `resolve`، همان closure مربوط به همان کلید را اجرا می‌کند.

- به این ترتیب Container یک «دفترچهٔ راهنمای ساخت» برای هر سرویس دارد.


> نکته: کلیدها می‌توانند رشته‌های ساده باشند یا امن‌تر: `ClassName::class`.
---

### 📝 تمرین ۴

یک کلاس `UserService` بساز که به `Database` نیاز دارد. آن را طوری در کانتینر bind کن که دیتابیس resolve شود و به UserService تزریق گردد.

**جواب:**
```php
class UserService {
     protected $db;
     public function __construct(Database $db) {
             $this->db = $db;     
        } 
    }  
    $container->bind('db', function () {     
	    $config = require base_path('controller/config.php');
	     return new Database($config['database']); });
	  $container->bind('userService', function () use ($container) {
	       return new UserService($container->resolve('db')); 
	});  
	$userService = $container->resolve('userService');`
```
- کلاس `UserService` در سازنده‌اش `Database` می‌خواهد.

- در binding مربوط به `userService`، قبل از `new UserService(...)`، از خود Container می‌خواهیم که `db` را resolve کند.

- نتیجه: Container وابستگی‌ها را «به‌جای ما» می‌سازد و تزریق می‌کند.


> نکته: اگر `App` را راه انداخته‌ای، بهتر است از `App::resolve('db')` استفاده کنی (تمرین ۵).


---

### 📝 تمرین ۵

کد بالا را تغییر بده تا به‌جای `$container->resolve('db')`، مستقیم از App میانبر استفاده شود.

**جواب:**
```php
	App::bind('db', function () {     
	$config = require base_path('controller/config.php');     
	return new Database($config['database']); 
	});  
	App::bind('userService', function () {     
	return new UserService(App::resolve('db')); 
	});  
	$userService = App::resolve('userService');`
```

- دستور`App::bind` فقط یک **میان‌بر** است که درونش می‌رود و `container()->bind` را صدا می‌زند.

- همین‌طور `App::resolve` میان‌بر `container()->resolve` است.

- فایده: دیگر نیازی به پاس‌دادن متغیر `$container` بین فایل‌ها نیست (کانتینر «سراسریِ تمیز» داریم).


> یادآوری: قبل از این استفاده‌ها، باید در `bootstrap.php` یک Container ساخته باشی و با `App::setContainer($container)` ثبتش کرده باشی.
---

### 📝 تمرین ۶

یک سرویس `Cache` ثبت کن که فقط یک آرایه ساده برای ذخیره داده‌ها باشد.

**جواب:**
```php
`class Cache {     
	protected $data = [];     
	public function set($key, $value) {         
		$this->data[$key] = $value;
     }     
     public function get($key) {         
	     return $this->data[$key] ?? null;     
     } 
     }  
     App::bind('cache', function () {     
	     return new Cache();
	 });  
	 $cache = App::resolve('cache'); 
	 $cache->set('name', 'Mohammad'); 
	 echo $cache->get('name'); // Mohammad`
```

- کلاس `Cache` فقط یک ظرفِ آرایه‌ای داخل حافظه است (mock ساده).

- با `App::bind` آن را ثبت می‌کنی.

- هر بار `resolve('cache')` کنی، یک نمونهٔ جدید از `Cache` می‌گیری (مگر این‌که singleton بسازی—تمرین ۸).


> نکته: در پروژه واقعی شاید بخواهی Cache را singleton کنی تا داده‌ها بین چند استفاده‌ی پشت‌سرهم مشترک بمانند.

---

### 📝 تمرین ۷

یکبار `$container->bind('db', ...)` انجام بده و دوبار `resolve` کن. بررسی کن آیا هر بار دیتابیس جدید ساخته می‌شود یا همان شیء برمی‌گردد؟

**جواب:**
```php
App::bind('db', function () {     
$config = require base_path('controller/config.php');     
	return new Database($config['database']); 
});  
$db1 = App::resolve('db'); 
$db2 = App::resolve('db');  
var_dump($db1 === $db2); // false -> هر بار شیء جدید ساخته میشه`
```
- هر بار که `resolve('db')` می‌کنی، closure دوباره اجرا می‌شود → `new Database(...)` جدید.

- بنابراین **هویت** دو شیء متفاوت است (`===` برمی‌گرداند false).


> نکته: اگر اتصال دیتابیس سنگین است، شاید Singleton منطقی‌تر باشد (تمرین ۸).

---

### 📝 تمرین ۸

یک نسخه Singleton بساز؛ یعنی دیتابیس فقط یکبار ساخته شود و در بار دوم resolve همان برگردد.

**جواب:**
```php
App::bind('db', function () {     
	static $db = null;     
	if (!$db) {         
		$config = require base_path('controller/config.php');         
		$db = new Database($config['database']);     
	}     
	return $db; 
});  
$db1 = App::resolve('db'); 
$db2 = App::resolve('db');  
var_dump($db1 === $db2); // true`
```

- از یک متغیر `static` داخل closure استفاده کردیم تا **فقط بار اول** نمونه ساخته شود.

- دفعات بعدی همان نمونه‌ی قبلی برگردانده می‌شود.

- حالا `===` true است چون هویت شیء یکسان است.


> الگوی حرفه‌ای‌تر: اضافه‌کردن متد `singleton` داخل خود `Container` که این کار را برای هر binding انجام دهد.
---

### 📝 تمرین ۹

یک سرویس به نام `RandomNumber` ثبت کن که هر بار resolve می‌شود، یک عدد رندوم جدید بدهد.

**جواب:**
```php
App::bind('random', function () {     
	return rand(1, 100); 
});  
echo App::resolve('random'); // مثلاً 42 
echo App::resolve('random'); // مثلاً 77`
```

- این‌جا `resolver` شیء برنمی‌گرداند، بلکه یک مقدار (int) برمی‌گرداند—اوکی است.

- چون هر بار closure اجرا می‌شود، خروجی هر دفعه می‌تواند متفاوت باشد (زمانی که singleton نیست).


> نکته: Container لزوماً فقط «اشیاء» نمی‌سازد؛ می‌تواند هر نوع مقداری را مدیریت کند.
---

### 📝 تمرین ۱۰

یک سرویس بساز به اسم `Auth` که نیاز دارد به `Database`. سپس داخل کانتینر تعریفش کن و ازش استفاده کن.

**جواب:**
```php
class Auth {     
	protected $db;     
	public function __construct(Database $db) {         
		$this->db = $db;     
	}     
	public function check($user) {         
		echo "Checking user $user...";     
	} 
} 
App::bind('db', function () {    
	 $config = require base_path('controller/config.php');     
	 return new Database($config['database']); 
	 });  
 App::bind('auth', function () {     
	 return new Auth(App::resolve('db')); 
 });  
 $auth = App::resolve('auth'); 
 $auth->check('mohammad');`

```
- `Auth` برای کارش به `Database` نیاز دارد.

- در binding مربوط به `auth`، ابتدا `db` را از Container می‌گیریم و بعد `new Auth(...)` می‌زنیم.

- با `App::resolve('auth')` یک نمونه‌ی آماده از `Auth` تحویل می‌گیری که وابستگی‌اش از قبل تزریق شده.


> نکتهٔ امنیتی: در دنیای واقعی، `Auth` احتمالاً به session/cookie و hashing هم نیاز دارد؛ همه‌ی این‌ها می‌توانند سرویس‌های جدا باشند و به همین روش تزریق شوند.
---


## چند نکتهٔ تکمیلی (خیلی مهم)

- در**App سراسری**: یادت نره قبل از استفاده از `App::bind/resolve`، در `bootstrap.php` یک بار بنویسی:
```php
$container = new \core\Container(); 
\core\App::setContainer($container);
```



- **کلید امن‌تر**: به جای رشته‌ها از `ClassName::class` استفاده کن:
    ```php
		App::bind(Database::class, fn() => new Database(...)); $db = App::resolve(Database::class);
		$db = \core\App::resolve(Database::class);
    ```
در پروژه ما 'core\Database' معادل Database::class هست.
اینطوری خطای تایپی نمی‌کنی.

- دستور **require vs require_once** برای `config.php`:

    -  دستور`require` → هر بار مقدار آرایه را برمی‌گرداند (برای config خوب است).
    - دستور`require_once` → اگر قبلاً لود شده باشد، مقدار جدیدی برنمی‌گرداند و در سناریوهایی مثل bind داخل closure ممکن است `null` تحویل بدهد و DSN خراب شود.
