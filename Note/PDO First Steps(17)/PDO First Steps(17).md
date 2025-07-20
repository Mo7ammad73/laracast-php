# جلسه 17 — کلاس‌ها و اتصال به پایگاه داده با PDO در PHP

## بخش اول: کار با کلاس‌ها (OOP در PHP)

### تعریف کلاس و مشخصه (Property) و رفتار (Method)

```php
class Person {
    public $name; // مشخصه نام
    public $age;  // مشخصه سن

    public function bb() { // رفتار
        echo $this->name . " " . $this->age;
    }
}
```

### ایجاد شیء و مقداردهی مشخصه‌ها

```php
$p = new Person();
$p->name = "Mohammad";
$p->age = 30;
show_print($p);
$p->bb();
```

### متد سازنده (__construct)

```php
class MyClass {
    public function __construct() {
        echo "شیء ساخته شد!";
    }
}

$obj = new MyClass(); // خروجی: شیء ساخته شد!
```

### متد سازنده با پارامتر

```php
class User {
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }
}

$user1 = new User("علی");
echo $user1->name; // خروجی: علی
```

### ارث‌بری (Inheritance)

```php
class ParentClass {
    public $name = "کلاس پدر";

    public function sayHello() {
        echo "سلام از {$this->name}!";
    }
}

class ChildClass extends ParentClass {}

$obj = new ChildClass();
$obj->sayHello(); // خروجی: سلام از کلاس پدر!
```

### بازنویسی متد (Overriding)

```php
class ParentClass {
    public function greet() {
        echo "سلام از کلاس پدر!";
    }
}

class ChildClass extends ParentClass {
    public function greet() {
        echo "سلام از کلاس فرزند!";
    }
}

$obj = new ChildClass();
$obj->greet(); // خروجی: سلام از کلاس فرزند!
```

### استفاده از parent:: برای فراخوانی متد پدر

```php
class ParentClass {
    public function greet() {
        echo "سلام از کلاس پدر! ";
    }
}

class ChildClass extends ParentClass {
    public function greet() {
        parent::greet();
        echo "سلام از کلاس فرزند!";
    }
}

$obj = new ChildClass();
$obj->greet(); // خروجی: سلام از کلاس پدر! سلام از کلاس فرزند!
```

---

## بخش دوم: اتصال به پایگاه داده با PDO

### تعریف اتصال با DSN و ایجاد شی PDO

```php
$dsn = 'mysql:host=localhost;port=3306;dbname=mydb1;charset=utf8mb4';
$pdo = new PDO($dsn, 'root', '');
```

### اجرای کوئری با prepare و execute

```php
$statement = $pdo->prepare("select id, title from tb2");
$statement->execute();
```

### دریافت داده‌ها با fetchAll

```php
$post = $statement->fetchAll(PDO::FETCH_ASSOC);
```

### نمایش داده‌ها

```php
foreach ($post as $row) {
    echo "<li>" . $row['title'] . "</li>\n";
}
```

### استفاده از تابع show_print برای نمایش ساختار آرایه

```php
show_print($post);

// تعریف احتمالی تابع:
function show_print($value) {
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}
```

---

## نکات مهم

- استفاده از `PDO` برای امنیت و سازگاری بهتر با پایگاه داده.
- استفاده از `prepare` و `execute` برای جلوگیری از SQL Injection.
- استفاده از `fetchAll(PDO::FETCH_ASSOC)` برای دریافت داده‌ها به شکل آرایهٔ انجمنی.
- `parent::methodName()` برای استفاده از متد پدر هنگام override کردن.
