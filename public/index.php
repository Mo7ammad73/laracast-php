<?php
    const BASE_PATH = __DIR__ . '/../';
    echo BASE_PATH;
    echo '<br>';
    require_once BASE_PATH."function.php";


    $routes = require_once base_path('routes.php');
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];
    echo $url;

    if(array_key_exists($url,$routes)){

        require $routes[$url];
    }else
    {
            http_response_code(404);
            echo "404 - Page not found";
            exit;
        }
