ما الان در کنترلری هستیم که مسئول **ورود کاربر** **(Login)** هست. توی این کنترلر بخش زیادی کد مربوط به **اعتبارسنجی** **(Validation)** هست پس فایل کنترلر فرم log in باید شامل مفاهیم زیر باشد:
- مقدار گرفتن از فرم
- ایجاد یک شی از کلاس LoginForm
- چک کردن اعتبار داده‌ها یعنی مقدار فیلدهای ایمیل و پسوورد معتبر باشند توسط متد validate
- احراز هویت کاربران برای log in
- برگردوندن خطاها + داده‌های قبلی
  این کارها رو الان دستی انجام دادیم، ولی مشکل اینه که توی پروژه واقعی، فرم‌های زیادی داریم (ثبت‌نام، خرید، نظر، تغییر پروفایل، اضافه کردن اعضای تیم و ...).  
  و اگه بخوایم توی هر کنترلر همین Validation تکراری رو بنویسیم، کد پر از **کد تکراری** **(Duplicated Code)** می‌شه.
  مثلا اگر به فایل store مربوط به log in مراجعه کنیم و کدهایش رو ببینیم  متوجه میشویم که این کدها برای هرجا که تو پروژه فرم باشه نیاز هست معمولا استفاده میشه.
  کد فایل store مربوط به log in:
```php
$form = new LoginForm();  
if ( $form->validate($email, $password)){  
    $auth = new authenticator();  
    if( $auth->attempt($email, $password) ) {  
        Redirect("/laracast-php/public");  
    }  
    $form->adderror('email','No Matching Account Found for that email address and password');  
}  
session::flash('error',$form->getErrors());  
session::flash('old',['email'=>$email]);  
return Redirect("/laracast-php/public/login");
```
کد فایل store مربوط به register:
```php 
$form = new LoginForm();  
if ( $form->validate($email, $password)){  
    if ((new authenticator())->register($email, $password)){  
        Redirect("/laracast-php/public");  
    }  
    $form->adderror('email','exist Account  for that email address and password');  
}  
session::flash('error',$form->getErrors());  
session::flash('old',['email'=>$email]);  
return Redirect("/laracast-php/public/register");
```
کدهای مشابه دو فایل که برای فرم ثبت نام و فرم ورود استفاده میشه :
```php
<?php
$form = new LoginForm();  
if ( $form->validate($email, $password)){  
    // log in codes or register codes
}  
session::flash('error',$form->getErrors());  
session::flash('old',['email'=>$email]);  
return Redirect("/laracast-php/public/register");
```
حالا تصور کنید توی یک پروژه واقعی چقدر فرم دارید.  
مثلاً توی سایت Laracasts این همه فرم داریم:
- ثبت‌نام
- خرید
- ورود (Login)
- خرید کارت هدیه
- گذاشتن کامنت
- پست توی انجمن
- آپدیت پروفایل
- اضافه کردن اعضای تیم  
  باید کدهای مشابه بالا رو توی همی صفحات بنویسیم که این باعث تکرار کد  میشود.
---
**ایده جدید**
به جای اینکه هر بار توی کنترلر Validation انجام بدیم، بیایم Validation رو ببریم **یه سطح بالاتر** (داخل یک کلاس LoginForm). یعنی اون دستور if که تو کد مشابه بود اون کلا حذف بشه و بجش از متد یک کلاس مرکزی استفاده بشه.
- اینطوری کنترلر تمیز می‌شه.
- می‌تونیم Validation رو فقط یکبار تعریف کنیم و همه‌جا استفاده کنیم.

---
### 🔑 نکته اصلی ۲ دقیقه اول

جفری می‌خواد بگه:
- الان توی کنترلر لاگین، کلی کد اعتبارسنجی داریم.
- این کدها توی همه کنترلرهای پروژه تکرار می‌شن.
- پس باید یک راه پیدا کنیم که:
1. کدها تکرار نشن.
2. شرط‌ها و ifهای شلوغ از کنترلر حذف بشن.
3. اعتبارسنجی بره به سطح بالاتر (داخل یک کلاس اختصاصی یا مدیریت مرکزی).
 ---
کد فایل store مربوط به log in  که به صورت زیر بود:
 ```php
 $form = new LoginForm();
 if ( $form->validate($email, $password)){  
    if ((new authenticator())->register($email, $password)){  
        Redirect("/laracast-php/public");  
    }  
    $form->adderror('email','exist Account  for that email address and password');  
}
 ```
