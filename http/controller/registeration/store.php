<?php

use core\Validator;
use core\Database;
use core\App;
use http\Forms\LoginForm;
    $email = $_POST['email'];
    $password = $_POST['password'];


$form = new LoginForm();
if(! $form->validate($email, $password)){
    view("registeration/create.view.php", ['error' => $form->getErrors()]);
    return;
}

   //register
    $db = App::resolve(Database::class);
    $user = $db->query("select * from users where email = :email", [':email' => $email])->get();
    if ($user){
        header("Location:/laracast-php/public/register");
        exit();
    }else{
        $db->query("INSERT INTO users (email, password) values (:email, :password)", [':email' => $email, ':password' =>password_hash($password,PASSWORD_BCRYPT)]);
        $_SESSION['user'] =[
            'email' => $email
        ];
        header("Location:/laracast-php/public/");
        exit();
    }



