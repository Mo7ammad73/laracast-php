<?php
    function base_path($path){
        return BASE_PATH.$path;
    }
    function view($path , $attributes = []){
        extract($attributes);
        require base_path("http/controller/views/".$path);
    }
    function Authorize($condition, $status = 403)
    {
        if (!$condition) {
            http_response_code($status);
            header("Location:/laracast-php/public/");
            exit();
        }
    }

    function Redirect($path){
        header("Location:".$path);
        exit();
    }


    function old($key , $default =''){
        return core\session::get('old')[$key] ?? $default;
    }