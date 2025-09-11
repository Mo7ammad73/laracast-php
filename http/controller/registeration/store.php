<?php


use core\authenticator;
use http\Forms\LoginForm;
use core\session;
use core\Database;
use  core\App;
$email = $_POST['email'];
$password = $_POST['password'];


$form = new LoginForm();
if ( $form->validate($email, $password)){
    if ((new authenticator())->register($email, $password)){
        Redirect("/laracast-php/public");
    }
    $form->adderror('email','exist Account  for that email address and password');
}
session::flash('error',$form->getErrors());
session::flash('old',['email'=>$email]);
return Redirect("/laracast-php/public/register");