به صورت زیر تغییر میکند:
 ```php
 $form = new LoginForm();
 $form->validate($email, $password);
if ((new authenticator())->register($email, $password)){  
	Redirect("/laracast-php/public");  
}  
$form->adderror('email','exist Account  for that email address and password');  
 ```
بعد به جای کد :
 ```php
 $form = new LoginForm();
 $form->validate($email, $password);
 ```
کد زیر نوشته میشود:
 ```php
 LoginForm::validate($email, $password);
 ```
باتوجه به :: یعنی متد validate استاتیک شد پس به کلاس LoginForm رفته و متد validate رو اصلاح میکنیم:
 ```php
 public function static validate($attributes){
	 ...
 }
 ```
کد داخل متد validate برداشته شد و مقدار آرگومان هاش به یک آرگومان $attributes تغییر داده شد.
حالا در کلاس LoginForm یک متد سازنده constract میسازیم که آرگومانش $attributes هست و  کدهای قدیم متدvalidate رو  همراه با یک سری تغییرات داخل آن قرار میدهیم :
 ```php
 public function __construct($attributes)  
{  
    $this->attributes = $attributes;  
	if( Validator::Is_Empty($this->attributes['email']) || Validator::Is_Empty($this->attributes['password'])  ){  
	    $this->error['email'] = "email or password is required";  
	}  
	if( ! Validator::Validate_email($this->attributes['email']) ){  
	    $this->error['email'] = "Invalid email";  
	}  
	  
	$result = Validator::Validate_password($this->attributes['password']);  
	if (! $result['valid']) {  
	    $this->error['password'] = $result['message'];  
	}  
}
 ```
و به خود متد validate رفته و کد زیر را مینویسیم:
 ```php
 public static function  validate($attributes){  
    $instance = new static($attributes);    
}
 ```
یک متد failed در کلاس LoginForm تعریف میکنیم:
 ```php
 public function failed(){  
   return count($this->error);  
}
 ```
بعد در متد validate از آن استفاده میکنیم:
 ```php
 public function validate($attributes){  
    $instance = new static($attributes);  
    if ($instance->failed()){  
        throw new Exception("Validation failed");  
    }  
}
 ```
بعد به پوشه core رفته و یک کلاس ValidationException  میسازیم که فرزند کلاس Exception باشد:
 ```php
 <?php  
namespace core;    
class ValidationException extends \Exception  
{  

}
 ```
دوباره به کلاس LoginForm رفته و متد validateرو به صورت زیر کد میزنیم:
 ```php
 public function validate($attributes){  
    $instance = new static($attributes);  
    if ($instance->failed()){  
        throw new ValidationException($instance->error);  
    }  
    return $instance;
}
 ```
به فایل store مربوط به log in  برگشته و اون تیکه ای که کد به صورت زیر بود:
 ```php
	$form= LoginForm::validate($email, $password);
 ```
رو به صورت زیر تغییر میدهیم:
 ```php
$form = LoginForm::validate($attributes=[  
    'email' => $_POST['email'],  
    'password' => $_POST['password']  
]);
 ```
در کلاس LoginForm زیر متد validate از متد attempt هم استفاده کردیم مقدار آرگومان هاش به صورت زیر میشود :
 ```php
 if( $auth->attempt($attributes['email'] , $attributes['password']) ) {  
    Redirect("/laracast-php/public");  
}
 ```
به کلاس ValidationException رفته و کد زیر کد نهایی این فایل میشود:
 ```php
<?php  
  
    namespace core;  
  
    class ValidationException extends \Exception  
    {  
        protected $error = [];  
        public function __construct($error){  
            $this->error =$error;  
            parent::__construct("Validation Error");  
        }  
        public function getError(){  
            return $this->error;  
        }  
    }

 ```
### نکات ValidationException
- این کلاس یک poperty به نام error داره وقتی کاربر در کلاس LoginForm متد validate متوجه بشه که در کلاس LoginForm  خاصیت errorش شامل مقدار شده میاد اون مقدار error رو با دستور زیر به کلاس ValidationException  این کلاس هم در متد سازنده اش این error رو گرفته و در property مربوط به خودش یعنی error خودش قرار میده و بعدا کاربر با استفاده از متد geterror میتونه خطا را از این کلاس بگیرد.
- اما در مورد دستور زیر :
```php
parent::__construct("Validation Error"); 
```
ساختار کلاس اصلی exception به صورت زیر هست:
```php
public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
```
یه بخشی دارد message که اگر کاربر اونومقدار بده بعدا با استفاده از getmessage مقدار اونو میبینیم اگر نده خالی هست در بالا ما مقدار دادیم شاید یه موقع نیاز شد وگرنه اگر نمیذاشتیم هم اتفاقی نمیفتاد چون با geterror خطاهامونو میگیریم.

