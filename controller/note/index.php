<?php
use core\Database;

$db = \core\App::resolve(Database::class);
$notes = $db->query("SELECT * FROM notes where user_id=:id",["id"=>3])->get();
 view("note/index.view.php", ["notes"=>$notes]);