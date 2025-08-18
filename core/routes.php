<?php

        $router->add('GET','/laracast-php/public/', "controller/index.php");
        $router->add('GET','/laracast-php/public/about', "controller/about.php");
        $router->add('GET','/laracast-php/public/contact', "controller/contact.php");
        $router->add('GET','/laracast-php/public/notes', "controller/note/index.php");
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/create', "controller/note/create.php");
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/note', "controller/note/show.php");
        $router->delete('/laracast-php/public/notes/note' , "controller/note/destroy.php");
        $router->post('/laracast-php/public/notes/store', "controller/note/store.php");

//    return [
//    "/laracast-php/public/" => base_path("controller/index.php"),
//    "/laracast-php/public/about" => base_path("controller/about.php"),
//    "/laracast-php/public/contact" => base_path("controller/contact.php"),
//    "/laracast-php/public/notes" => base_path("controller/note/index.php"),
//    "/laracast-php/public/notes/create" => base_path("controller/note/create.php"),
//    "/laracast-php/public/notes/note" => base_path("controller/note/show.php")
//    ];