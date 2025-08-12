
<?php  view("partials/nav.php"); ?>
<?php  view("partials/header.php",[
    'heading' => 'Notes',
    'notes' => $notes
]); ?>

<?php  view("partials/footer.php"); ?>