پس **مدیریت خطا در ValidationException**
- وقتی Exception می‌سازی، `getMessage()` همیشه متن ثابتی میده (مثل `"Validation Error"`).
- اگه می‌خوای جزئیات خطا (مثلاً فیلدهای اشتباه) رو بگیری، باید متد جدا (`getError()`) بسازی و همون رو توی `catch` استفاده کنی.

---

و کد نهایی فایل store.php
 ```php
 <?php  
  
use core\authenticator;  
use http\Forms\LoginForm;  
use core\session;  
    try{  
        $form = LoginForm::validate($attributes=[  
            'email' => $_POST['email'],  
            'password' => $_POST['password']  
        ]);  
        if( (new authenticator())->attempt($attributes['email'] , $attributes['password']) ) {  
            Redirect("/laracast-php/public");  
        }  
        session::flash('error', ['email' => 'No Matching Account Found for that email address and password']);  
        session::flash('old', ['email' => $_POST['email']]);  
        return Redirect("/laracast-php/public/login");  
    }catch (\core\ValidationException $exception){  
        session::flash('error',$exception->getError());  
        session::flash('old', ['email' => $_POST['email']]);  
        return Redirect("/laracast-php/public/login");  
    }
 ```
آرایه attributes$
وقتی کد زیر را مینویسیم:
 ```php
 $form = LoginForm::validate($attributes=[  
		'email' => $_POST['email'],  
		'password' => $_POST['password']  
	]);  
 ```
معادل این میمونه که کد زیر را نوشته باشیم :
 ```php
 $attributes = [
    'email' => $_POST['email'],
    'password' => $_POST['password']
];

$form = LoginForm::validate($attributes);
 ```
پس وقتی در دستور زیر از '['email']attributes$'  استفاده میکنیم میفهمیم که از همون آرایه ای که ابتدای فایل store تعریف کردیم و فیلدهای post شده ایمیل و پسوورد را داخلش قرار دادیم استفاده میکنیم.
تو PHP 8 می‌شه مستقیم اینطوری نوشت:
 ```php
 $form = LoginForm::validate(public array $attributes=[  
		'email' => $_POST['email'],  
		'password' => $_POST['password']  
	]);  
 ```
این یعنی `attributes` همیشه یک آرایه خواهد بود (نه string یا عدد).
و کد فایل loginForm
 ```php
 <?php  
  
namespace http\Forms;  
  
use core\ValidationException;  
use core\Validator;  
  
  
class LoginForm  
{  
   protected $attributes;  
   protected $error = [];  
   public function __construct($attributes)  
   {  
       $this->attributes = $attributes;  
       if( Validator::Is_Empty($this->attributes['email']) || Validator::Is_Empty($this->attributes['password'])  ){  
           $this->error['email'] = "email or password is required";  
       }  
       if( ! Validator::Validate_email($this->attributes['email']) ){  
           $this->error['email'] = "Invalid email";  
       }  
  
       $result = Validator::Validate_password($this->attributes['password']);  
       if (! $result['valid']) {  
           $this->error['password'] = $result['message'];  
       }  
//       return empty($this->error);  
   }  
    public static function  validate($attributes){  
        $instance = new static($attributes);  
        if ($instance->failed()){  
            throw new ValidationException($instance->error);  
        }  
        return $instance;  
    }  
    public function failed(){  
       return count($this->error);  
    }  
    public function getErrors(){  
        return $this->error;  
    }  
    public function adderror($field ,  $message){  
        $this->error[$field] = $message;  
    }  
    public function haserror($field){  
        return isset($this->error[$field]);  
    }  
}
 ```

