<?php

    const BASE_PATH = __DIR__ . '/../';
    require_once BASE_PATH."function.php";
    spl_autoload_register(function ($class) {
        // مسیر فایل کلاس را بر اساس نام کلاس بساز
        $path = base_path("/core/"). $class . '.php';

        if (file_exists($path)) {
            require_once $path;
        }
    });

    $routes = require_once base_path('routes.php');
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];

    if(array_key_exists($url,$routes)){

        require $routes[$url];
    }else
    {
            http_response_code(404);
            echo "404 - Page not found";
            exit;
        }
