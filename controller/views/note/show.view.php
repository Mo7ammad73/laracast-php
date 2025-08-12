<?php
 view('partials/nav.php');
 view('partials/header.php',[
    'heading' => "Note",
     'note' =>$note
]);
 view('partials/footer.php');