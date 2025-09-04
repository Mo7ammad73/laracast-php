<?php
   use core\Database;


   $db = \core\App::resolve(Database::class);

   $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->findOrFail();
   Authorize($note['user_id'] === 3);

    $db->query("DELETE FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->fetch();
    header("location:/laracast-php/public/notes");
    exit();
