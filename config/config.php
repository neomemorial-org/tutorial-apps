<?php
declare(strict_types=1);

// Configuracion leida de variables de entorno (nunca hardcodeada).
// En EasyPanel se cargan en la pestana Environment del servicio.
return [
    'db' => [
        'host' => getenv('DB_HOST') ?: '',
        'port' => getenv('DB_PORT') ?: '5432',
        'name' => getenv('DB_NAME') ?: '',
        'user' => getenv('DB_USER') ?: '',
        'pass' => getenv('DB_PASS') ?: '',
    ],
];
