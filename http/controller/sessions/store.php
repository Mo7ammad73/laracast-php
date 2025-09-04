<?php

use core\Validator;
use core\Database;
use core\App;

$email = $_POST['email'];
$password = $_POST['password'];

$form = new \http\Forms\LoginForm();
if (! $form->validate($email, $password)){
    view("sessions/create.view.php", ['error' => $form->getErrors()]);
    return;
}
//register
$db = App::resolve(Database::class);
$user = $db->query("select * from users where email = :email", [':email' => $email])->fetch();
if ($user){
    if(password_verify($password, $user['password'])){
        login($user);
        header("location: /laracast-php/public/");
        exit();
    }
    return view("sessions/create.view.php", ['error'=>['password' => "password is wrong"]] );
}
return view("sessions/create.view.php", ['error'=>["email" => "email not found"]] );



