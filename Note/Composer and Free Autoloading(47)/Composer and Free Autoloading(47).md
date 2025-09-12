### 1. شروع بحث جدید

جفری (مدرس) میگه:  
**وقتشه وارد یک فصل جدید بشیم: Composer.**  
در واقع Composer یکی از مهم‌ترین ابزارهای PHP هست و تقریباً همه پروژه‌های حرفه‌ای PHP و مخصوصاً فریمورک‌هایی مثل **Laravel** بهش وابسته‌اند.

---
### 2. کامپوزر Composer چیست؟
- کامپوزرComposer یک **Dependency Manager** (مدیر وابستگی‌ها) برای PHP هست.
- یعنی چی؟ یعنی وقتی پروژه‌ات به کد یا کتابخونه‌های دیگه نیاز داشته باشه (وابستگی‌ها)، Composer میاد اون‌ها رو برایت نصب و مدیریت می‌کنه.

---
### 3. بسته Package چیست؟
- بسته Package (یا همان پکیج) در اصل **یک سری فایل و کد آماده** هست.
- یک برنامه‌نویس ممکنه یک قابلیت خاصی رو بنویسه (مثلاً اتصال به Amazon S3 برای ذخیره‌سازی فایل‌ها) و اون رو به صورت یک Package منتشر کنه.
- بعدش تو می‌تونی بدون اینکه دوباره همه اون کدها رو بنویسی، اون پکیج رو نصب و استفاده کنی.

📦 **مثال‌هایی** در مورد پکیج ها:
- اگر بخوای با **Amazon S3** (سرویس ذخیره‌سازی آمازون) کار کنی → نیازی نیست خودت همه APIها رو پیاده‌سازی کنی → یک پکیج آماده هست.
- اگر بخوای تست‌نویسی کنی → پکیج‌هایی مثل PHPUnit یا Pest هستن.
- اگر بخوای ابزار خط فرمان (Console App) بسازی → پکیج Symfony Console هست.
- اگر بخوای ظاهر خط فرمان رو خوشگل کنی → پکیج Termwind هست.
- و...

---
### 4. سایت‌های مهم
تو این جلسه وارد دو سایت شدیم که برای کارهای این جلسه نیاز هست.
سایت **getcomposer.org**
- سایت رسمی Composer هست.
- از اینجا باید خود Composer رو دانلود و نصب کنی.  
  سایت **packagist.org**
- بزرگ‌ترین مخزن (Repository) پکیج‌های PHP هست.
- هر وقت چیزی لازم داشتی، می‌تونی اینجا بگردی و پکیج مناسب رو پیدا کنی مثل پکیج termwind یا symfony
---
### 5. نصب Composer
وارد سایت **getcomposer.org** شد → روی **Download** کلیک کرد.  
اونجا یک سری دستور برای نصب Composer نوشته شده.  
معمولاً چیزی شبیه این هست:

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
قبل توضیح خط به خط کدهای بالا میریم انواع روش های اجرا کد php در خط فرمان رو بررسی میکنیم:

---
---

