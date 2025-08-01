<?php
$config = require_once __DIR__.'/../config.php';
require_once __DIR__."/../Database.php";
$notes = new Database($config['database'], "root", "");
$notes = $notes->query("SELECT * FROM notes where user_id=:id",["id"=>3])->get();
require_once __DIR__."/../views/note/index.view.php";