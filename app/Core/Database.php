<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

// Conexion PDO a PostgreSQL. Tolerante: si la DB no esta configurada
// o no responde, devuelve null y la app arranca igual.
final class Database
{
    public static function connect(): ?PDO
    {
        $cfg = require __DIR__ . '/../../config/config.php';
        $db = $cfg['db'];

        // Sin credenciales cargadas todavia -> no intentamos conectar.
        if ($db['host'] === '' || $db['name'] === '') {
            return null;
        }

        try {
            $dsn = sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                $db['host'],
                $db['port'],
                $db['name']
            );

            return new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 3,
            ]);
        } catch (PDOException) {
            return null;
        }
    }
}
