در این بخش اولین کد php رو در محیط سرور داخلی php اجرا میکنیم. برای انجام این کار یک فایل با نام index.html  ایجاد کرده درون آن html:5 را نوشته و کلید enter را میزنیم تا کد html کامل نوشته شود حال داخل آن کد زیر را مینویسیم :

<div dir="ltr">

```html 
     <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Document</title>
    </head>
    <body>
    <h2><?php echo "hello world" ;?></h2>
    <?php echo "<br><h2>hello world</h2>" ; ?>
    </body>
    </html>
            
```

<div dir="rtl">
درکد بالا یک بار کد php را داخل تگ html  و یک بار هم تگ html را داخل کد php نوشتم.
هر کد php با سمی کولن; تمام میشود و بین دو تگ php?> و <? قرار میگیرد.

<div dir="ltr">
php -S localhost:8000
<div dir="rtl">
دستور بالا سرور داخلی خود php را ایجاد میکند که یک لینک میدهد که با کلیک بر روی  آن صفحه اجرا میشود.
این لینک محتویات فایل index.php پوشه جاری را اجرا میکند.