### 1. اجرای مستقیم فایل PHP
با دستور cd  در خط فرمان به پوشه ای که فایل php  در آن قرار دارد میرویم بعد با دستور زیر فایل php احرا میشود:
```bash
php filename.php
```
### 2. اجرای کد مستقیم از خط فرمان
کد php کوتاه رو بدون استفاده از فایل و با خط فرمان اجرا میکنیم .
```bash
php -r " echo 'ya mola' ; "
```
در دستور بالا کل دستور php بین دابل کوتیشن " " قرار دارد و متنی که قرار است چاپ شود بین سینگل کوتیشن ' ' قرار دارد.
```bash
php -r "for($i=0; $i<5; $i++) { echo $i . PHP_EOL; }"
```
در کد بالا خروجی 0 تا 4 که هرعدد در یک خط هست نمایش داده میشود.
### 3. اجرای کد با استفاده از pipe  |
در این روش در خط فرمان با دستور echo  خود خط فرمان و علامت پایپ| کد مورد نظر را اجرا میکنیم:
```bash
echo "<? Code PHP ?>" | php
echo "<?php echo 'ali mola'; ?>" | php
```
### 4. اجرای سرور داخلی PHP (برای توسعه)
در این روش به پوشه ای که فایل php آنجاست میرویم بعد سرورداخلی رو راه اندازی میکنیم بعد با توجه به پورت راه اندازی شده به مرورگر میرویم خروجی فایل را مشاهده میکنیم.
```bash
# 1. به پوشه پروژه بروید
cd /path/to/your/project #میتونه هر آدرسی باشه

# 2. یک فایل index.php ایجاد کنید
echo "<?php echo 'سلام! این سرور داخلی PHP کار می‌کند!'; ?>" > index.php 
#در کد بالا کلمه اکو اول جمله و علامت > آخر مربوط به خط فرمان هست

# 3.حالا  سرور را راه‌اندازی کنید
php -S localhost:8000

# 4. حالا به مرورگر بروید و آدرس localhost:8000 را باز کنید
#خروجی مورد نظر رو میبیند
```
### 5. بررسی اطلاعات PHP
```bash
php -v          # نسخه PHP
php -i          # اطلاعات کامل پیکربندی
php -m          # ماژول‌های نصب شده
```
---
---


```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
بریم سراغ توضیح خط به خط کدهای بالا

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
```
دستور بالا از دو بخش تشکیل شده :
1- دستور php -r  که برای اجرای یک قطعه کد PHP مستقیماً از طریق خط فرمان (command line) بدون نیاز به ایجاد فایل جداگانه استفاده می‌شود و بسیار ساده و کاربردی است.
2- دستور copy که از سایت  "https://getcomposer.org/installer" فایل نصب رو دانلود کرده و محتوای آن را درون فایل composer-setup.php قرار میدهد. یا به عبارت دیگر محتوای اول رو در محتوای دوم کپی میکند.
```bash
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
```
- مقدار هش (digest) فایل دانلودشده را با الگوریتم SHA-384 محاسبه می‌کند.
- آن مقدار هش با یک رشته (که از سایت رسمی گرفته شده) مقایسه می‌شود. اگر برابر باشد، `Installer verified` چاپ می‌شود؛ اگر نه، `Installer corrupt` چاپ شده و فایل حذف (`unlink`) و اجرا با کد خطا `exit(1)` قطع می‌گردد.
- هدف: **تأیید یکپارچگی و عدم دستکاری** فایل نصاب — خیلی مهم برای امنیت، یعنی مطمئن بشی چیزی که دانلود کردی همان چیزی است که سازنده منتشر کرده.
```bash
php composer-setup.php
```
- اجرا کردن خودِ اسکریپت نصب (`composer-setup.php`) توسط مفسر PHP. این اسکریپت محیط را چک می‌کند (نسخه PHP، اکستنشن‌های لازم، مجوزها و ...)، سپس فایل اجرایی Composer را دانلود می‌کند (فایلی با نام `composer.phar` که یک PHAR — بسته‌ی تک‌فایلی PHP — است).
- خروجی‌هایی مثل `All settings correct for using Composer` از همین اسکریپت نصاب می‌آیند (می‌گوید سیستم تو شروط لازم رو داره).
  این دستورات:
1. فایل نصب‌کننده Composer رو دانلود می‌کنن.
2. اون رو اجرا می‌کنن تا Composer نصب بشه.
3. فایل نصاب حذف میشه.
```bash
php -r "unlink('composer-setup.php');"
```
حذف فایل نصاب (دیگه لازم نیست و حذفش می‌کنیم تا فایل اضافی روی سیستم نمونه).

### ادامه
حالا ما این چند خط کد رو از سایت getcomposer بخش download کپی کرده و در خط فرمان جایگذاری میکنیم بعد خروجی زیر را میبینیم:
```bash
Installer verified
All settings correct for using Composer
Downloading...

Composer (version 2.8.11) successfully installed to: C:\Users\Mohammad110\composer.phar
Use it: php composer.phar
```

# 2) معنی خروجی‌ای که دیدی

