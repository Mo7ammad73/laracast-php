<?php
    const BASE_PATH = __DIR__ . '/../';
    require_once BASE_PATH . "core/function.php";
    spl_autoload_register(function ($class) {
        $class = str_replace("\\", "/", $class);
        // مسیر فایل کلاس را بر اساس نام کلاس بساز
        $path = base_path("{$class}.php");

        if (file_exists($path)) {
            require_once $path;
        }
    });
    require_once base_path("Bootstrap.php");

    $router = new \core\Router();
    require_once base_path('core/routes.php');
    $url =parse_url($_SERVER['REQUEST_URI'])['path'];



    $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'] ;
    $router->route($url, $method);





//    if(array_key_exists($url,$routes)){
//
//        require $routes[$url];
//    }else
//    {
//            http_response_code(404);
//            echo "404 - Page not found";
//            exit;
//        }
