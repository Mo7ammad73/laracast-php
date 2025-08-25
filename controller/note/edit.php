<?php
    use core\Database;

    $db = \core\App::resolve(Database::class);
    $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->fetch();

    $current_userid = 3;

    Authorize($note['user_id'] === $current_userid);

    view("note/edit.view.php", ["note"=>$note]);
