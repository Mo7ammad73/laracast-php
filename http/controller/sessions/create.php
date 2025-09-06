<?php
    view("sessions/create.view.php",['error' => \core\session::get('error') ?? [] ]);