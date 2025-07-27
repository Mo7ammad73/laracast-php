<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900"><?=$current_page ?></h1>
        <br>
        <?php if($current_page == "Notes"): ?>
            <ul style="list-style-type: disc">
                <?php
                    foreach($notes as $note){
                        echo "<li>" . "<a href=/laracast-php/notes/note?id={$note['id']} class=text-blue-500 hover:underline > " . $note['body'] . "</a></li>";
                    }
                ?>
            </ul>
        <?php endif; ?>
        <?php if($current_page == "Note"): ?>
            <?= $_GET['id']; ?>
            <ul style="list-style-type: disc">
                <?php
                    echo  $note['body'] ;
                ?>
            </ul>
        <?php endif; ?>
    </div>
</header>
<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Your content -->
    </div>
</main>