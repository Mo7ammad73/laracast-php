<?php
    $config = require_once base_path("controller/config.php");
//    require_once base_path("controller/Database.php");
//    require_once base_path("validator.php");
$error =[];
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(validator::Is_Empty($_POST['body'])){
            $error["body"] = "Body is required";
        }else if(!validator::Count_Char($_POST["body"],1,1000)){
            $error["body"] = "body is too long ";
        }
        if(empty($error)){
            $db = new Database($config['database']);
            $db->query("INSERT INTO notes (body,user_id) VALUES (:body ,:user_id)" , ['body' => $_POST['body'], 'user_id' => 3 ]);
            $_POST['body'] = null;
        }
    }

     view("note/create.view.php",['error'=>$error]);