## توضیح متد validate
```php
public static function  validate($attributes){  
	$instance = new static($attributes);  
	if ($instance->failed()){  
		throw new ValidationException($instance->error);  
	}  
	return $instance;  
}  
```
#### سوال
چرا در بالا از instance استفاده شد مگر نمیشد با this$ به متد و اجزای کلاس دسترسی داشت؟
#### جواب:
چون متد validate به صورت static تعریف شد و در فایل store برای استفاده از این متد از LoginForm::validate استفاده میشد یعنی متدی که استاتیک باشد نیاز به تعریف شی نداره پس ما شی نداریم یعنی همون this که به وسیله ی اون بتوانیم به اجزای کلاس مثل متد failed دسترسی داشته باشیم. پس وقتی درآینده یک شی از کلاس ساخته بشه $this به اون شی ساخته شده از کلاس اشاره میکنه که در این روش استاتیک ما نیازی به ساخت شی از کلاس نداریم.
#### سوال
برای تعریف شی ای که داخل متد static هم استفاده بشه چیکار باید کنیم؟
#### جواب
میتوان داخل متدهای استاتیک یک کلاس یک شی ساخت که فقط داخل همان متد به صورت شی ای از کلاس باهاش کارکرد
برای تعریف شی  مورد استفاده در متد استاتیک به صورت زیر عمل میکنیم:
```php
$instance = new static($attributes);
```
حالا این شیء توی متغیر `$instance` نگه‌داری میشه.
کلمه static یعنی یک شی از کلاسی که متد فعلی در آن هست بساز یعنی LoginForm اگر این متد در یک کلاس فرزندی که از کلاس loginForm ارث بری میکرد نوشته میشد اگر static مینوشتیم اشاره به کلاس فرزند و اگر self اشاره به کلاس والد LoginForm میکرد.
#### سوال
اگر بخواهیم  از کلاس ValidationException استفاده نکنیم چطوری باید خطاها رو به صفحه login بدیم؟
با استفاده از sessionها و ریدایرکت به صفحه login
```php
public static function validate($attributes){
    $instance = new static($attributes);

    if ($instance->failed()) {
        // خطاها رو توی session میذاریم
        \core\session::flash('error', $instance->getErrors());
        \core\session::flash('old', ['email' => $attributes['email']]);

        // ریدایرکت به صفحه login
        header("Location: /laracast-php/public/login");
        exit;
    }

    return $instance;
}

```
### نکات مهم:

1. چون Exception نداریم، **کد بعد از failed** دیگه اجرا نمیشه، به همین خاطر بعد از `header()` حتماً `exit;` بذار.
2. خطاها با `session::flash` ذخیره میشن و توی صفحه login با `session::get('error')` یا مشابهش میتونی نمایش بدی.
   3.دستور `return $instance;` هم فقط وقتی برمی‌گرده که همه چیز درست باشه (هیچ خطایی نباشه).
### نتیجه:
- **بدون Exception** → خطاها رو مستقیم با session و ریدایرکت مدیریت می‌کنیم.
- **با Exception** → خطاها پرتاب میشن و بالا میگیرنشون (`try/catch`) و بعد session/ریدایرکت انجام میشه.
### خلاصه validate
این  متد یک شی از کلاس LoginFotm میسازد و توسط attributes$ که از کاربر میگیره و متد سازنده عملیات validate رو انجام میده حالا این شی شامل تمام متدها و خاصیت های کلاس هم هست یعنی خاصیت error$ هم داره پس بررسی میکنیم اگر error$ خاصیت مقداردهی شده بود پس خطا داریم اگر نه خود شی رو برمیگردونه در نتیجه اون طرف یعنی فایل store کاربر باید نتیجه LoginForm::validate رو داخل یه متغیر مثل form بریزه.

## متد سازنده
با دستور بالا یک شی از کلاس ساختیم پس متد سازنده این کلاس فعال میشود در نتیجه موقع ساخت شی attributes$ رو به متد سازنده میدیم این attributes$ رو کاربر موقع نوشتن دستور زیر در فایل store به متد validate میفرسته:
```php
$form = LoginForm::validate($attributes=[  
    'email' => $_POST['email'],  
    'password' => $_POST['password']  
]);
```

 ---
## یک نکته در مورد خطا ها
وقتی کاربر فرم رو ارسال می‌کنه، `LoginForm::validate($_POST)` اجرا میشه.

اگه فیلدها درست نباشن (`email` خالی باشه یا `password` کوتاه باشه و ...) یعنی  خطا داشته باشیم مثلا رمز عبور باید شامل حرف بزرگ انگلیسی باشد اینجا این خطا توسط **ValidationException پرتاب میشه**.
این Exception توی `store.php` با `catch` گرفته میشه و پیام‌های خطا توی **session** ذخیره میشن: یعنی خطاها در آرایه error$