ترمینال تو این‌ها رو چاپ کرده:

- جمله `Installer verified`  
  → پیام از اسکریپت بررسی هش؛ یعنی هش فایل دانلودشده با مقدار مورد انتظار در سایت مطابقت داشت — **خوب**.
- جمله `All settings correct for using Composer`  
  → بررسی‌های اولیه نصب (مثل نسخه PHP و اکستنشن‌ها) OK هستند.
- کلمه `Downloading...`  
  → نصاب در حال دانلود فایل نهایی `composer.phar` است.
- جمله `Composer (version 2.8.11) successfully installed to: C:\Users\Mohammad110\composer.phar`  
  → نصب موفق! فایل `composer.phar` در مسیر خانه کاربر قرار گرفته. نسخه‌ی نصبی هم 2.8.11 هست.
- جمله `Use it: php composer.phar`  
  → راه استفاده فوری: از همون پوشه‌ای که `composer.phar` هست، می‌تونی این‌طور صداش کنی: `php composer.phar <command>`.

### فایل composer.phar
- فایل `composer.phar` یک **PHAR** (PHP Archive) است: یعنی یک فایل تک که تمام کد Composer را در خودش دارد. برای اجرا لازم است php موجود در PATH باشد و دستور `php composer.phar` اجرا شود.
- جایگزین راحت‌تر: می‌شه `composer` را بصورت فرمان سراسری (global) در PATH قرار داد تا لازم نباشد همیشه `php` و مسیر فایل را بنویسی.
---
### 6. اضافه کردن به PATH

جفری گفت:  
بعد از نصب، باید فایل `composer.phar` رو در یک فولدری بذاری که داخل **PATH** سیستم باشه.  
این کار باعث میشه توی ترمینال فقط تایپ کنی:

`composer`

و Composer اجرا بشه. (یعنی نیازی به آدرس کامل فایل نباشه).

### چرا باید Composer داخل PATH باشه؟
وقتی یک برنامه (مثل `composer.phar`) داخل یک پوشه‌ی خاص قرار داره، سیستم‌عامل فقط وقتی می‌تونه اون رو پیدا کنه که:
- یا **تو دقیقا آدرس کاملش رو بنویسی**.  
  مثلا:
```bash
php C:\Users\Mohammad110\composer.phar --version
```
- **یا اونو به PATH  اضافه کنی**
  پس:
- اگر `composer.phar` داخل PATH باشه، می‌تونی خیلی راحت فقط بنویسی:
  `composer --version`

✅ و اجرا میشه.
- ولی اگر نباشه، باید همیشه `php composer.phar` یا مسیر کاملش رو بزنی → که هم طولانیه و هم اذیت‌کننده.

### چه جوری فایل composer.phar رو به PATH اضافه کنم:

اول اینو بگم وقتی دستور نصب composer رو زدیم و در جوابی که بهمون داد مسیر فایل composer.phar رو بهم گفت یعنی:
```bash
Composer (version 2.8.11) successfully installed to: C:\Users\Mohammad110\composer.phar
```
یعنی در پوشه Mohammad110 قرار داره پس به این پوشه میریم این فایل را کپی کرده و در مسیر درایو c و پوشه Program Files بعد composer و بعد bin قرار میدهیم سپس در همینجا علاوه بر فایل composer.phar یک فایل با نام composer.bat هم میسازیم و درونش کد زیر را مینویسیم:
```bash
@echo off
php "%~dp0composer.phar" %*
```
(این باعث میشه هر وقت `composer` رو تایپ کردی، در اصل `php C:\ProgramFiles\composer\bin\composer.phar` اجرا بشه.)
حالا میریم این پوشه رو در PATH اضافه کنیم پس مسیر زیر را دنبال کرده :
```text
This Pc - Properties - Advanced System Settings - Environment Varailbles 
```
حالا دو بخش وجود دارد کاربر جاری یا همه ی کاربران سیستم که ما همه ی کاربران سیستم را اتخاب کرده بعد path رو پیدا کرده  و edit بعد مسیرمون را اضافه میکنیم.
حالا اگر در خط فرمان composer بنویسیم میبینیم که اجرا میشود.

