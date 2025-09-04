<?php
    use core\Database;
    use core\Validator;
    $db = \core\App::resolve(Database::class);
    $note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_POST['id']])->fetch();

    $current_userid = 3;

    Authorize($note['user_id'] === $current_userid);

    $error =[];
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(validator::Is_Empty($_POST['body'])){
            $error["body"] = "Body is required";
        }else if(!validator::Count_Char($_POST["body"],1,1000)){
            $error["body"] = "body is too long ";
        }
        if(empty($error)){
            $db = \core\App::resolve(Database::class);
            $db->query("UPDATE  notes SET body=:body where id=:id" , ['body' => $_POST['body'], 'id' => $_POST['id'] ]);
            $_POST['body'] = null;
            header('Location: /laracast-php/public/notes');
            exit();
        }else
        {
            view("note/edit.view.php",['error'=>$error , 'note'=>$note]);
        }
    }

