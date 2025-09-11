<?php

    view('registeration/create.view.php' , ['error' => \core\session::get('error') ?? [] ]);