وقتی اعتبارسنجی فیلدها درست باشه، `authenticator->attempt($email, $password)` اجرا میشه.
اگر کاربر با این ایمیل و پسورد پیدا نشد → خطا **مستقیماً در session** ذخیره میشه و ریدایرکت انجام میشه. یعنی خطاها در session['error']

---
## بخش بعدی این جلسه

### 🔹 قدم اول: گرفتن (catch) خطای ValidationException
- وقتی ما در متد `validate` چیزی درست نباشه، به جای return کردن، یک **Exception** پرتاب (throw) می‌کنیم.
- در بیرونش، با `try/catch` اون خطا رو می‌گیریم (`catch ValidationException`).
  توی catch می‌تونیم **هر واکنشی که بخوایم** انجام بدیم:
  1- ذخیره کردن خطاها در session (Flash errors)
  2- ذخیره کردن داده‌های قدیمی فرم (Flash old data)
  3- برگشت به صفحه‌ی login
  👉 پس: اگه اعتبارسنجی شکست خورد → خطاها و داده‌های قبلی ذخیره می‌شن → کاربر دوباره به همون صفحه برمی‌گرده.
### 🔹 راه‌حل: نگه داشتن خطاها و داده‌های قدیمی داخل Exception
- ایده اینه که اطلاعات موردنیاز (errors و attributes) رو همراه خود Exception ذخیره کنیم.
- یعنی وقتی خطا پرتاب می‌کنیم، Exception همون موقع این داده‌ها رو توی خودش نگه داره.
- بعد که اون رو catch کردیم، از داخل Exception این داده‌ها رو بیرون بکشیم.

### 🔹 ساخت یک **static constructor**

- توی کلاس `ValidationException` یک متد static به اسم `throw` می‌سازیم (اسم دلخواهه).
- این متد کارش اینه که:
1. یک **instance جدید** از ValidationException بسازه.
2. به اون instance داده‌های اضافه (مثلاً errors و attributes) رو بده.
3. اون instance رو throw کنه.

کدی شبیه به این:
```php
class ValidationException extends \Exception  
{  
    protected $errors = [];  
    public array $attributes = [];  
  
    public static function throw($errors, $attributes) {  
        $instance = new static;        // یک شیء جدید بساز  
        $instance->errors = $errors;   // خطاها رو داخلش ذخیره کن  
        $instance->attributes = $attributes; // داده‌های قدیمی فرم رو هم ذخیره کن  
        throw $instance;               // پرتاب کن  
    }  
  
    public function getErrors() {  
        return $this->errors;  
    }  
}
```
### 🔹 استفاده در LoginForm

به جای اینکه مستقیماً  درمتد validate این دستور       `throw new ValidationException;` بنویسیم، حالا اینطوری می‌نویسیم:
```php
ValidationException::throw($instance->error,$instance->attributes);
```
## فایل Store
در این فایل موقع مقدار دادن به سشن ها در ساختار catch  به صورت زیر عمل میکنیم:
```php
catch (\core\ValidationException $exception){  
    session::flash('error',$exception->error);  //مقدار دادن به خطاها
    session::flash('old', ['email' => $exception->attributes['email']]);  //مقداردادن داده های قبلی
    return Redirect("/laracast-php/public/login");  
}
```
پس محتوای کامل فایل store به صورت زیر هست:
```php
<?php  
  
use core\authenticator;  
use http\Forms\LoginForm;  
use core\session;  
    try{  
        $form = LoginForm::validate($attributes=[  
            'email' => $_POST['email'],  
            'password' => $_POST['password']  
        ]);  
        if( (new authenticator())->attempt($attributes['email'] , $attributes['password']) ) {  
            Redirect("/laracast-php/public");  
        }  
        session::flash('error', ['email' => 'No Matching Account Found for that email address and password']);  
        session::flash('old', ['email' => $_POST['email']]);  
        return Redirect("/laracast-php/public/login");  
    }catch (\core\ValidationException $exception){  
        session::flash('error',$exception->error);  
        session::flash('old', ['email' => $exception->attributes['email']]);  
        return Redirect("/laracast-php/public/login");  
    }
```
حالا برگردیم به کلاس ValidationException
```php
public $error = [];  
public array $attributes = [];  
  
public static function throw($error, $attributes) {  
    $instance = new static;        // یک شیء جدید بساز  
    $instance->error = $error;   // خطاها رو داخلش ذخیره کن  
    $instance->attributes = $attributes; // داده‌های قدیمی فرم رو هم ذخیره کن  
    throw $instance;               // پرتاب کن  
}
```
خاصیت یا property های error$ و attributes$  را به 3 صورت میشه استفاده کرد:
### 1- تعریف خاصیت ها به صورت public
```php
public $error = [];
public $attributes = [];
```
دیگه هرجایی خواستیم می‌تونیم مستقیم بخونیمش.
```php
catch (ValidationException $exception)
{
	$exception->error;
	$exception->attributes['email'];
	$exception->attributes['password'];
}
```
### 2- ساخت Getter Method
یه متد مثل `getErrors()` درست کنیم که مقدار رو برگردونه.  
→ این روش تمیزتر و شیء‌گراتر هست.
مثلا:
```php
public function getErrors() {
    return $this->errors;
}
```
### 3- دستور public + readonly (فقط PHP 8.1 به بالا)
عنی property عمومی باشه ولی فقط یک بار مقداردهی بشه (مثلاً در سازنده یا همون لحظه‌ی throw شدن).  
→ بعدش دیگه هیچ‌کس نتونه مقدارش رو تغییر بده.
```php
public readonly array $errors;
public readonly array $old;
```
1. این روش ترکیبیه:
- هم از بیرون قابل خوندنه (public).
- هم امنیت داره چون نمی‌شه دوباره تغییرش داد (readonly).
## نکته
متغیر exception که داخل catch هست در واقع همونی شی ای هست که در کلاس ValidationException ساختیم یعنی instance$ پس **بله، exception دقیقاً همون شیء `ValidationException` هست که تو کلاس ساختیم، فقط ما قبل از پرتاب کردنش (throw) داده‌هامون رو ریختیم توش.**

