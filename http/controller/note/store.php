<?php


    use core\Validator;
    use core\Database;
    $error =[];
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(validator::Is_Empty($_POST['body'])){
            $error["body"] = "Body is required";
        }else if(!validator::Count_Char($_POST["body"],1,1000)){
            $error["body"] = "body is too long ";
        }
        if(empty($error)){
            $db = \core\App::resolve(Database::class);
            $db->query("INSERT INTO notes (body,user_id) VALUES (:body ,:user_id)" , ['body' => $_POST['body'], 'user_id' => 3 ]);
            $_POST['body'] = null;
            header('Location: /laracast-php/public/notes');
            exit();
        }else
        {
            view("note/create.view.php",['error'=>$error]);
        }
    }
