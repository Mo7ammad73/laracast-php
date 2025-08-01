<?php
    class Validator {
        public function Is_Empty($value){
            return strlen(trim($value)) == 0;
        }
        public static function Count_Char($value , $min=1 , $max=INF){
            return strlen(trim($value)) >= $min && strlen(trim($value)) <= $max;
        }
        public static function Validate_email($value){
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }
    }