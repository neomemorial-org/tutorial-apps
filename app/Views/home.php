<?php
/** @var string $dbEstado */
$ok = $dbEstado === 'conectada';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>apps-wiki · Hola mundo</title>
  <style>
    :root { color-scheme: dark; }
    * { box-sizing: border-box; }
    body {
      margin: 0; min-height: 100vh;
      display: grid; place-items: center;
      font-family: system-ui, -apple-system, sans-serif;
      background: radial-gradient(120% 120% at 50% 0%, #12211b 0%, #0b120f 60%);
      color: #e4ede7;
    }
    .card { text-align: center; padding: 3rem 2rem; }
    .wave { font-size: 3.2rem; line-height: 1; }
    h1 { font-size: clamp(2rem, 6vw, 2.8rem); margin: .6rem 0 .3rem; letter-spacing: -.02em; }
    .sub { color: #90a498; margin: 0 0 1.8rem; font-size: .98rem; }
    .status {
      display: inline-flex; align-items: center; gap: .55rem;
      font-family: ui-monospace, "SF Mono", Menlo, monospace; font-size: .85rem;
      padding: .5rem 1rem; border-radius: 999px;
      border: 1px solid #22302a; background: #101a15; color: #cfe0d7;
    }
    .dot { width: .55rem; height: .55rem; border-radius: 50%; }
    .dot.on { background: #34d399; } .dot.off { background: #f0b056; }
    .foot { margin-top: 1.6rem; font-size: .8rem; color: #5a6b60; }
  </style>
</head>
<body>
  <main class="card">
    <div class="wave">👋</div>
    <h1>Hola mundo</h1>
    <p class="sub">apps-wiki · desplegada con Docker en EasyPanel</p>
    <span class="status">
      <span class="dot <?= $ok ? 'on' : 'off' ?>"></span>
      Base de datos: <?= htmlspecialchars($dbEstado) ?>
    </span>
    <p class="foot">PHP <?= PHP_VERSION ?> · MVC · deploy automatico desde GitHub</p>
  </main>
</body>
</html>
