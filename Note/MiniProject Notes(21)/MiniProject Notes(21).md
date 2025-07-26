<div dir="rtl">
در این بخش قرار هست یک مینی پروژه را شروع کنیم.در ابتدا دو جدول notes و users را ایجاد میکنیم.
برای انجام این کار هم میتوان از table_plus استفاده کرد و هم به صورت کد SQL

<div dir="ltr">

```sql
    
    CREATE TABLE notes (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        body TEXT
    )

    CREATE TABLE users (
                           id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                           name NVARCHAR(255),
                           email VARCHAR(255)
    )
    
```
<div dir="rtl">
بعد از ایجاد جدول ها یکبار آن ها را بسته سپس جدول users را باز کرده و بر روی آن یک index تعریف میکنیم تا از ایمیل های تکراری جلوگیری شود.
برای انجام اینکار در table plus وارد جدول users شده به بخش structure رفته و در انتهای این صفحه index را تعریف میکنیم. برای اینکه به صورت کد sql اینکار را انجام دهیم کد زیر را مینویسیم :

<div dir="ltr">

```sql
    CREATE UNIQUE INDEX email_index ON users (email);
```
<div dir="rtl">
حالا باید یک کلید خارجی تعریف کنیم تا بین دو جدول ارتباط برقرای شود به طوریکه تغییر در یکی بر دیگری هم تاثیر بگذارد.
برای انجام اینکار در جدول notes یک فیلد user_id تعریف کرده و سپس در بخش structure آن را به عنوان کلید خارجی تعریف میکنیم.
فقط نوع فیلد user_id  جدول notes و فیلد id جدول user باید دقیقا مثل هم باشه.
<div dir="ltr">

```sql

ALTER TABLE notes ADD COLUMN user_id INT UNSIGNED;

ALTER TABLE notes
    ADD CONSTRAINT fk_user_note
    FOREIGN KEY (user_id)
    REFERENCES users(id);
    ON DELETE CASCADE;
```
<div dir="rtl">
حالا با واردکردن اطلاعات در جداول و حذف آنها باید تغییرات را متوجه شویم مثلا وقتی یک کاربر حذف شود باید تمام یادداشت هایش حذف شود.