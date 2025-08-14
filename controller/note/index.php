<?php
use core\Database;
$config = require_once base_path("controller/config.php");
//require_once base_path("controller/Database.php");
$notes = new Database($config['database'], "root", "");
$notes = $notes->query("SELECT * FROM notes where user_id=:id",["id"=>3])->get();
 view("note/index.view.php", ["notes"=>$notes]);