---

✅ پس تا اینجای ویدیو:

- فهمیدیم Composer چیه (مدیریت وابستگی‌ها).
- فهمیدیم Package چیه (کد آماده برای استفاده).
- سایت اصلی برای نصب Composer رو دیدیم.
- سایت Packagist رو دیدیم که مخزن پکیج‌هاست.
- روش های اجرای php  در خط فرمان رو یاد گرفتیم.
- یاد گرفتیم باید Composer رو نصب کنیم و داخل PATH بذاریم.

---
### دستور `composer init`

این دستور برای ایجاد فایل **`composer.json`** استفاده میشه.  
این فایل قلب Composer هست و تنظیمات پروژه‌ت رو نگه می‌داره (مثل dependencies، autoload، اسم پروژه و ...).

وقتی بزنی:
```bash
composer init 
```
یه **wizard (راهنما)** میاد که قدم به قدم ازت سوال می‌پرسه تا فایل `composer.json` ساخته بشه.

---
### سوالاتی که می‌پرسه (طبق ویدیو)

- **package name** → اسم پروژه (مثلاً `myapp/test`)
- **description** → توضیح کوتاه (اختیاری)
- **author** → نویسنده (اختیاری)
- **minimum stability** → سطح پایداری (مثلاً stable)
- **type** → نوع پروژه (library یا project)
- **license** → لایسنس (اغلب MIT یا بدون مقدار)
- **dependencies** → می‌پرسه الان می‌خوای پکیج نصب کنی یا نه؟ (اون گفت: "نه، خودم دستی اضافه می‌کنم.")
- **dev dependencies** → مشابه بالایی ولی برای توسعه (اونم گفت نه).
- **autoload (PSR-4 mapping)** →
- می‌پرسه می‌خوای autoload تعریف کنی؟ اون گفت "skip" چون می‌خواست دستی آموزش بده.
- **vendor dir in .gitignore** →
- می‌پرسه می‌خوای پوشه `vendor` تو `.gitignore` باشه یا نه؟ (جوابش "بله" هست چون `vendor` فایل‌های دانلودی هست و نباید داخل Git قرار بگیره).

---
### خروجی بعد از اجرا
بعد از اجرای این مراحل، دو فایل جدید ساخته میشه:
1. فایل **`composer.json`** → فایل اصلی تنظیمات Composer.
2. فایل **`.gitignore`** → برای اینکه پوشه `vendor/` داخل git ذخیره نشه.
   یک پوشه vendor هم ایجاد میشه.
   در هر جا که مسیر خط فرمان باشه این دو فایل اونجا ایجاد میشه.

---
### نکته autoload
اون گفت فعلاً autoload (PSR-4 mapping) رو skip می‌کنه، چون می‌خواد دستی بهتون نشون بده.  
بعداً توی پروژه یاد می‌گیری چطوری پوشه `src` یا `app` رو map کنی به namespace با PSR-4.

---
✅ پس خلاصه‌ :  
با دستور `composer init` یک فایل `composer.json` ساخته شد و توی اون پکیج‌ها و تنظیمات autoload و gitignore مدیریت میشه.

---
### فایل `.gitignore` و vendor

- جفری میگه وقتی تو `composer init` قبول کردی که vendor رو ignore کنه، یه خط داخل فایل `.gitignore` اضافه شد:
  `/vendor/`
- یعنی اگه بعداً vendor ساخته بشه (با پکیج‌ها)، **Git این پوشه رو نادیده می‌گیره** و توی ریپازیتوری push نمی‌کنه.

---

### چرا vendor رو نمی‌بینیم؟

- الان تو پروژه هنوز پوشه‌ی **vendor** ساخته نشده چون هنوز هیچ پکیجی نصب نکردی.
- پوشه vendor وقتی ساخته میشه که اولین بار `composer install` یا `composer require` اجرا کنی.

---
### دستور `composer install`

