<?php

namespace http\Forms;

use core\Validator;

class LoginForm
{
   protected $errors = [];
    public function validate($email, $password){
        if( ! Validator::Validate_email($email) ){
            $this->$errors['email'] = "Invalid email";
        }

        $result = Validator::Validate_password($password);
        if (! $result['valid']) {
            $this->$errors['password'] = $result['message'];
        }
        return empty($this->$errors);
    }

    public function getErrors(){
        return $this->errors;
    }
}