
<?= view("partials/nav.php"); ?>
<?= view("partials/header.php",['heading' => 'Log in']); ?>
<main>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Log in</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="/laracast-php/public/login" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-black-100">Email</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" required autocomplete="email" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-green outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-black-100">Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-green outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Log in</button>
                </div>
                <?php if(isset($error['email'])): ?>
                    <p class="text-red-500"><?=$error['email'] ?></p>
                <?php endif; ?>
                <?php if(isset($error['password'])): ?>
                    <p class="text-red-500"><?=$error['password'] ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

</main>


<?= view("partials/footer.php"); ?>