---
# بخش پایانی
## 🔹 ۱. انتقال try/catch به سطح بالاتر (index.php)

تو فایل store.php ما از ساختار try-catch استفاده کرده بودیم حالا میخواهیم این ساختار try-catch  به ریشه سایت یعنی فایل index.php برود پس در فایل  store.php  ساختار try-catch رو پاک میکنیم.
محتوای قدیمی store.php
```php
<?php  
  
use core\authenticator;  
use http\Forms\LoginForm;  
use core\session;  
    try{  
        $form = LoginForm::validate($attributes=[  
            'email' => $_POST['email'],  
            'password' => $_POST['password']  
        ]);  
        if( (new authenticator())->attempt($attributes['email'] , $attributes['password']) ) {  
            Redirect("/laracast-php/public");  
        }  
        session::flash('error', ['email' => 'No Matching Account Found for that email address and password']);  
        session::flash('old', ['email' => $_POST['email']]);  
        return Redirect("/laracast-php/public/login");  
    }catch (\core\ValidationException $exception){  
        session::flash('error',$exception->error);  
        session::flash('old', ['email' => $exception->attributes['email']]);  
        return Redirect("/laracast-php/public/login");  
    }
```
محتوای جدید فایل store.php
```php
<?php  
  
use core\authenticator;  
use http\Forms\LoginForm;  
use core\session;  
        $form = LoginForm::validate($attributes=[  
            'email' => $_POST['email'],  
            'password' => $_POST['password']  
        ]);  
        if( (new authenticator())->attempt($attributes['email'] , $attributes['password']) ) {  
            Redirect("/laracast-php/public");  
        }  
        session::flash('error', ['email' => 'No Matching Account Found for that email address and password']);  
        session::flash('old', ['email' => $_POST['email']]);  
        return Redirect("/laracast-php/public/login");  
```
و حالا به ریشه سایت فایل index.php رفته قسمتی که مسیریابی انجام میشود داخل try میذاریم:
```php
try {  
    $router->route($url, $method);  
    \core\session::unflash();  
}catch (\core\ValidationException $exception){  
    \core\session::flash('error',$exception->error);  
    \core\session::flash('old', ['email' => $exception->attributes['email']]);  
    return Redirect("/laracast-php/public/login");  
}
```
✍️ نکته:
- اینطوری همه‌ی خطاهای اعتبارسنجی توی یک نقطه گرفته میشن.
- دیگه لازم نیست توی LoginForm یا Controller تکرار کنیم.
- کلا برای جلوگیری از اینکه توی هرکنترلر باید ساختار try-catch رو مینوشتیم این ساختار رو به فایل index انتقال دادیم.
---
## مکانیزم کلی Exception در PHP

