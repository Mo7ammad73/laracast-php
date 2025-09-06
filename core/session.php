<?php

namespace core;

class session
{
    public static function has($key){
        $x = static::get($key);
        return isset($x);
    }
    public static function put($key, $value){
        $_SESSION[$key] = $value;
    }
    public static function get($key , $default = null){
        return $_SESSION['_flashed'][$key] ?? $_SESSION[$key] ?? $default;
    }
    public static function flash($key , $value){
        $_SESSION['_flashed'][$key] = $value;
    }
    public static function unflash(){
        unset($_SESSION['_flashed']);
    }

}