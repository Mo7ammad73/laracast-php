<div class="body" dir="rtl">

در دستور زیر توسط شرط if داخل حلقه foreach بررسی میشود نام کتاب هایی که نویسنده اش ahmadi هست را نمایش میدهد.

<div dir="ltr">

```php

    <body>
    <?php
        $books = [
            [
                "name" => "english sentence",
                "author" => "rafiei",
                "purchaseurl" => "https://google.com"
            ],
            [
                "name" => "web design",
                "author" => "ahmadi",
                "purchaseurl" => "https://bing.com"
            ],
            [
                "name" => "reading",
                "author" => "ahmadi",
                "purchaseurl" => "https://gmail.com"
            ]
        ];
    ?>


    <ul>
    
        <?php foreach($books as $book) : ?>
    
            <li>
                <?php if($book['author'] == "ahmadi")  : ?>
                    <a href="<?= $book['purchaseurl']; ?>">
                        <?= $book['name']; ?>
                    </a>
                <?php endif ; ?>
            </li>
        <?php endforeach; ?>
    
    </ul>
</body>

```

<div dir="rtl">

حالا مثال قبل را با یک تابع مینویسیم یعنی عمل فیلتر کردن به وسیله ی نام نویسنده رو در یک تابع مینویسیم.

<div dir="ltr">

```php

    function FilterByAuthor($books){
                $FilteredBooks = [] ;
                foreach ($books as $book) {
    
                    if ($book['author'] == 'ahmadi') {
                        $FilteredBooks[] = $book ;
                    }
                }
                return $FilteredBooks;
            }

```
<div dir="rtl">

حالا کد شرطی مان را به صورت زیر اصلاح میکنیم :

<div dir="ltr">

```html

    <ul>
    
        <?php foreach( FilterByAuthor($books) as $book) : ?>
    
        <li>
            <a href="<?= $book['purchaseurl']; ?>">
                <?= $book['name']; ?>
            </a>
        </li>
        
        <?php endforeach; ?>
    
    </ul>
    
```
<div dir="rtl">

حالا میتوان به تابع یک آرگومان اضافه کرد تا از طریق آن مقدار مورد بررسی را به تابع اضافه کرد.

<div dir="ltr">

```php

    function FilterByAuthor($books , $author){
    $FilteredBooks = [] ;
    foreach ($books as $book) {
    
    if ($book['author'] == $author) {
    $FilteredBooks[] = $book ;
    }
    }
    return $FilteredBooks;
    }
    ?>

```

```html

    <ul>
    
        <?php foreach( FilterByAuthor($books ,'ahmadi') as $book) : ?>
    
        <li>
            <a href="<?= $book['purchaseurl']; ?>">
                <?= $book['name']; ?>
            </a>
        </li>
        <?php endforeach; ?>
    
    </ul>
    </body>

```