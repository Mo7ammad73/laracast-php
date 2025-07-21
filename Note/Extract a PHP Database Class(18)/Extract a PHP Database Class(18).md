در ادامه آموزش کار با پایگاه داده در این بخش میخواهیم کد قبلی را سازماندهی کنیم.
یک کلاس تعریف کرده و بسته به بخش های مورد نیاز برایش متد و مشخصه ایجاد میکنیم.
مثلا یک بخش برای اتصال یک بخش برای اجرای sqlکد یک بخش برای واکشی و ... .
<div dir="ltr">

```php
class Database {
    public $connection;//ایجاد مشخصه اتصال
    public function __construct(){//متد سازنده که منبع داده و اطلاعات مربوظ به آن را مشخص کرده ویک شی pdo ایجاد کرده و آن منبع داده را بهش میدهیم.
        $dsn = "mysql:host=localhost;port=3306;dbname=mydb1;charset=utf8mb4";
        $this->connection = new PDO($dsn , 'root','');//منبع داده - نام کاربری - پسوورد
    }
    public function query($query)//متد query برای اجرای کدهای sql
    {

        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

}
$pd = new Database();
$post = $pd->query("select * from tb2");
show_print($post);

```
<div dir="rtl">
بهتر هست در متد query مقدار برگشتی را تغییر داد یعنی فقط $statement را به خروجی فرستاد سپس در بیرون بعد از تعریف یک شی پایگاه داده عملیات مورد نظر را تغییر داد.
تغییرات کد را در زیر ببینید.
<div dir="ltr">

```php
class Database {
    public $connection;
    public function __construct() {
        $dsn = "mysql:host=localhost;dbname=mydb1;port=3306;charset=utf8mb4";
        $this->connection  = new PDO($dsn,"root","");
    }
    public function query($query) {
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }
}
$db = new Database();
$post = $db->query("SELECT * FROM tb2")->fetchAll(PDO::FETCH_ASSOC);;
show_print($post);

```
<div dir="rtl">
در نهایت کل کلاس database را کپی کرده و در یک فایل با نام database.php ریخته سپس این فایل را قبل از استفاده از کلاس require_once میکنیم.

# فایل database.php
<div dir="ltr">

```php
    <?php
    class Database {
        public $connection;
        public function __construct() {
            $dsn = "mysql:host=localhost;dbname=mydb1;port=3306;charset=utf8mb4";
            $this->connection  = new PDO($dsn,"root","");
        }
        public function query($query) {
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement;
    }
    }
```
<div dir="rtl">

# فایل index.php
```php
require_once "database.php";
$db = new Database();
$post = $db->query("SELECT * FROM tb2")->fetchAll(PDO::FETCH_ASSOC);;
show_print($post);


foreach ($post as $key => $value){
    echo $value['title']."<br>";
}   
```