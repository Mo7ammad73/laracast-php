<?php
$name = $_SESSION['name'] ?? 'Guest';
var_dump($name);
 view("about.view.php",
    [
        'heading' => "about"
    ]);