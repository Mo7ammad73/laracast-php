<div class="body" dir="rtl">

## آرایه های انجمنی (Associative Array)


```php
    name =
     [
        "key" => "value",
        "key n"=> "value n"
    ];
```
<div dir="rtl">

مثال Episode 7

<div dir="ltr">

```php

<?php
    $books = 
    [
        [
            "name" => "english sentence",
            "author" => "rafiei",
            "purchaseurl" => "https://google.com"
        ],
        [
            "name" => "web design",
            "author" => "ahmadi",
            "purchaseurl" => "https://bing.com"
        ]
    ];
?>


<ul>

    <?php foreach($books as $book) : ?>
        <li>
            <a href="<?= $book['purchaseurl']; ?>">
                <?= $book['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>

</ul>
```