<?php

    namespace core;

    class ValidationException extends \Exception
    {
        public readonly array $error ;
        public readonly array $attributes ;

        public function __construct($error, $attributes){
            $this->error =$error;
            $this->attributes = $attributes;
            parent::__construct("Validation Error");
        }
        public static function throw($error, $attributes) {
            $instance = new static;        // یک شیء جدید بساز
            $instance->error = $error;   // خطاها رو داخلش ذخیره کن
            $instance->attributes = $attributes; // داده‌های قدیمی فرم رو هم ذخیره کن
            throw $instance;               // پرتاب کن
        }

        public function getErrors() {
            return $this->error;
        }
    }
//class ValidationException extends \Exception
//    {
//        public readonly array $errorr;
//        public function __construct($error){
//            $this->errorr =$error;
//            parent::__construct("Validation Error");
//        }
//        public function getError(){
//            return $this->errorr;
//        }
//    }