- وقتی این دستور رو زدی:
1. کامپوزر Composer نگاه می‌کنه داخل `composer.json` چه پکیجی تعریف شده.
2. چون چیزی تعریف نشده → میگه:    
   `Nothing to install, update or remove`
   ولی بازم دو کار انجام میده:        
   پوشه `vendor/` (اگه نبوده، می‌سازه).
   فایل autoload.php داخل vendor می‌سازه.
   فایل `composer.lock` ایجاد میشه (حتی اگه هیچ dependency نداشته باشی).

---

### ۴. تفاوت `composer.json` و `composer.lock`

- فایل `composer.json` → فایل تنظیمات و لیست پکیج‌هایی که **میخوای نصب کنی**.
- فایل`composer.lock` → فایل قفل (lock) که نسخه‌ی دقیق پکیج‌ها و وابستگی‌ها رو **که واقعاً نصب شدن** ذخیره می‌کنه.
- وقتی پروژه‌تو میدی به یه نفر دیگه، اگه بزنه `composer install` دقیقاً همون نسخه‌هایی که تو استفاده کردی براش نصب میشه.

---

### ۵. جمع‌بندی

دستور`composer init` → فقط json (و شاید vendor برای autoload).
- اگه توی init بخوای autoload تعریف کنی (مثلاً PSR-4)، اون موقع **پوشه vendor** هم ساخته میشه چون Composer باید autoload رو آماده کنه.
- اگه autoload تعریف نکنی، معمولاً vendor ساخته نمیشه.
  دستور`composer install` → vendor + autoload + composer.lock ساخته میشه.
