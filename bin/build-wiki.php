<?php
declare(strict_types=1);

/**
 * build-wiki.php
 * -----------------------------------------------------------------------------
 * Genera la vista servida por la app (app/Views/home.php) a partir del fuente
 * de la wiki (wiki/source.html).
 *
 * El fuente es el mismo HTML que se publica como Artifact: empieza en <title>
 * (sin <!doctype>/<html>/<head>/<body>, porque el Artifact los agrega). Este
 * script lo envuelve en un documento HTML completo para poder servirlo directo
 * por Apache/PHP.
 *
 * Uso:
 *   php bin/build-wiki.php                 # usa las rutas por defecto del repo
 *   php bin/build-wiki.php src.html out.php
 */

$root = dirname(__DIR__);
$src  = $argv[1] ?? $root . '/wiki/source.html';
$out  = $argv[2] ?? $root . '/app/Views/home.php';

if (!is_file($src)) {
    fwrite(STDERR, "ERROR: no existe el fuente: $src\n");
    exit(1);
}

$html = file_get_contents($src);
if ($html === false) {
    fwrite(STDERR, "ERROR: no se pudo leer: $src\n");
    exit(1);
}

// El <head> del fuente termina en el primer </style>. Todo lo anterior
// (title, links de fuentes, estilos) va al <head>; el resto (layout + script)
// va al <body>.
$marker = '</style>';
$pos = strpos($html, $marker);
if ($pos === false) {
    fwrite(STDERR, "ERROR: no se encontro '</style>' en el fuente.\n");
    exit(1);
}
$pos += strlen($marker);
$head = substr($html, 0, $pos);
$body = substr($html, $pos);

$doc  = "<!doctype html>\n<html lang=\"es\">\n<head>\n";
$doc .= "<meta charset=\"utf-8\">\n";
$doc .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
// Reset minimo (lo que el runtime del Artifact agrega por su cuenta).
$doc .= "<style>html{-webkit-text-size-adjust:100%}img{max-width:100%}[hidden]{display:none!important}</style>\n";
$doc .= $head . "\n</head>\n<body>\n" . trim($body) . "\n</body>\n</html>\n";

if (file_put_contents($out, $doc) === false) {
    fwrite(STDERR, "ERROR: no se pudo escribir: $out\n");
    exit(1);
}

printf("OK  %s  (%d bytes)\n", $out, strlen($doc));
