<?php
$config = require_once 'config.php';
require_once "Database.php";
$note = new Database($config['database'], "root", "");
$note = $note->query("SELECT * FROM notes where id=:id",["id"=>$_GET['id']])->fetch();
var_dump($note);
require_once "views/note.view.php";