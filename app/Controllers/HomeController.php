<?php
declare(strict_types=1);

namespace App\Controllers;

final class HomeController
{
    public function index(): void
    {
        // home.php es el sitio-wiki completo (HTML estatico).
        require __DIR__ . '/../Views/home.php';
    }
}
