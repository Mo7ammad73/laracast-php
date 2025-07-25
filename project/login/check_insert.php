<?php
    session_start();
    require_once "database.php";
    $config = require_once "config.php";
    $db = new Database($config['database']);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $statement = $db->query("SELECT * FROM users WHERE username = :u", [':u' => $username])->fetch(pdo::FETCH_ASSOC);
        if($statement) {
            $_SESSION['error'] = "این نام کاربری قبلا ثبت نام کرده";
            header("location:create.php");
            exit;
        }else{
            $db->query("INSERT INTO users (username, password) VALUES (:u, :p)", [':u' => $username, ':p' => $password]);
            $_SESSION['user'] = $username;
            header("location:dashbord.php");
            exit;
        }
    }

