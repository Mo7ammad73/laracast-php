<?php
    function base_path($path){
        return BASE_PATH.$path;
    }
    function view($path , $attributes = []){
        extract($attributes);
        require base_path("controller/views/".$path);
    }
    function Authorize($condition, $status = 403)
    {
        if (!$condition) {
            http_response_code($status);
            header("Location:/index.php");
            exit();
        }
    }