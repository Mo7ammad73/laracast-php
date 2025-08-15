<?php
    use core\Database;
    $config = require_once base_path("controller/config.php");
    //require_once base_path("controller/Database.php");
    //require_once base_path("controller/Response.php");
    function Authorize($condition, $status = 403)
    {
        if (!$condition) {
            http_response_code($status);
            header("Location:/index.php");
            exit();
        }
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $db = new Database($config['database'], "root", "");
        $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->findOrFail();
        Authorize($note['user_id'] === 3);
        $db->query("DELETE FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->fetch();
        header("location:/laracast-php/public/notes");
        exit();
    }else
    {
        $db = new Database($config['database'], "root", "");
        $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->findOrFail();
        $current_userid = 3;
        Authorize($note['user_id'] === $current_userid);
        view("note/show.view.php", ["note"=>$note]);

    }
