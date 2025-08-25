<?php

    use core\App;
    use core\Container;
    use core\Database;

    $container = new Container();
    App::setcontainer($container);
    App::bind('core\Database' , function (){
        $config = require base_path('controller/config.php');
        return new Database($config['database']);
    });

//    $container = new Container();
//
//    $container->bind('core\Database' , function (){
//        $config = require base_path('controller/config.php');
//        return new Database($config['database']);
//    });
//
//    $db = $container->resolve('core\Database');
//    App::setcontainer($container);