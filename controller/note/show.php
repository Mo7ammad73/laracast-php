<?php
$config = require_once base_path("controller/config.php");
//require_once base_path("controller/Database.php");
//require_once base_path("controller/Response.php");
function Authorize($condition, $status = 403)
{
    if (!$condition) {
        http_response_code($status);
        header("Location:/index.php");
        exit();
    }
}
$db = new Database($config['database'], "root", "");
$note = $db->query("SELECT * FROM notes where user_id = :user and id=:id",["user"=>3,"id"=>$_GET['id']])->findOrFail();
$current_userid = 3;
Authorize($note['user_id'] === $current_userid);
view("note/show.view.php", ["note"=>$note]);
//if(!$note){
//
//    http_response_code(Response::NOT_FOUND);
//    require_once "404.php";
//    exit();
//
//}
//if($note["user_id"] != 3){
//    http_response_code(Response::FORBIDDEN);
//    require_once "403.php";
//}
//var_dump($note);
//require_once "views/show.view.php";
//
//
//require "Database.php";
//require "Response.php";
//
//$db = new Database();
//
//$current_userid = 3; // فرضی؛ بعداً از جلسه login واقعی میاد
//
//// Resourceful Naming Conventions(29). گرفتن یادداشت بر اساس فقط id
//$note = $db->query("SELECT * FROM notes WHERE id = :id", [
//    'id' => $_GET['id']
//])->fetch();
//
//// 2. اگر یادداشت وجود نداشت → 404
//if (!$note) {
//    http_response_code(Response::NOT_FOUND);
//    require "views/errors/404.php";
//    exit();
//}
//
//// 3. اگر یادداشت برای کاربر فعلی نبود → 403
//if ($note['user_id'] != $current_userid) {
//    http_response_code(Response::FORBIDDEN);
//    require "views/errors/403.php";
//    exit();
//}
//
//// 4. نمایش یادداشت
//require "controller/views/show.view.php";
//
