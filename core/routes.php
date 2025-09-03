<?php

        $router->add('GET','/laracast-php/public/', "controller/index.php");
        $router->add('GET','/laracast-php/public/about', "controller/about.php");
        $router->add('GET','/laracast-php/public/contact', "controller/contact.php");
        $router->add('GET','/laracast-php/public/notes', "controller/note/index.php")->only('auth');
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/create', "controller/note/create.php");
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/note', "controller/note/show.php");
        $router->delete('/laracast-php/public/notes/note' , "controller/note/destroy.php");
        $router->post('/laracast-php/public/notes/store', "controller/note/store.php");
        $router->add('GET','/laracast-php/public/notes/edit', "controller/note/edit.php");
        $router->patch('/laracast-php/public/notes/update', "controller/note/update.php");
        $router->get('/laracast-php/public/register' , "controller/registeration/create.php")->only('guest');
        $router->post('/laracast-php/public/register' , "controller/registeration/store.php");
        $router->get('/laracast-php/public/login' , "controller/sessions/create.php")->only('guest');
        $router->post('/laracast-php/public/login' , "controller/sessions/store.php")->only('guest');
        $router->delete('/laracast-php/public/logout' , "controller/sessions/destroy.php")->only('auth');


//    return [
//    "/laracast-php/public/" => base_path("controller/index.php"),
//    "/laracast-php/public/about" => base_path("controller/about.php"),
//    "/laracast-php/public/contact" => base_path("controller/contact.php"),
//    "/laracast-php/public/notes" => base_path("controller/note/index.php"),
//    "/laracast-php/public/notes/create" => base_path("controller/note/create.php"),
//    "/laracast-php/public/notes/note" => base_path("controller/note/show.php")
//    ];