- وقتی `throw new Exception(...)` اجرا میشه، PHP برنامه رو **متوقف می‌کنه** و دنبال یک `catch` می‌گرده.
- جستجو از همون جایی شروع میشه که `throw` شده.
- اگر در همون بلوک کدی که `throw` شد، یک `try/catch` بود → اونجا خطا گرفته میشه.
- اگر نبود → خطا به سطح بالاتر میره (جایی که این کد صدا زده شده).
- همین‌طور بالا میره تا برسه به `index.php` یا حتی PHP خودش (که دیگه Fatal error میده).
## چندتا try/catch میشه داشت؟
بله ✅  
تو می‌تونی هرجا نیاز داشتی `try/catch` بذاری.
- بعضی وقتا می‌خوای **همون‌جا** خطا رو هندل کنی.
- بعضی وقتا می‌خوای خطا بره بالا (propagate بشه) تا جای دیگه هندل بشه.

## جمع‌بندی

- هرجا `throw` کنی → دنبال نزدیک‌ترین `catch` می‌گرده.
- می‌تونی چندجا `try/catch` بذاری.
- اگه هیچ‌جا catch نکنه → PHP می‌ترکه (Fatal Error).
- توی پروژه‌های حرفه‌ای معمولاً یک **global try/catch** توی entry point (مثل `index.php`) می‌ذارن که همه خطاهای پروژه اونجا جمع بشه.
## سوال
وقتی ما در پروژمون چندجا از ساختار try-catch استفاده کرده باشیم بعد یه جا throw Exception بشه یعنی خطا پرتاب بشه همه ی اون try-catch ها خزای ما رو میگیرن؟
## جواب
وقتی `throw` کردی:
1.برنامه PHP دنبال **نزدیک‌ترین `try/catch`** می‌گرده.
2.اگه پیدا کرد → همون یکی اجرا میشه و کار تمومه.
2.اگه پیدا نکرد → میره یه سطح بالاتر (جایی که تابع/کلاس صدا زده شده).
2.همین‌طور ادامه میده تا برسه به بالاترین سطح (`index.php`).
2 اگه هیچ‌جا `catch` نباشه → برنامه می‌ترکه (Fatal Error).
مثال
```php
function level3() {
    throw new Exception("خطا در لول 3");
}

function level2() {
    try {
        level3();
    } catch (RuntimeException $e) { // نوع درست نیست
        echo "گرفتمش در level2\n";
    }
}

function level1() {
    try {
        level2();
    } catch (Exception $e) { // اینجا می‌خوره
        echo "گرفتمش در level1: " . $e->getMessage() . "\n";
    }
}

level1();

```
خروجی
```php
گرفتمش در level1: خطا در لول 3
```
👉 اینجا فقط `catch` در `level1` اجرا شد، نه همه‌ی `try/catch`ها.

---
## 🔹 ۲. Redirect به آدرس قبلی

اوایل مستقیم به `/login` برمی‌گشتیم.  
ولی جفری میگه بهتره به همون صفحه‌ای که کاربر فرم رو پر کرده بود برگردیم.
- برای اینکار از `$_SERVER['HTTP_REFERER']` استفاده می‌کنیم (آدرس قبلی).
- توی کلاس Router متدی می‌سازیم:
```php
public function previousUrl()
{
    return $_SERVER['HTTP_REFERER'];
}
```

بعد توی index.php:
```php
try {  
    $router->route($url, $method);  
    \core\session::unflash();  
}catch (\core\ValidationException $exception){  
    \core\session::flash('error',$exception->error);  
    \core\session::flash('old', ['email' => $exception->attributes['email']]);  
    return Redirect($_SERVER['HTTP_REFERER']);  //اینجا آدرس تغییر کرد
}
```
---
## 🔹 ۳. تمیز کردن LoginForm

چون `try/catch` رو به index.php بردیم، توی `LoginForm` فقط لازمه **پرتاب خطا** رو مدیریت کنیم.

