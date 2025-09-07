<?php

use core\authenticator;
use http\Forms\LoginForm;
$email = $_POST['email'];
$password = $_POST['password'];


$form = new LoginForm();
if ( $form->validate($email, $password)){
    $auth = new authenticator();
    if( $auth->attempt($email, $password) ) {
        Redirect("/laracast-php/public");
    }
    $form->adderror('email','No Matching Account Found for that email address and password');
}
//$_SESSION ['_flashed']['error'] = $form->getErrors();

\core\session::flash('error',$form->getErrors());
\core\session::flash('old',['email'=>$email]);
return Redirect("/laracast-php/public/login");
