
    <?php  view("partials/nav.php"); ?>
    <?php  view("partials/header.php",['heading' => 'Notes']); ?>
        <ul class="list-disc text-blue-500 pl-5">
            <?php
            foreach($notes as $note){
                echo "<li> <a href='/laracast-php/public/notes/note?id={$note['id']}' class='text-blue-500 hover:underline' > " . htmlspecialchars($note['body']) . "</a></li>";
            }
            ?>
        </ul>
    <div class="mt-6 pl-5">
        <a href="/laracast-php/public/notes/create" class="text-blue-500 hover:underline"> Create Note </a>
    </div>

    <?php  view("partials/footer.php"); ?>