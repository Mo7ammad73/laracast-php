<?php
   use core\Database;
//    $config = require_once base_path("controller/config.php");
//    $db = new Database($config['database'], "root", "");

    $db = \core\App::resolve(Database::class);
//    var_dump($db);
    $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->findOrFail();
    Authorize($note['user_id'] === 3);

    $db->query("DELETE FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->fetch();
    header("location:/laracast-php/public/notes");
    exit();
