<?php
    use core\Database;
    $config = require base_path("controller/config.php");
    $db = new Database($config['database'], "root", "");
    $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->findOrFail();
    $current_userid = 3;
    Authorize($note['user_id'] === $current_userid);
    view("note/show.view.php", ["note"=>$note]);


