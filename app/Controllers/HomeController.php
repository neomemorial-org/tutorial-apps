<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use PDO;

final class HomeController
{
    public function index(): void
    {
        $db = Database::connect();
        $dbEstado = $db instanceof PDO ? 'conectada' : 'sin conexion';

        require __DIR__ . '/../Views/home.php';
    }
}
