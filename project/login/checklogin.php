<?php
    session_start();
    require_once "database.php";
    $config = require_once "config.php";
    $db = new Database($config["database"]);
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $username = isset($_POST["username"]) ? $_POST["username"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
    }
    $statement = $db->query("select * from users where username= :u and  password= :p",["u"=>$username,"p"=>$password]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user){
        $_SESSION["user"] = $username;
        header("location:dashbord.php");
        exit;
    }else{
        $_SESSION["error"]= "نام کاربری یا رمز عبور اشتباه هست";
        header("location:login.php");
        exit;
    }