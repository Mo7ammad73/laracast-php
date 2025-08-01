<?php
    $config = require_once 'config.php';
    require_once "Database.php";
    require_once "Response.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error =[];
        if(strlen($_POST["body"]) == 0){
            $error["body"] = "Body is required";
        }
        if(strlen($_POST["body"]) > 1000){
            $error["body"] = "body is too long ";
        }
        if(empty($error)){
            $db = new Database($config['database']);
            $db->query("INSERT INTO notes (body,user_id) VALUES (:body ,:user_id)" , ['body' => $_POST['body'], 'user_id' => 3 ]);
        }
    }

    require_once "views/notes_create.view.php";