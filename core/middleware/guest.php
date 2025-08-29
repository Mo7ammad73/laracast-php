<?php

    namespace core\middleware;
    class Guest{

        public function handle(){
            if($_SESSION['user'] ?? false) {
                header('location: /laracast-php/public/');
                exit;
            }
        }

    }