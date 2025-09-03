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
    view("sessions/create.view.php", ['error' => $error]);
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



