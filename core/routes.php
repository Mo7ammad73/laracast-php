<?php

        $router->add('GET','/laracast-php/public/', "index.php");
        $router->add('GET','/laracast-php/public/about', "about.php");
        $router->add('GET','/laracast-php/public/contact', "contact.php");
        $router->add('GET','/laracast-php/public/notes', "note/index.php")->only('auth');
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/create', "note/create.php");
        $router->add(['GET' , 'POST'],'/laracast-php/public/notes/note', "note/show.php");
        $router->delete('/laracast-php/public/notes/note' , "note/destroy.php");
        $router->post('/laracast-php/public/notes/store', "note/store.php");
        $router->add('GET','/laracast-php/public/notes/edit', "note/edit.php");
        $router->patch('/laracast-php/public/notes/update', "note/update.php");
        $router->get('/laracast-php/public/register' , "registeration/create.php")->only('guest');
        $router->post('/laracast-php/public/register' , "registeration/store.php");
        $router->get('/laracast-php/public/login' , "sessions/create.php")->only('guest');
        $router->post('/laracast-php/public/login' , "sessions/store.php")->only('guest');
        $router->delete('/laracast-php/public/logout' , "sessions/destroy.php")->only('auth');


//    return [
//    "/laracast-php/public/" => base_path("index.php"),
//    "/laracast-php/public/about" => base_path("about.php"),
//    "/laracast-php/public/contact" => base_path("contact.php"),
//    "/laracast-php/public/notes" => base_path("note/index.php"),
//    "/laracast-php/public/notes/create" => base_path("note/create.php"),
//    "/laracast-php/public/notes/note" => base_path("note/show.php")
//    ];