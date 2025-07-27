<?php
$routes =[
    "/laracast-php/" => "controller/index.php",
    "/laracast-php/about" => "controller/about.php",
    "/laracast-php/contact" => "controller/contact.php",
    "/laracast-php/notes" => "controller/notes.php",
    "/laracast-php/notes/note" => "controller/note.php"
];
$url =parse_url($_SERVER['REQUEST_URI'])['path'];
echo $url;
if(array_key_exists($url,$routes)){

    require $routes[$url];
}else{
    echo "404";
    header("location: /laracast-php/");
}