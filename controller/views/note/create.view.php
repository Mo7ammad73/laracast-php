<?php $current_page="Create Notes"; ?>
<?php require_once __DIR__."/../partials/nav.php"; ?>
<?php require_once __DIR__."/../partials/header.php"; ?>

    <div class="mt-6">
        <form method="post">
            <div class="space-y-12">

                <div class="col-span-full">
                    <label for="body" class="block text-sm/6 font-medium text-gray-900">Body</label>
                    <div class="mt-2">
                        <textarea id="body"
                                  name="body"
                                  placeholder="note text"
                                  rows="3"
                                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                  ><?= isset($_POST['body']) ? $_POST['body'] : '' ; ?></textarea>
                        <?php if(isset($error['body'])): ?>
                            <p class="text-red-500"><?=$error['body'] ?></p>
                        <?php endif; ?>
                    </div>
                    <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences  for notes.</p>
                </div>


                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
        </form>

    </div>


<?php require_once __DIR__."/../partials/footer.php"; ?>