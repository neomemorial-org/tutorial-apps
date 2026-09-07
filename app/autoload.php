<?php
declare(strict_types=1);

// Autoloader PSR-4 minimo (sin Composer): App\ -> app/
// Si en el futuro sumas librerias de terceros, pasa a Composer.
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require $file;
    }
});
