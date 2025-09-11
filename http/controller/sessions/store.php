<?php

use core\authenticator;
use http\Forms\LoginForm;
$form = LoginForm::validate($attributes=[
    'email' => $_POST['email'],
    'password' => $_POST['password']
]);
if( (new authenticator())->attempt($attributes['email'] , $attributes['password']) ) {
    Redirect("/laracast-php/public");
}
$form->adderror("email","کاربری با این ایمیل و رمزعبور وجود ندارد")->throw();