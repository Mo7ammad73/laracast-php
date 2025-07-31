در این بخش قرار هست دو if  که در جلسه قبل برای بررسی وجود داشتن یادداشت not found و اجازه ی دیدن اطلاعات و صفحه  forbidden نوشته بودیم متدهایی در کلاس database  بنویسیم پس:

<div dir="ltr">

```php
    public function findOrFail() {
        $result = $this->statement->fetch();
        if (! $result) {
            http_response_code(404);
            header("Location:/view/404.html");
            exit();
        }
        return $result;
    }


```
<div dir="rtl">
تابع بالا را به جای دستور زیر نوشتیم یعنی اگه یادداشتی پیدا نشد خود کلاس این قضیه رو مدیریت میکنه و نیازی نیست خارج از کلاس if بنویسیم :
<div dir="ltr">

```php
    if (!$note) {
        http_response_code(Response::NOT_FOUND);
        require "views/errors/404.php";
        exit();
}
```
# Authorize()تابع
```php

    function Authorize($condition, $status = 403) {
        if (! $condition) {
            http_response_code($status);
            header("Location:/index.php");
            exit();
        }
    }

```
<div dir="rtl">
تابع بالا را به جای دستور زیر نوشتیم یعنی اگه شرط رد شد (مثلاً کاربر اجازه نداشت)، من خودم خطای 403 می‌دم.:
<div dir="ltr">

```php

    if ($note['user_id'] != $current_userid) {
        http_response_code(Response::FORBIDDEN);
        require "views/errors/403.php";
        exit();
    }

```
<div dir="rtl">
پس در نتیجه :
<div dir="ltr">

```php

    // قبلاً
    $note = ...; // اجرا query
    if (! $note) { ...404... }
    if ($note['user_id'] != $current_user_id) { ...403... }
    
    // الان
    $note = $db->query(...)->findOrFail();
    Authorize($note['user_id'] == $current_user_id);

```
<div dir="rtl">
ما در متد query  در کلاس database یک $statement داشتیم که کد sql که prepare شده بود رو نگه میداشت . اما این statement فقط در همان محدوده متد query قابل اجراست برای اینکه جاهای دیگه مثل متد findOrFail استفاده کنیم باید ابتدا آن را به عنوان مشخصه کلاس تعریف کنیم سپس در متد query به صورت زیر اطلاعات را درونش بریزیم:

<div dir="ltr">

```php
    public $statement;
    public function query($query , $params = [])
        {
            try {
                $this->statement = $this->connection->prepare($query);
                $this->statement->execute($params);
                return $this;
            }
            catch (Exception $e) {
                echo "خطا در اجرای دستورات query" . $e->getMessage();
            }
        }
```
<div dir="rtl">

تابع Authoize یک تابع عمومی هست و میتوان در function.php یا همان صفحه note تعریف کرد اما تابع findorfail متد database هست و باید در کلاس database تعریف شود.
فقط دو متد fetch و get هم باید در کلاس Database تعریف شود که fetch برای حالتی که میخواهیم فقط رکورد پایگاه داده برگشت داده شود و چک نشود و get هم به جای fetchAll که در فایل notes.php زده ایم استفاده میشود.

<div dir="ltr">

```php
    
        public function fetch(){
            return $this->statement->fetch();
        }
        
        public function get(){
            return $this->statement->fetchAll();
       }

```