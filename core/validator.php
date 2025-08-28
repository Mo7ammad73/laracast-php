<?php
namespace core;
    class Validator {
        public static function Is_Empty($value){
            return strlen(trim($value)) == 0;
        }
        public static function Count_Char($value , $min=1 , $max=INF){
            return strlen(trim($value)) >= $min && strlen(trim($value)) <= $max;
        }
        public static function Validate_email($value){
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }



        public static function Validate_password($value) {
            // بررسی خالی نبودن
            if (empty($value)) {
                return [
                    'valid' => false,
                    'message' => 'رمز عبور نمی‌تواند خالی باشد'
                ];
            }

            // حداقل 8 کاراکتر
            if (strlen($value) < 8) {
                return [
                    'valid' => false,
                    'message' => 'رمز عبور باید حداقل 8 کاراکتر باشد'
                ];
            }

            // حداکثر 50 کاراکتر (اختیاری)
            if (strlen($value) > 50) {
                return [
                    'valid' => false,
                    'message' => 'رمز عبور نمی‌تواند بیش از 50 کاراکتر باشد'
                ];
            }

            // شامل حروف کوچک
            if (!preg_match('/[a-z]/', $value)) {
                return [
                    'valid' => false,
                    'message' => 'رمز عبور باید شامل حداقل یک حرف کوچک انگلیسی باشد'
                ];
            }

            // شامل حروف بزرگ
            if (!preg_match('/[A-Z]/', $value)) {
                return [
                    'valid' => false,
                    'message' => 'رمز عبور باید شامل حداقل یک حرف بزرگ انگلیسی باشد'
                ];
            }

            // شامل عدد
            if (!preg_match('/[0-9]/', $value)) {
                return [
                    'valid' => false,
                    'message' => 'رمز عبور باید شامل حداقل یک عدد باشد'
                ];
            }

            // شامل کاراکتر خاص
            if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $value)) {
                return [
                    'valid' => false,
                    'message' => 'رمز عبور باید شامل حداقل یک کاراکتر خاص باشد (!@#$%^&* و غیره)'
                ];
            }

            return [
                'valid' => true,
                'message' => 'رمز عبور معتبر است'
            ];
        }
    }