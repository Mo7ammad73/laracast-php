<div class="body" dir="rtl">
بعد از نمایش خروجی کدهای نوشته شده در episode4 در مرورگر راست کلیک کرده بعد گزینه ی inspect  رو زده و سپس تگ body را انتخاب کرده و کدهای css زیر را مینویسیم تا موقت خروجی را چک کنیم.
<div dir="ltr">

```css
    display : grid ;
    place-items : center ;
    height : 100vh ;
    margin : 0 ;
    font-family : sans-serif ;
     
```
<div dir="rtl">

حالا برای ثبت تغییرات به صورت دایم به php storm رفته و بین تگ  head  کد زیر را مینویسیم .
<div dir="ltr">

```html
    <style>
        body{
                display : grid ;
                place-items : center ;
                height : 100vh ;
                margin : 0 ;
                font-family : sans-serif ;
            }
    </style>
```
<div dir="rtl">

مثال دستور if  در episode5
<div dir="ltr">

```php
    <body>
        <?php
            $name = "dark matter" ;
            $read = true ;
            if ($read) {
                $message = "you have read $name";
            }
            else {
                $message = "you have not read $name";
            }
        ?>
        <h1>
            <?php echo $message ; ?>
        </h1>
    </body>
```
```php
<?php
    $score = 75 ;
    if ($score >= 90) {
        echo "A";
    }else if ($score >= 80){
        echo "B";
    }else if ($score >=70) {
        echo "C";
    }else {
        echo "f";
    }
```
</div>