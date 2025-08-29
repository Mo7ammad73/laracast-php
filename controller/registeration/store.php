<?php

use core\Validator;
use core\Database;
use core\App;

    $email = $_POST['email'];
    $password = $_POST['password'];

    $error = [];

    if( ! Validator::Validate_email($email) ){
        $error['email'] = "Invalid email";
    }

    $result = Validator::Validate_password($password);
    if (! $result['valid']) {
        $error['password'] = $result['message'];
    }

    if($error) {
        view("registeration/create.view.php", ['error' => $error]);
        return;
    }
   //register
    $db = App::resolve(Database::class);
    $user = $db->query("select * from users where email = :email", [':email' => $email])->get();
    if ($user){
        header("Location:/laracast-php/public/");
    }else{
        $db->query("INSERT INTO users (email, password) values (:email, :password)", [':email' => $email, ':password' => $password]);
        $_SESSION['user'] =[
            'email' => $email
        ];
        header("Location:/laracast-php/public/");
        exit();
    }



