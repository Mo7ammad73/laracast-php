<?php

namespace http\Forms;

use core\Validator;

class LoginForm
{
   protected $error = [];
    public function validate($email, $password){
        if( Validator::Is_Empty($email) || Validator::Is_Empty($password)  ){
            $this->error['email'] = "email or password is required";
        }
        if( ! Validator::Validate_email($email) ){
            $this->error['email'] = "Invalid email";
        }

        $result = Validator::Validate_password($password);
        if (! $result['valid']) {
            $this->error['password'] = $result['message'];
        }
        return empty($this->error);
    }

    public function getErrors(){
        return $this->error;
    }
    public function adderror($field ,  $message){
        $this->error[$field] = $message;
    }
    public function haserror($field){
        return isset($this->error[$field]);
    }
}