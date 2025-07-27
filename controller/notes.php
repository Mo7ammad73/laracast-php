<?php
$config = require_once 'config.php';
require_once "Database.php";
$notes = new Database($config['database'], "root", "");
$notes = $notes->query("SELECT * FROM notes where user_id=:id",["id"=>3])->fetchAll(PDO::FETCH_ASSOC);
require_once "views/notes.view.php";