<?php
    $routes = require_once 'routes.php';
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];
    echo $url;
    if(array_key_exists($url,$routes)){

        require $routes[$url];
    }else{
        echo "404";
        header("location: /laracast-php/");
    }