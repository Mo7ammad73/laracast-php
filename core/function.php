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
            header("Location:/index.php");
            exit();
        }
    }

    function login($user){
        $_SESSION['user'] = [
            'email'=>$user['email']
        ];
        session_regenerate_id(true);
    }
    function logout(){
        $_SESSION = [];
        session_destroy();
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);

    }