پس تابع زیر را در LoginForm اضافه می‌کنیم:
```php
public function throw()
{
    throw new ValidationException($this->errors, $this->attributes);
}
```
وبعد در همین کلاس  در متد validate:
```php
if ($instance->failed()) {
    $instance->throw();
}
return $instance;
```
یا به صورت خلاصه متد validate به شکل زیر میشود:
```php
public static function  validate($attributes){  
    $instance = new static($attributes);  
    return $instance->failed() ? $instance->throw() : $instance;  //اینجا کد تغییر کرد و به صورت خلاصه شد
}
```
---
## 🔹 ۴. زنجیره‌سازی (Fluent Interface) در addError
متد adderror در کلاس LoginForm به صورت زیر بود
```php
public function adderror($field ,  $message){  
    $this->error[$field] = $message;  
}
```
اگر ما بخواهیم به صورت زنجیره ای chaning از این متد استفاده کنیم باید شی جاری رو برگردونیم پس:
```php
public function adderror($field ,  $message){  
    $this->error[$field] = $message;  
    return $this;  
}
```
پس فایده‌اش اینه که می‌تونیم متدها رو پشت‌سر هم زنجیره کنیم مثل:
```php
$form->addError("email", "No matching account found")->throw();
```
اما توضیح کد بالا:
به شیء `$form` (که همون `LoginForm` هست) بگو:  
→ برای فیلد `email` یک خطا با متن `"No matching account found"` ذخیره کن.
و چون در `addError` شی جاری رو برگردوندی
بعد از اجرای `addError`، همچنان **همون شیء `$form`** برمی‌گرده.
پس می‌تونی بلافاصله بعدش متد دیگه‌ای صدا بزنی.  
پس `->throw()` روی همون `$form` اجرا میشه.
این متدthrow هم  بلافاصله یک **Exception سفارشی** پرتاب می‌کنه که شامل:
- همه‌ی خطاها (`$this->errors`)
- داده‌های فرم (`$this->attributes`)
## معنی کلی
به زبان ساده یعنی:
«برای فیلد ایمیل یک خطا ذخیره کن، بعد بلافاصله یک `ValidationException` پرتاب کن که این خطاها رو با خودش داشته باشه.»

---
## فایل store
الان فایل store ما به صورت زیر هست:
```php
<?php  
  
use core\authenticator;  
use http\Forms\LoginForm;  
use core\session;  
        $form = LoginForm::validate($attributes=[  
            'email' => $_POST['email'],  
            'password' => $_POST['password']  
        ]);  
        if( (new authenticator())->attempt($attributes['email'] , $attributes['password']) ) {  
            Redirect("/laracast-php/public");  
        }  
        session::flash('error', ['email' => 'کاربری با این ایمیل و رمز عبور وجود ندارد']);  
        session::flash('old', ['email' => $_POST['email']]);  
        return Redirect("/laracast-php/public/login");
```
توضیح 3خط آخر کد یعنی :
```php
	session::flash('error', ['email' => 'کاربری با این ایمیل و رمز عبور وجود ندارد']);  
	session::flash('old', ['email' => $_POST['email']]);  
	return Redirect("/laracast-php/public/login");
```
اگر احراز هویت کاربر انجام نشود یعنی ایمیل و پسورد وارد شده در پایگاه داده موجود نباشد متد attempt خروجی false رو برمیگردونه پس این 3خط ما اجرا میشن این سه خط میان در سشن خطا رو مینویسند بعد مقدار قدیمی فیلد ایمیل رو هم در سشن میریزه تا مراجعه بعدی به فرم login مقدار ثبت شده کاربر برای ایمیل نمایش داده شود و در نهایت به صفحه ی login ریدایرکت میکنیم.
#### نکته
اگر قسمت catch فایل index.php ریشه سایت مراجعه کنیم میبینیم کار همین 3 خط رو انجام میدند پس ما میتونیم این 3 خط فایل store رو پاک کنیم بعد به جاش یک exception پرتاب کنیم قسمت catch فایل index آن را گرفته و کد به درستی انجام میشود پس به جای سه خط کد زیر را مینویسیم:
```php
$form->adderror("email","کاربری با این ایمیل و پسوورد وجود ندارد")->throw();
```
پس کد نهایی فایل store به صورت زیر شد که خیلی خلاصه و منظم تر شد:
```php
use core\authenticator;  
use http\Forms\LoginForm;  
$form = LoginForm::validate($attributes=[  
    'email' => $_POST['email'],  
    'password' => $_POST['password']  
]);  
if( (new authenticator())->attempt($attributes['email'] , $attributes['password']) ) {  
    Redirect("/laracast-php/public");  
}  
$form->adderror("email","کاربری با این ایمیل و پسوورد وجود ندارد")->throw();
```
- اگر لاگین موفق بود → ریدایرکت به صفحه اصلی.
- اگر لاگین شکست خورد → خطا به فرم اضافه میشه و بلافاصله پرتاب (throw) میشه.
- اون throw در نهایت توسط **catch در index.php** گرفته میشه → فلش می‌کنه و کاربر برمی‌گرده به صفحه قبلی.