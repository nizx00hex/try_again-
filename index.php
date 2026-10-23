
<?php

// require_once __DIR__ . '/src/Models/Database.class.php';
require_once __DIR__ . '/src/Core/__init__.php';

// Your test code goes here


try {
    // echo 2;

    // $uid = Auth::signup('Hexonaa', 'Teoraaa', 'nisath1', 'nisathnisath1@gmail.com', 'password234C$D', 'password234C$D');
    $config_json = file_get_contents('REGISTER.php');
    // $i = 0;
    // for($i; $i< 10; $i++) {
    //     $i*2;
    //     Auth::signup("Hexonaa$i", "Teoraaa$i", "nisath1$i", "nisathnisath1@gmail.com$i", "password2$@34C$i", "password2$@34C$i");
    // }
} catch (Throwable $e) {
    echo "TEST FAILED: " . $e->getMessage() . "\n";
}
