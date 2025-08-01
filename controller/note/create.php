<?php
    $config = require_once __DIR__.'/../config.php';
    require_once __DIR__."/../Database.php";
    require_once __DIR__."/../../validator.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error =[];
        $validator = new Validator();
        if($validator->Is_Empty($_POST['body'])){
            $error["body"] = "Body is required";
        }
        if(validator::Count_Char($_POST["body"],1,1000)){
            $error["body"] = "body is too long ";
        }

        if(empty($error)){
            $db = new Database($config['database']);
            $db->query("INSERT INTO notes (body,user_id) VALUES (:body ,:user_id)" , ['body' => $_POST['body'], 'user_id' => 3 ]);
        }
    }

    require_once __DIR__."/../views/note/create.view.php";