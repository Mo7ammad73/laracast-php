<div class="body" dir="rtl">
تعریف آرایه و استفاده از آن با حلقه  foreach
<div dir="ltr">

```php
    <body>
    <?php
        $books=[
            "english",
            "programming",
            "web"
        ];
    ?>
    <ul>
        <?php
            foreach($books as $book){
                echo "<li>" . $book . "</li>";
                echo "<li> $book </li>";//با دستور بالا یکسان هست
            }
        ?>
    </ul>
</body>
```
<div dir="rtl">
استفاده از حلقه foreach به شکل دیگر

<div dir="ltr">

```php
    <?php
        $books=[
            "english",
            "programming",
            "web"
        ];
    ?>
    <ul>
        <?php foreach($books as $book) :?>
             <li><?php echo $book; ?></li>
        <?php endforeach ; ?>
    </ul>
</body>
```
<div dir="rtl">

برای وصل شدن php storm به github
در صفحه کاربری گیت هاب بر روی آیکون پروفایل کلیک کرده و settings را میزنیم در قسمت developer settings گزینه  personal access tokens token(classic)
بعد گزینه generate new token و بعد  در قسمت expiration گزینه no expiration  انتخاب کرده .

قسمت repo  تیک تمام گزینه ها را میزنیم و در قسمت admin org تیک read:org و در نهایت تیک gist رو زده و generate token را میزنیم.

حالا به برنامه php storm  رفته  ctrl+alt+s رو زده یا منوی فایل گزینه ی settings بعد  version control و بعد git hub را زده و بعد بر روی علامت + کلیک کرده log in via token را زده و کد token  گرفته شده را کپی میکنیم.