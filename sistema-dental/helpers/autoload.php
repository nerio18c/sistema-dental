<?php
// helpers/autoload.php
spl_autoload_register(function($class) {
    $paths = ['controllers/', 'models/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/../' . $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
