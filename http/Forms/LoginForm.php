<?php

namespace http\Forms;

use core\ValidationException;
use core\Validator;


class LoginForm
{
   protected $attributes;
   protected $error = [];
   public function __construct($attributes)
   {
       $this->attributes = $attributes;
       if( Validator::Is_Empty($this->attributes['email']) || Validator::Is_Empty($this->attributes['password'])  ){
           $this->error['email'] = "email or password is required";
       }
       if( ! Validator::Validate_email($this->attributes['email']) ){
           $this->error['email'] = "Invalid email";
       }

       $result = Validator::Validate_password($this->attributes['password']);
       if (! $result['valid']) {
           $this->error['password'] = $result['message'];
       }
//       return empty($this->error);
   }
    public static function  validate($attributes){
        $instance = new static($attributes);
        return $instance->failed() ? $instance->throw() : $instance;
    }
    public function throw()
    {
        throw new ValidationException($this->error, $this->attributes);
    }

    public function failed(){
       return count($this->error);
    }
    public function getErrors(){
        return $this->error;
    }
    public function adderror($field ,  $message){
        $this->error[$field] = $message;
        return $this;
    }
    public function haserror($field){
        return isset($this->error[$field]);
    }
}