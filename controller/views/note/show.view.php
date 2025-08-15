
    <?php view('partials/nav.php'); ?>
     <?php view('partials/header.php',['heading' => "Note"]); ?>

    <div class="mt-6">
        <ul class="list-disc pl-5">
            <?php
                echo "<li> id: " .$note['id']."</li>";
                echo "<li>user_id: " .htmlspecialchars($note['user_id'])."</li>";
                echo  "<li>body :" .htmlspecialchars($note['body']). "</li>";
            ?>
        </ul>
        <div class="mt-2">
            <form method="POST">
                <input type="hidden" name="id" value="<?= $note['id']; ?>">
                <input type="hidden" name="user_id" value="<?= $note['user_id']; ?>">
                <button class="text-sm text-red-500">Delete</button>
            </form>
        </div>
    </div>
    <?php view('partials/footer.php'); ?>
