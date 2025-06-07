<?php

// Autoloader
spl_autoload_register(function ($class) {
    // Convert namespace to full file path
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/../' . $class . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . '/../app/config/params.php';

// Autoload all controllers
require_once __DIR__ . '/../app/controllers/Controller.php';
foreach (glob(__DIR__ . '/../app/controllers/*.php') as $filename) {
    if (basename($filename) !== 'Controller.php') {
        require_once $filename;
    }
}

// Autoload base model first
require_once __DIR__ . '/../app/models/Model.php';
// Then autoload all other models
foreach (glob(__DIR__ . '/../app/models/*.php') as $filename) {
    if (basename($filename) !== 'Model.php') {
        require_once $filename;
    }
}
