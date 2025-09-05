<?php
    use core\authenticator;
    (new authenticator())->logout();
    header('Location: /laracast-php/public');
    exit;