- پوشه **vendor/** ساخته یا آپدیت میشه.
- فایل **composer.lock** ساخته میشه (نسخه دقیق پکیج‌ها رو ذخیره میکنه).
  پوشه  vendor همیشه جاییه که Composer همه‌ی پکیج‌ها رو اونجا میریزه.
  📌 نتیجه:

1. فایل **composer.json** ساخته میشه → این فایل تنظیمات پروژه‌ست (اسم، توضیح، پکیج‌ها و ...).
2. اگه موقع init بگی vendor توی gitignore باشه → یه فایل **.gitignore** ساخته میشه با خط `/vendor/`.
3. معمولاً تو این مرحله **vendor ساخته نمیشه**، مگر اینکه همون‌جا Composer برای autoload یه چیزی آماده کنه (پس ممکنه خالی بسازه، که تو دیدی).
### وقتی می‌زنی:
```bash
composer install
```
📌 نتیجه:

1. کامپوزر Composer میاد فایل **composer.json** رو می‌خونه و پکیج‌ها رو نصب می‌کنه (اگه چیزی تعریف کرده باشی).
2. پوشه **vendor/** ساخته یا به‌روزرسانی میشه (اینجا فایل autoload.php هم داخلشه).
3. فایل **composer.lock** ساخته میشه → این نسخه‌های دقیق پکیج‌هایی هست که نصب شدن.
---

### اتولود  Autoload

- حتی وقتی پکیجی نصب نکرده باشی، Composer باز هم یه کار مهم انجام میده:
  `Generating autoload files`
- این یعنی داره فایل autoload خودش رو می‌سازه (داخل vendor).
- فایل اصلی autoload میشه:
  `vendor/autoload.php`
- از این فایل بعداً می‌تونی داخل پروژه‌ی PHP خودت `require 'vendor/autoload.php';` بزنی تا کلاس‌ها و پکیج‌ها به‌صورت خودکار بارگذاری بشن (نیازی نیست دستی `include` کنی).
---

### 5. جمع‌بندی

- دستور `composer init` → فایل composer.json ساخته شد.
- فایل `.gitignore` → vendor رو ignore کرد.
- دستور `composer install` → dependencyها رو بررسی کرد، چون هیچی نبود چیزی نصب نکرد، ولی autoload ساخت.
- پوشه vendor → تا پکیجی نصب نکنی، خالی می‌مونه یا ساخته نمیشه.
---

### اضافه کردن autoload
قبلا ما از تابع spl_autoload_register برای ایجاد خودکار کلاس ها در پروژه بدون نیاز به require آن ها استفاده میکردیم الان میخواهیم این تابع را حذف کنیم و با استفاده از composer اینکار رو انجام دهیم.
الان ساختار فایل composer به صورت زیر میباشد:
```json
{  
    "name": "mohammad/laracast-php",  
    "type": "library",  
    "autoload": {  
        "psr-4": {  
            "Mohammad\\LaracastPhp\\": "src/",  
        }  
    },  
    "authors": [  
        {  
            "name": "Mohammad",  
            "email": "bakhshianmo@gmail.com"  
        }  
    ],  
    "minimum-stability": "stable",  
    "require": {}  
}
```
### ۱. اضافه کردن autoload در composer.json

درسته، وقتی می‌خوای به Composer بگی چطور کلاس‌ها رو خودش لود کنه، باید بخش `autoload` رو اضافه کنی.
در قسمتی که کلید autoload وجود دارد میخواهیم دوتا از فضای نام های پروژه مان را اضافه کنیم پس محتوای فایل composer.json  کلید autoload پس از نوشتن کد ما به صورت زیر میشود:
```json
{   
    "autoload": {  
        "psr-4": {  
            "Mohammad\\LaracastPhp\\": "src/",  
            "core\\": "core/",  
            "http\\Forms\\": "http/ّForms"  
        }  
    }
}
```

🔑 نکته‌ها:
- **نام‌فضا (namespace)** باید با `\\` (دوتا بک‌اسلش در JSON) نوشته بشه.
- مقدار سمت راست مسیر پوشه هست.
- دقت کن که حروف باید دقیقاً مثل پوشه باشن (یعنی `Http` با H بزرگ).

---
### ۲. اجرای دستور dump-autoload
در خط فرمان دستور زیر را مینویسیم:
```bash
composer dump-autoload
```
📌 این دستور باعث میشه Composer فایل‌های autoload رو دوباره تولید کنه (مثلاً `autoload_psr4.php`). درنتیجه تغییراتی که ما در فایل composer.json ایجاد کردیم با اجرای دستور بالا در فایل autoload_psr4 که در پوشه vendor/composer وجود دارد اعمال میشود.

---
### ۳. ساختار فایل `autoload_psr4.php`
در این فایل آرایه‌ای هست که namespace رو به پوشه وصل می‌کنه:
```json
<?php  
  
// autoload_psr4.php @generated by Composer  
  
$vendorDir = dirname(__DIR__);  
$baseDir = dirname($vendorDir);  
  
return array(  
    'http\\Forms\\' => array($baseDir . '/http/ّForms'),  
    'core\\' => array($baseDir . '/core'),  
    'Mohammad\\LaracastPhp\\' => array($baseDir . '/src'),  
);
```
---
### ۴. جایگزینی autoloader دستی

قبلاً ما `spl_autoload_register` می‌نوشتیم.  
الان کافیه توی `public/index.php` (یا هر فایل اصلی پروژه‌ت) بنویسی:
```php
require_once BASE_PATH . '/vendor/autoload.php';
```
---
### ۵. نتیجه

الان:
- هر وقت یه کلاس جدید توی `core/` یا `http/Forms/` بسازی
- و namespace بالاش رو درست تعریف کنی (مثلاً `namespace Core;`)
- نیازی به `require` دستی یا autoload دستی نداری.  
  کامپوزرComposer خودش می‌فهمه و لود می‌کنه ✅

---
### محتوای فایل index.php پس از تغییرات بالا

```php
<?php  
    session_start();  
    const BASE_PATH = __DIR__ . '/../';  
    require_once BASE_PATH . "core/function.php";  
    require_once BASE_PATH . "vendor/autoload.php";  
    require_once base_path("Bootstrap.php");  
  
    $router = new \core\Router();  
    require_once base_path('core/routes.php');  
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];  
    
    $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'] ;  
  
    try {  
        $router->route($url, $method);  
        \core\session::unflash();  
    }catch (\core\ValidationException $exception){  
        \core\session::flash('error',$exception->error);  
        \core\session::flash('old', ['email' => $exception->attributes['email']]);  
        return Redirect($_SERVER['HTTP_REFERER']);  
    }  
```