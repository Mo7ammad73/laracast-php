<?php
    namespace core;
    use core\App;
    use core\Database;

    class authenticator
    {
        public function attempt($email, $password){

            $db = App::resolve(Database::class);
            $user = $db->query("select * from users where email = :email", [':email' => $email])->fetch();
            if($user){
                if(password_verify($password, $user['password'])) {
                    $this->login(["email" => $email]);
//                    header("location: /laracast-php/public");
                    return true;
                }
            }
            return false;
        }
        public function register($email, $password)
        {
            $db = App::resolve(Database::class);
            $user = $db->query("select * from users where email = :email", [':email' => $email])->get();
            if ($user) {
                return false;
            }
            $db->query("INSERT INTO users (email, password) values (:email, :password)", [':email' => $email, ':password' => password_hash($password, PASSWORD_BCRYPT)]);
            $this->login(["email" => $email]);
            return true;
        }

        public function login($user){
            $_SESSION['user'] = [
                'email'=>$user['email']
            ];
            session_regenerate_id(true);
        }
        public function logout(){
            $_SESSION = [];
            session_destroy();
            $params = session_get_cookie_params();
            setcookie('PHPSESSID', '', time() - 3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);

        }
        public function Islogin(){
            if($_SESSION['user'] ?? false){
                return true;
            }
            return false;
        }
    }