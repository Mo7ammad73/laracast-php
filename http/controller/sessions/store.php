<?php

use core\authenticator;
use http\Forms\LoginForm;

$email = $_POST['email'];
$password = $_POST['password'];


$form = new LoginForm();
if ($form->validate($email, $password)){
    $auth = new authenticator();
    if( $auth->attempt($email, $password) ) {
        Redirect("/laracast-php/public");
    }
    $form->adderror('email','No Matching Account Found for that email address and password');
}
return view("sessions/create.view.php" ,['error' => $form->getErrors()] );
