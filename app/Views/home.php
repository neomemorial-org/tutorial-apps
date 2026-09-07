<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>html{-webkit-text-size-adjust:100%}img{max-width:100%}[hidden]{display:none!important}</style>
<title>Alta de App en EasyPanel</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=IBM+Plex+Sans:ital,wght@0,400;0,500;0,600;1,400&family=IBM+Plex+Mono:wght@400;500;600&display=swap">
<script>(function(){try{var t=localStorage.getItem('ep-theme');document.documentElement.setAttribute('data-theme',t==='dark'?'dark':'light');}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
<style>
  :root {
    --ground: #FAFBF9;
    --surface: #FFFFFF;
    --surface-2: #F4F6F4;
    --text: #16201B;
    --muted: #5A6B60;
    --border: #E4EAE4;
    --border-strong: #CBD6CD;
    --accent: #0E9F6E;
    --accent-strong: #047857;
    --accent-soft: #E4F5EE;
    --php: #4F5B93;
    --php-soft: #ECEEF6;
    --warn: #B45309;
    --warn-soft: #FBF0E0;
    --code-bg: #12211B;
    --code-text: #D7E5DD;
    --code-border: #1D3129;
    --shadow: 0 1px 2px rgba(20,40,30,.06), 0 8px 24px -12px rgba(20,40,30,.18);
    --sans: "IBM Plex Sans", system-ui, sans-serif;
    --display: "Sora", "IBM Plex Sans", system-ui, sans-serif;
    --mono: "IBM Plex Mono", ui-monospace, "SF Mono", Menlo, monospace;
  }
  @media (prefers-color-scheme: dark) {
    :root:not([data-theme="light"]) {
      --ground: #0D1512;
      --surface: #131C18;
      --surface-2: #17231D;
      --text: #E4EDE7;
      --muted: #90A498;
      --border: #22302A;
      --border-strong: #33473D;
      --accent: #34D399;
      --accent-strong: #6EE7B7;
      --accent-soft: #10241C;
      --php: #A8B2DC;
      --php-soft: #1B2033;
      --warn: #F0B056;
      --warn-soft: #2A2113;
      --code-bg: #0A1310;
      --code-text: #CFE0D7;
      --code-border: #1B2A23;
      --shadow: 0 1px 2px rgba(0,0,0,.3), 0 10px 30px -14px rgba(0,0,0,.6);
    }
  }
  :root[data-theme="dark"] {
    --ground: #0D1512;
    --surface: #131C18;
    --surface-2: #17231D;
    --text: #E4EDE7;
    --muted: #90A498;
    --border: #22302A;
    --border-strong: #33473D;
    --accent: #34D399;
    --accent-strong: #6EE7B7;
    --accent-soft: #10241C;
    --php: #A8B2DC;
    --php-soft: #1B2033;
    --warn: #F0B056;
    --warn-soft: #2A2113;
    --code-bg: #0A1310;
    --code-text: #CFE0D7;
    --code-border: #1B2A23;
    --shadow: 0 1px 2px rgba(0,0,0,.3), 0 10px 30px -14px rgba(0,0,0,.6);
  }

  * { box-sizing: border-box; }
  body {
    margin: 0;
    background: var(--ground);
    color: var(--text);
    font-family: var(--sans);
    font-size: 16px;
    line-height: 1.65;
    -webkit-font-smoothing: antialiased;
  }
  ::selection { background: var(--accent-soft); }

  .layout {
    display: grid;
    grid-template-columns: 270px minmax(0, 1fr);
    max-width: 1180px;
    margin: 0 auto;
    gap: 0;
  }

  /* ---------- Sidebar ---------- */
  .sidebar {
    position: sticky;
    top: 0;
    align-self: start;
    height: 100vh;
    overflow-y: auto;
    padding: 32px 24px 40px;
    border-right: 1px solid var(--border);
  }
  .brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--display);
    font-weight: 700;
    font-size: 15px;
    letter-spacing: -.01em;
    margin-bottom: 4px;
  }
  .brand .rocket {
    display: grid;
    place-items: center;
    width: 30px; height: 30px;
    border-radius: 8px;
    background: var(--accent);
    color: #04140D;
    font-size: 16px;
    flex: none;
  }
  .brand-sub {
    font-size: 11.5px;
    color: var(--muted);
    letter-spacing: .08em;
    text-transform: uppercase;
    margin: 0 0 26px 40px;
  }
  .toc { list-style: none; margin: 0; padding: 0; }
  .toc li { margin: 0; }
  .toc a {
    display: flex;
    align-items: baseline;
    gap: 11px;
    padding: 8px 12px;
    border-radius: 8px;
    color: var(--muted);
    text-decoration: none;
    font-size: 14px;
    line-height: 1.35;
    transition: background .12s, color .12s;
  }
  .toc a:hover { background: var(--surface-2); color: var(--text); }
  .toc a.active { background: var(--accent-soft); color: var(--accent-strong); font-weight: 600; }
  .toc .n {
    font-family: var(--mono);
    font-size: 12px;
    font-weight: 600;
    color: var(--accent);
    flex: none;
    width: 16px;
    text-align: right;
  }
  .toc a.active .n { color: var(--accent-strong); }
  .toc .intro-link .n { color: var(--muted); }

  .theme-toggle {
    margin-top: 28px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 12px;
    font-family: var(--sans);
    font-size: 13px;
    color: var(--muted);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    cursor: pointer;
    transition: border-color .12s, color .12s;
  }
  .theme-toggle:hover { color: var(--text); border-color: var(--border-strong); }

  /* ---------- Main ---------- */
  main {
    padding: 56px clamp(24px, 5vw, 72px) 120px;
    min-width: 0;
  }
  .hero { margin-bottom: 8px; }
  .eyebrow {
    font-family: var(--display);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: var(--accent-strong);
    margin: 0 0 14px;
  }
  h1 {
    font-family: var(--display);
    font-weight: 700;
    font-size: clamp(30px, 5vw, 44px);
    line-height: 1.08;
    letter-spacing: -.02em;
    margin: 0 0 18px;
    text-wrap: balance;
    max-width: 16ch;
  }
  .lede {
    font-size: 18px;
    color: var(--muted);
    max-width: 62ch;
    margin: 0 0 28px;
  }
  .stackbar {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 48px;
  }
  .chip {
    font-family: var(--mono);
    font-size: 12.5px;
    font-weight: 500;
    padding: 5px 11px;
    border-radius: 999px;
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text);
  }
  .chip.em { color: var(--accent-strong); border-color: color-mix(in srgb, var(--accent) 40%, var(--border)); background: var(--accent-soft); }
  .chip.php { color: var(--php); border-color: color-mix(in srgb, var(--php) 35%, var(--border)); background: var(--php-soft); }

  section.step { scroll-margin-top: 28px; padding-top: 40px; }
  section.step + section.step { border-top: 1px solid var(--border); }
  .step-head {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 8px;
  }
  .step-num {
    font-family: var(--display);
    font-weight: 700;
    font-size: 15px;
    color: #04140D;
    background: var(--accent);
    width: 34px; height: 34px;
    border-radius: 9px;
    display: grid;
    place-items: center;
    flex: none;
  }
  h2 {
    font-family: var(--display);
    font-weight: 600;
    font-size: clamp(22px, 3vw, 27px);
    letter-spacing: -.015em;
    line-height: 1.2;
    margin: 0;
    text-wrap: balance;
  }
  h3 {
    font-family: var(--display);
    font-weight: 600;
    font-size: 17px;
    letter-spacing: -.01em;
    margin: 34px 0 10px;
  }
  p { max-width: 66ch; }
  main a { color: var(--accent-strong); text-decoration: underline; text-underline-offset: 2px; text-decoration-thickness: 1px; }
  strong { font-weight: 600; }
  code:not(pre code) {
    font-family: var(--mono);
    font-size: .87em;
    background: var(--surface-2);
    border: 1px solid var(--border);
    padding: 1px 6px;
    border-radius: 5px;
    color: var(--accent-strong);
    word-break: break-word;
  }

  ol.plain, ul.plain { max-width: 66ch; padding-left: 0; list-style: none; margin: 16px 0; }
  ol.steps { counter-reset: s; max-width: 66ch; padding-left: 0; list-style: none; margin: 18px 0; }
  ol.steps > li {
    counter-increment: s;
    position: relative;
    padding-left: 40px;
    margin-bottom: 16px;
  }
  ol.steps > li::before {
    content: counter(s);
    position: absolute;
    left: 0; top: 1px;
    font-family: var(--mono);
    font-size: 12px;
    font-weight: 600;
    color: var(--accent-strong);
    background: var(--accent-soft);
    width: 24px; height: 24px;
    border-radius: 6px;
    display: grid;
    place-items: center;
  }
  ul.bullets { max-width: 66ch; padding-left: 0; list-style: none; margin: 14px 0; }
  ul.bullets > li {
    position: relative;
    padding-left: 22px;
    margin-bottom: 8px;
  }
  ul.bullets > li::before {
    content: "";
    position: absolute;
    left: 4px; top: .68em;
    width: 6px; height: 6px;
    border-radius: 2px;
    background: var(--accent);
  }

  /* ---------- Code blocks ---------- */
  figure.code {
    margin: 20px 0;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--code-border);
    background: var(--code-bg);
    box-shadow: var(--shadow);
  }
  figure.code figcaption {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 9px 14px;
    background: color-mix(in srgb, var(--code-bg) 80%, #000);
    border-bottom: 1px solid var(--code-border);
    font-family: var(--mono);
    font-size: 12px;
    color: #8FA79A;
  }
  figure.code figcaption .fname { display: flex; align-items: center; gap: 8px; }
  figure.code figcaption .dot { width: 9px; height: 9px; border-radius: 50%; background: #2F4A3E; }
  .copybtn {
    font-family: var(--sans);
    font-size: 11.5px;
    font-weight: 500;
    color: #9BB5A8;
    background: transparent;
    border: 1px solid #2A4238;
    padding: 3px 9px;
    border-radius: 6px;
    cursor: pointer;
    transition: color .12s, border-color .12s, background .12s;
  }
  .copybtn:hover { color: #DCEDE5; border-color: #3C5C4E; }
  .copybtn.ok { color: #34D399; border-color: #2F6B52; }
  figure.code pre {
    margin: 0;
    padding: 16px 18px;
    overflow-x: auto;
    font-family: var(--mono);
    font-size: 13.5px;
    line-height: 1.6;
    color: var(--code-text);
  }
  figure.code pre code { font-family: inherit; color: inherit; }
  .tok-c { color: #6E8A7C; font-style: italic; }
  .tok-k { color: #7FD4A9; }
  .tok-s { color: #B7D98C; }
  .tok-v { color: #E3C591; }

  /* ---------- Callouts ---------- */
  .note {
    display: flex;
    gap: 13px;
    margin: 20px 0;
    padding: 15px 17px;
    border-radius: 10px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-left: 3px solid var(--accent);
    font-size: 14.5px;
  }
  .note.warn { border-left-color: var(--warn); background: var(--warn-soft); }
  .note .ic { flex: none; font-size: 16px; line-height: 1.5; }
  .note p { margin: 0; max-width: none; }
  .note p + p { margin-top: 6px; }

  .tree {
    font-family: var(--mono);
    font-size: 13px;
    line-height: 1.7;
    white-space: pre;
    tab-size: 2;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 18px 20px;
    margin: 20px 0;
    overflow-x: auto;
    color: var(--text);
    box-shadow: var(--shadow);
  }
  .tree .d { color: var(--accent-strong); font-weight: 600; }
  .tree .cm { color: var(--muted); }

  table.kv {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 14px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
  }
  table.kv th, table.kv td { text-align: left; padding: 11px 15px; border-bottom: 1px solid var(--border); vertical-align: top; }
  table.kv tr:last-child td { border-bottom: none; }
  table.kv th { font-family: var(--display); font-weight: 600; font-size: 12.5px; letter-spacing: .04em; text-transform: uppercase; color: var(--muted); background: var(--surface-2); }
  table.kv td:first-child { font-family: var(--mono); font-size: 12.5px; color: var(--php); white-space: nowrap; }

  .divider-final {
    margin-top: 56px;
    padding: 26px 28px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--accent-soft), var(--surface));
    border: 1px solid color-mix(in srgb, var(--accent) 30%, var(--border));
  }
  .divider-final h3 { margin-top: 0; }
  .divider-final p { margin-bottom: 0; }

  footer {
    margin-top: 64px;
    padding-top: 22px;
    border-top: 1px solid var(--border);
    font-size: 13px;
    color: var(--muted);
  }

  @media (max-width: 860px) {
    .layout { grid-template-columns: 1fr; }
    .sidebar {
      position: static;
      height: auto;
      border-right: none;
      border-bottom: 1px solid var(--border);
      padding: 22px 24px;
    }
    .sidebar .toc { display: grid; grid-template-columns: 1fr 1fr; gap: 2px 14px; }
    .brand-sub { display: none; }
    main { padding: 40px 24px 90px; }
  }
  @media (prefers-reduced-motion: reduce) { * { transition: none !important; scroll-behavior: auto !important; } }
  html { scroll-behavior: smooth; }
  :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; border-radius: 4px; }
</style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand"><span class="rocket">🚀</span> EasyPanel Deploy</div>
    <p class="brand-sub">Manual de alta</p>
    <nav>
      <ul class="toc">
        <li><a class="intro-link" href="#intro"><span class="n">·</span> Antes de empezar</a></li>
        <li><a href="#s1"><span class="n">1</span> Crear el repo en GitHub</a></li>
        <li><a href="#s2"><span class="n">2</span> Esqueleto con Claude</a></li>
        <li><a href="#s3"><span class="n">3</span> Crear la app en EasyPanel</a></li>
        <li><a href="#s4"><span class="n">4</span> Deploy key + webhook</a></li>
        <li><a href="#s5"><span class="n">5</span> Todo con Docker</a></li>
        <li><a href="#s6"><span class="n">6</span> Deploy: ver la wiki en vivo</a></li>
      </ul>
    </nav>
    <button class="theme-toggle" id="themeBtn" type="button"><span id="themeIc">◐</span> <span id="themeLbl">Tema</span></button>
  </aside>

  <main>
    <header class="hero" id="intro">
      <p class="eyebrow">Runbook · Deploy continuo</p>
      <h1>Alta de una app nueva en EasyPanel</h1>
      <p class="lede">De cero a un “hola mundo” en producción con deploy automático desde GitHub. Seguimos <strong>una sola app de ejemplo</strong> — PHP sin framework, Postgres, estructura MVC, todo construido con Docker — de punta a punta.</p>
      <div class="stackbar">
        <span class="chip php">PHP 8.3</span>
        <span class="chip">sin framework</span>
        <span class="chip">MVC</span>
        <span class="chip">PostgreSQL</span>
        <span class="chip em">Docker</span>
        <span class="chip em">EasyPanel</span>
        <span class="chip">GitHub</span>
      </div>

      <div class="note">
        <span class="ic">🧭</span>
        <div>
          <p><strong>La app de ejemplo.</strong> El manual usa nombres genéricos <code>miorg/miapp</code> para que los adaptes. El flujo es idéntico para cualquier stack: cambia solo el contenido del <code>Dockerfile</code> y del esqueleto que pides en el paso 2.</p>
        </div>
      </div>

      <div class="note">
        <span class="ic">🚀</span>
        <div>
          <p><strong>Estás viéndola.</strong> Esta misma página <em>es</em> la app desplegada: la home <code>/</code> renderiza esta wiki. Este tutorial se documenta a sí mismo.</p>
          <p>Repo <code>neomemorial-org/tutorial-apps</code> · App EasyPanel <code>apps-wiki</code> (build Docker, deploy key + webhook activos) · URL <a href="https://apps-wiki.u1xuyr.easypanel.host/" target="_blank" rel="noopener">apps-wiki.u1xuyr.easypanel.host</a></p>
          <p>El código vive en la <strong>raíz</strong> del repo (<code>Dockerfile</code>, <code>public/</code>, <code>app/</code>, <code>config/</code>), la doc en <code>docs/</code>, y el “hola mundo” de ejemplo quedó en la ruta <a href="/demo">/demo</a>.</p>
        </div>
      </div>
    </header>

    <!-- ============ PASO 1 ============ -->
    <section class="step" id="s1">
      <div class="step-head"><span class="step-num">1</span><h2>Crear el repositorio en GitHub</h2></div>
      <p>El repo es la fuente de verdad: EasyPanel va a construir y desplegar exactamente lo que esté en la rama que elijas (usamos <code>main</code>).</p>

      <h3>Opción A — desde la web</h3>
      <ol class="steps">
        <li>Entra a <a href="https://github.com/new" target="_blank" rel="noopener">github.com/new</a>.</li>
        <li>Nombre: <code>miapp</code>. Visibilidad: <strong>Private</strong> (el deploy key funciona igual con repos privados).</li>
        <li>Marca <strong>Add a README</strong> y elige <strong>.gitignore → nada aún</strong> (lo agregamos nosotros). Create repository.</li>
      </ol>

      <h3>Opción B — desde la terminal con <code>gh</code></h3>
      <figure class="code" data-lang="bash">
        <figcaption><span class="fname"><span class="dot"></span>terminal</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-c"># crear repo privado y clonar en un paso</span>
gh repo create miorg/miapp <span class="tok-k">--private</span> <span class="tok-k">--clone</span> <span class="tok-k">--add-readme</span>
<span class="tok-k">cd</span> miapp</code></pre>
      </figure>

      <h3>Un <code>.gitignore</code> mínimo para PHP</h3>
      <figure class="code" data-lang="gitignore">
        <figcaption><span class="fname"><span class="dot"></span>.gitignore</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code>/vendor/
.env
.env.*
!.env.example
*.log
.DS_Store</code></pre>
      </figure>

      <div class="note">
        <span class="ic">🔑</span>
        <div><p>Anota la <strong>URL SSH</strong> del repo: <code>git@github.com:miorg/miapp.git</code>. La vas a necesitar en el paso 4 para conectar EasyPanel.</p></div>
      </div>
    </section>

    <!-- ============ PASO 2 ============ -->
    <section class="step" id="s2">
      <div class="step-head"><span class="step-num">2</span><h2>Armar el esqueleto con Claude</h2></div>
      <p>En vez de crear archivos a mano, le pides a Claude que genere el esqueleto completo describiendo el <strong>stack</strong> y las <strong>convenciones</strong>. Cuanto más precisa la especificación, menos correcciones después.</p>

      <h3>Prompt plantilla (copiar y completar)</h3>
      <p>Reemplaza lo que está entre <code>«…»</code>. Este ejemplo ya viene cargado con el stack del manual:</p>
      <figure class="code" data-lang="prompt">
        <figcaption><span class="fname"><span class="dot"></span>prompt para Claude</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code>Arma el esqueleto base de una aplicación web lista para deploy con Docker.

STACK
- Lenguaje: PHP «8.3», sin framework (vanilla).
- Arquitectura: MVC (Model - View - Controller) con un front controller
  único en public/index.php y un router propio simple.
- Autoload: PSR-4 con un autoloader propio liviano (app/autoload.php),
  namespace raíz "App\\" apuntando a app/. Sin dependencias externas
  (Composer opcional, solo si más adelante agregas librerías).
- Base de datos: PostgreSQL, acceso vía PDO (pdo_pgsql).
- Config por variables de entorno (getenv), nunca hardcodeada.

ESTRUCTURA DE CARPETAS
  public/          -> único directorio expuesto por el servidor web
  app/Core/        -> Router, Database (conexión PDO)
  app/Controllers/ -> HomeController con acción index
  app/Views/       -> home.php
  config/          -> lectura de env
  Dockerfile       -> imagen php:8.3-apache con docroot en /public

REQUISITOS
- La ruta "/" debe responder un "Hola mundo" e indicar si la conexión
  a Postgres está OK (sin romper si la DB no está disponible todavía).
- Código PHP 8+ con declare(strict_types=1) y tipado.
- Comentarios breves en español.

Devuélveme cada archivo con su ruta y su contenido completo.</code></pre>
      </figure>

      <div class="note">
        <span class="ic">💡</span>
        <div>
          <p><strong>Qué variar por proyecto.</strong> Las 4 palancas que cambian el esqueleto:</p>
          <p><strong>Lenguaje/versión</strong> · <strong>framework o vanilla</strong> · <strong>base de datos</strong> · <strong>arquitectura</strong>. Todo lo demás (Docker, deploy) queda igual.</p>
        </div>
      </div>

      <h3>Estructura resultante</h3>
      <div class="tree"><span class="d">miapp/</span>
├── <span class="d">public/</span>
│   ├── index.php          <span class="cm"># front controller (única puerta de entrada)</span>
│   └── .htaccess          <span class="cm"># manda todo al front controller</span>
├── <span class="d">app/</span>
│   ├── autoload.php       <span class="cm"># autoloader PSR-4 propio (sin Composer)</span>
│   ├── <span class="d">Core/</span>
│   │   ├── Router.php      <span class="cm"># enruta method + path → controlador</span>
│   │   └── Database.php    <span class="cm"># conexión PDO a Postgres</span>
│   ├── <span class="d">Controllers/</span>
│   │   └── HomeController.php
│   └── <span class="d">Views/</span>
│       └── home.php
├── <span class="d">config/</span>
│   └── config.php
├── Dockerfile
└── .gitignore</div>

      <p>Revisa lo generado, haz commit y push a <code>main</code>:</p>
      <figure class="code" data-lang="bash">
        <figcaption><span class="fname"><span class="dot"></span>terminal</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code>git add .
git commit <span class="tok-k">-m</span> <span class="tok-s">"scaffold: esqueleto MVC PHP + Docker"</span>
git push <span class="tok-k">-u</span> origin main</code></pre>
      </figure>
    </section>

    <!-- ============ PASO 3 ============ -->
    <section class="step" id="s3">
      <div class="step-head"><span class="step-num">3</span><h2>Crear la aplicación en EasyPanel</h2></div>
      <p>En EasyPanel un <strong>Proyecto</strong> agrupa servicios (tu app + su base de datos). Dentro creas un servicio de tipo <strong>App</strong>.</p>
      <ol class="steps">
        <li>En el dashboard, <strong>Create Project</strong> → nombre <code>miapp</code>.</li>
        <li>Dentro del proyecto, <strong>+ Service</strong> → elige <strong>App</strong>.</li>
        <li>Ponle nombre al servicio, ej. <code>web</code>. Queda como <code>miapp_web</code> a nivel interno.</li>
        <li>Guarda. Todavía no despliega nada — falta conectar la fuente (paso 4) y definir el build (paso 5).</li>
      </ol>
      <div class="note">
        <span class="ic">🗄️</span>
        <div><p>El servicio de <strong>Postgres</strong> lo agregamos en el paso 6, cuando conectamos la base. Por ahora alcanza con el servicio <strong>App</strong>.</p></div>
      </div>
    </section>

    <!-- ============ PASO 4 ============ -->
    <section class="step" id="s4">
      <div class="step-head"><span class="step-num">4</span><h2>Conectar deploy automático: deploy key + webhook</h2></div>
      <p>Dos piezas trabajan juntas:</p>
      <ul class="bullets">
        <li><strong>Deploy key</strong> — clave SSH que le da a EasyPanel permiso de <em>lectura</em> sobre tu repo privado para poder clonarlo.</li>
        <li><strong>Webhook</strong> — aviso que GitHub le manda a EasyPanel en cada <code>push</code>, para que reconstruya y redespliegue solo.</li>
      </ul>

      <h3>4.1 · Apuntar EasyPanel al repo</h3>
      <ol class="steps">
        <li>En el servicio <code>web</code>, pestaña <strong>Source</strong> → elige <strong>GitHub</strong> (modo Deploy Key, no la GitHub App).</li>
        <li>Repository: <code>git@github.com:miorg/miapp.git</code> · Branch: <code>main</code>.</li>
        <li>EasyPanel genera y muestra una <strong>Deploy Key</strong> (clave pública SSH). Cópiala entera.</li>
      </ol>

      <h3>4.2 · Cargar la deploy key en GitHub</h3>
      <ol class="steps">
        <li>En el repo → <strong>Settings → Deploy keys → Add deploy key</strong>.</li>
        <li>Title: <code>easypanel</code>. Key: pega la clave que copiaste.</li>
        <li><strong>Deja SIN marcar “Allow write access”</strong> — EasyPanel solo necesita leer. Add key.</li>
      </ol>
      <div class="note warn">
        <span class="ic">🔒</span>
        <div><p><strong>Solo lectura.</strong> No habilites escritura en la deploy key. EasyPanel clona y construye; nunca necesita escribir en tu repo.</p></div>
      </div>

      <h3>4.3 · Registrar el webhook en GitHub</h3>
      <ol class="steps">
        <li>En EasyPanel, dentro de <strong>Source</strong> / <strong>Deployments</strong>, copia la <strong>Webhook URL</strong> que ofrece el servicio.</li>
        <li>En el repo → <strong>Settings → Webhooks → Add webhook</strong>.</li>
        <li>Payload URL: la de EasyPanel · Content type: <code>application/json</code>.</li>
        <li>Events: <strong>Just the push event</strong> · Active: ✓. Add webhook.</li>
      </ol>
      <p>GitHub manda un ping de prueba: en la lista de webhooks debería aparecer un <strong>✓ verde</strong> (Recent Deliveries → response 200). Si aparece rojo, revisa que la URL esté completa.</p>
      <div class="note">
        <span class="ic">🔁</span>
        <div><p>A partir de aquí: cada <code>git push origin main</code> dispara el webhook → EasyPanel clona con la deploy key → construye la imagen Docker → redespliega. Cero pasos manuales.</p></div>
      </div>
    </section>

    <!-- ============ PASO 5 ============ -->
    <section class="step" id="s5">
      <div class="step-head"><span class="step-num">5</span><h2>Todo se construye con Docker</h2></div>
      <p>EasyPanel puede usar Nixpacks o buildpacks, pero aquí mandamos nosotros: build method <strong>Dockerfile</strong>. Así el entorno de producción es idéntico al que definimos, sin sorpresas.</p>

      <h3>Elegir el build en EasyPanel</h3>
      <ol class="steps">
        <li>Servicio <code>web</code> → pestaña <strong>Build</strong> → método <strong>Dockerfile</strong>.</li>
        <li>Dockerfile path: <code>Dockerfile</code> (raíz del repo). Guarda.</li>
      </ol>

      <h3>El <code>Dockerfile</code> de la app</h3>
      <p>Imagen oficial PHP con Apache. Instalamos la extensión de Postgres, movemos el docroot a <code>/public</code> (nadie ve el resto del código) y copiamos la app. Como el esqueleto no tiene dependencias externas (usa su propio autoloader), <strong>no hace falta el paso de Composer</strong> — el build queda más simple y rápido.</p>
      <figure class="code" data-lang="dockerfile">
        <figcaption><span class="fname"><span class="dot"></span>Dockerfile</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">FROM</span> php:8.3-apache

<span class="tok-c"># 1. Extensiones PHP para PostgreSQL</span>
<span class="tok-k">RUN</span> apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

<span class="tok-c"># 2. Docroot en /public + rewrite + permitir .htaccess (AllowOverride All)</span>
<span class="tok-k">ENV</span> APACHE_DOCUMENT_ROOT=/var/www/html/public
<span class="tok-k">RUN</span> sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && printf '&lt;Directory %s&gt;\n    AllowOverride All\n    Require all granted\n&lt;/Directory&gt;\n' "$APACHE_DOCUMENT_ROOT" &gt; /etc/apache2/conf-available/app.conf \
    && a2enconf app

<span class="tok-c"># 3. Copiar el codigo (sin dependencias: autoloader propio)</span>
<span class="tok-k">WORKDIR</span> /var/www/html
<span class="tok-k">COPY</span> . /var/www/html

<span class="tok-k">EXPOSE</span> 80</code></pre>
      </figure>

      <div class="note warn">
        <span class="ic">⚠️</span>
        <div><p><strong>Gotcha importante.</strong> La imagen <code>php:8.3-apache</code> viene con <code>AllowOverride None</code>, así que <strong>ignora el <code>.htaccess</code></strong>. Sin la línea <code>AllowOverride All</code>, la home <code>/</code> funciona (la sirve <code>DirectoryIndex</code>) pero <strong>cualquier otra ruta da 404 de Apache</strong> (ej. <code>/demo</code>). Por eso agregamos el bloque <code>&lt;Directory&gt;</code>.</p></div>
      </div>

      <div class="note">
        <span class="ic">🌐</span>
        <div><p><strong>Puerto.</strong> La imagen expone el <code>80</code>. En EasyPanel → servicio → pestaña <strong>Domains</strong>, tu dominio (ej. <code>apps-wiki.u1xuyr.easypanel.host</code>) debe apuntar al puerto <code>80</code> del contenedor. EasyPanel resuelve el TLS solo con Let’s Encrypt.</p></div>
      </div>

      <div class="note">
        <span class="ic">📦</span>
        <div><p><strong>Si más adelante agregas Composer</strong>, agrega antes del <code>EXPOSE</code>: <code>COPY --from=composer:2 /usr/bin/composer /usr/bin/composer</code> y <code>RUN composer install --no-dev --optimize-autoloader</code>, y cambia el <code>require</code> de <code>index.php</code> a <code>vendor/autoload.php</code>.</p></div>
      </div>

      <h3>El <code>.htaccess</code> del front controller</h3>
      <p>En <code>public/.htaccess</code>, para que cualquier URL entre por <code>index.php</code> (Apache ya tiene <code>rewrite</code> por el Dockerfile):</p>
      <figure class="code" data-lang="apache">
        <figcaption><span class="fname"><span class="dot"></span>public/.htaccess</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">RewriteEngine</span> On
<span class="tok-k">RewriteCond</span> %{REQUEST_FILENAME} !-f
<span class="tok-k">RewriteCond</span> %{REQUEST_FILENAME} !-d
<span class="tok-k">RewriteRule</span> ^ index.php [QSA,L]</code></pre>
      </figure>

      <h3>Piezas clave del esqueleto</h3>
      <p>El autoloader propio, PSR-4 sin Composer:</p>
      <figure class="code" data-lang="php">
        <figcaption><span class="fname"><span class="dot"></span>app/autoload.php</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">&lt;?php</span>
declare(strict_types=1);

<span class="tok-c">// App\ -&gt; app/ . Si agregas librerías, pasa a Composer.</span>
spl_autoload_register(<span class="tok-k">static function</span> (string $class): void {
    $prefix = <span class="tok-s">'App\\'</span>;
    <span class="tok-k">if</span> (!str_starts_with($class, $prefix)) {
        <span class="tok-k">return</span>;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . <span class="tok-s">'/'</span> . str_replace(<span class="tok-s">'\\'</span>, <span class="tok-s">'/'</span>, $relative) . <span class="tok-s">'.php'</span>;
    <span class="tok-k">if</span> (is_file($file)) {
        <span class="tok-k">require</span> $file;
    }
});</code></pre>
      </figure>

      <p>El front controller, único punto de entrada expuesto:</p>
      <figure class="code" data-lang="php">
        <figcaption><span class="fname"><span class="dot"></span>public/index.php</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">&lt;?php</span>
declare(strict_types=1);

require __DIR__ . <span class="tok-s">'/../app/autoload.php'</span>;

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\DemoController;

$router = new Router();
$router-&gt;get(<span class="tok-s">'/'</span>, [HomeController::class, <span class="tok-s">'index'</span>]);      <span class="tok-c">// la wiki</span>
$router-&gt;get(<span class="tok-s">'/demo'</span>, [DemoController::class, <span class="tok-s">'index'</span>]); <span class="tok-c">// hola mundo + estado DB</span>
$router-&gt;dispatch($_SERVER[<span class="tok-s">'REQUEST_URI'</span>] ?? <span class="tok-s">'/'</span>, $_SERVER[<span class="tok-s">'REQUEST_METHOD'</span>] ?? <span class="tok-s">'GET'</span>);</code></pre>
      </figure>

      <p>La config leída de variables de entorno (nunca hardcodeada):</p>
      <figure class="code" data-lang="php">
        <figcaption><span class="fname"><span class="dot"></span>config/config.php</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">&lt;?php</span>
declare(strict_types=1);

<span class="tok-k">return</span> [
    <span class="tok-s">'db'</span> =&gt; [
        <span class="tok-s">'host'</span> =&gt; getenv(<span class="tok-s">'DB_HOST'</span>) ?: <span class="tok-s">''</span>,
        <span class="tok-s">'port'</span> =&gt; getenv(<span class="tok-s">'DB_PORT'</span>) ?: <span class="tok-s">'5432'</span>,
        <span class="tok-s">'name'</span> =&gt; getenv(<span class="tok-s">'DB_NAME'</span>) ?: <span class="tok-s">''</span>,
        <span class="tok-s">'user'</span> =&gt; getenv(<span class="tok-s">'DB_USER'</span>) ?: <span class="tok-s">''</span>,
        <span class="tok-s">'pass'</span> =&gt; getenv(<span class="tok-s">'DB_PASS'</span>) ?: <span class="tok-s">''</span>,
    ],
];</code></pre>
      </figure>

      <p>La conexión a Postgres, tolerante a que la DB aún no exista (el “hola mundo” abre aunque todavía no hayas creado el servicio Postgres):</p>
      <figure class="code" data-lang="php">
        <figcaption><span class="fname"><span class="dot"></span>app/Core/Database.php</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">&lt;?php</span>
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    public static function connect(): ?PDO
    {
        $cfg = <span class="tok-k">require</span> __DIR__ . <span class="tok-s">'/../../config/config.php'</span>;
        $db = $cfg[<span class="tok-s">'db'</span>];

        <span class="tok-c">// Sin credenciales todavía -&gt; no intentamos conectar.</span>
        <span class="tok-k">if</span> ($db[<span class="tok-s">'host'</span>] === <span class="tok-s">''</span> || $db[<span class="tok-s">'name'</span>] === <span class="tok-s">''</span>) {
            <span class="tok-k">return null</span>;
        }

        <span class="tok-k">try</span> {
            $dsn = sprintf(<span class="tok-s">'pgsql:host=%s;port=%s;dbname=%s'</span>, $db[<span class="tok-s">'host'</span>], $db[<span class="tok-s">'port'</span>], $db[<span class="tok-s">'name'</span>]);
            <span class="tok-k">return new</span> PDO($dsn, $db[<span class="tok-s">'user'</span>], $db[<span class="tok-s">'pass'</span>], [
                PDO::ATTR_ERRMODE =&gt; PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT =&gt; 3,
            ]);
        } <span class="tok-k">catch</span> (PDOException) {
            <span class="tok-k">return null</span>; <span class="tok-c">// arranca igual aunque la DB no esté lista</span>
        }
    }
}</code></pre>
      </figure>

      <p>La home renderiza <strong>esta misma wiki</strong>: <code>HomeController</code> incluye la vista <code>app/Views/home.php</code>, que es el HTML del sitio que estás leyendo.</p>
      <figure class="code" data-lang="php">
        <figcaption><span class="fname"><span class="dot"></span>app/Controllers/HomeController.php</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">&lt;?php</span>
declare(strict_types=1);

namespace App\Controllers;

final class HomeController
{
    public function index(): void
    {
        <span class="tok-c">// home.php es el sitio-wiki completo (HTML estatico)</span>
        require __DIR__ . <span class="tok-s">'/../Views/home.php'</span>;
    }
}</code></pre>
      </figure>

      <p>El “hola mundo” de ejemplo queda en <code>/demo</code> — sirve para comprobar que las variables de entorno y la conexión a Postgres funcionan:</p>
      <figure class="code" data-lang="php">
        <figcaption><span class="fname"><span class="dot"></span>app/Controllers/DemoController.php</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">&lt;?php</span>
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class DemoController
{
    public function index(): void
    {
        $db = Database::connect();
        $dbEstado = $db instanceof \PDO ? <span class="tok-s">'conectada'</span> : <span class="tok-s">'sin conexion'</span>;
        require __DIR__ . <span class="tok-s">'/../Views/demo.php'</span>;
    }
}</code></pre>
      </figure>
      <figure class="code" data-lang="php">
        <figcaption><span class="fname"><span class="dot"></span>app/Views/demo.php</span><button class="copybtn" type="button">Copiar</button></figcaption>
        <pre><code><span class="tok-k">&lt;!doctype html&gt;</span>
&lt;html lang=<span class="tok-s">"es"</span>&gt;
&lt;meta charset=<span class="tok-s">"utf-8"</span>&gt;
&lt;title&gt;apps-wiki · demo&lt;/title&gt;
&lt;body style=<span class="tok-s">"font-family:system-ui;padding:3rem"</span>&gt;
  &lt;h1&gt;Hola mundo 👋&lt;/h1&gt;
  &lt;p&gt;Base de datos: &lt;?= htmlspecialchars($dbEstado) ?&gt;&lt;/p&gt;
  &lt;p&gt;&lt;a href=<span class="tok-s">"/"</span>&gt;← volver a la wiki&lt;/a&gt;&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
      </figure>

      <div class="note">
        <span class="ic">📝</span>
        <div>
          <p><strong>Sobre <code>home.php</code> (generado).</strong> No se edita a mano. El fuente de la wiki vive en <code>wiki/source.html</code> (el mismo HTML del Artifact) y <code>home.php</code> se genera con <code>php bin/build-wiki.php</code>.</p>
          <p>El script envuelve el fuente en un documento HTML completo y lo escribe en <code>app/Views/home.php</code>. Flujo: editas <code>wiki/source.html</code> → ejecutas el script → commit + push → EasyPanel redespliega.</p>
        </div>
      </div>
    </section>

    <!-- ============ PASO 6 ============ -->
    <section class="step" id="s6">
      <div class="step-head"><span class="step-num">6</span><h2>Primer deploy: ver la wiki en vivo</h2></div>

      <h3>6.1 · Agregar Postgres <span style="color:var(--muted);font-weight:400;">(opcional para el primer deploy)</span></h3>
      <div class="note">
        <span class="ic">💡</span>
        <div><p>La wiki (home <code>/</code>) abre <strong>sin</strong> base de datos. Postgres solo lo necesita la ruta <code>/demo</code> para mostrar el estado de conexión. Puedes saltar 6.1 y 6.2 y sumarlo después.</p></div>
      </div>
      <ol class="steps">
        <li>En el proyecto <code>miapp</code> → <strong>+ Service → Postgres</strong>. Nombre: <code>db</code>.</li>
        <li>EasyPanel te muestra las <strong>Credentials</strong>: host interno, puerto, usuario, contraseña y database. El host interno suele ser el nombre del servicio, ej. <code>miapp_db</code>.</li>
      </ol>

      <h3>6.2 · Conectar la app a la DB con variables de entorno</h3>
      <p>En el servicio <code>web</code> → pestaña <strong>Environment</strong>, carga las variables que lee <code>Database.php</code>. Usa los valores internos del servicio Postgres:</p>
      <table class="kv">
        <tr><th>Variable</th><th>Valor (ejemplo)</th></tr>
        <tr><td>DB_HOST</td><td>miapp_db</td></tr>
        <tr><td>DB_PORT</td><td>5432</td></tr>
        <tr><td>DB_NAME</td><td>miapp</td></tr>
        <tr><td>DB_USER</td><td>postgres</td></tr>
        <tr><td>DB_PASS</td><td>«el que generó EasyPanel»</td></tr>
      </table>
      <div class="note">
        <span class="ic">🔌</span>
        <div><p>Los servicios del mismo proyecto se ven por red interna usando el <strong>nombre del servicio</strong> como host — no expongas Postgres a internet.</p></div>
      </div>

      <h3>6.3 · Desplegar</h3>
      <ol class="steps">
        <li>En el servicio <code>web</code>, toca <strong>Deploy</strong> (o simplemente haz un <code>git push</code> — el webhook lo dispara).</li>
        <li>Mira los <strong>Logs / Deployments</strong>: verás el build de Docker (FROM, extensiones, copy del código) y luego el contenedor arriba.</li>
        <li>Abre el <strong>dominio</strong> asignado en Domains → instancia real: <a href="https://apps-wiki.u1xuyr.easypanel.host/" target="_blank" rel="noopener">apps-wiki.u1xuyr.easypanel.host</a></li>
      </ol>

      <div class="note">
        <span class="ic">✅</span>
        <div><p>En <code>/</code> deberías ver <strong>esta misma wiki</strong>. Y en <a href="/demo">/demo</a>, el “Hola mundo” con <strong>“Base de datos: conectada”</strong> (o <strong>“sin conexion”</strong> si todavía no creaste Postgres — la app abre igual; pasa a “conectada” cuando cargues las variables del paso 6.2).</p></div>
      </div>

      <div class="divider-final">
        <h3>Listo — y ahora es automático</h3>
        <p>La app quedó en producción y el pipeline en marcha. De aquí en más el ciclo es: <strong>editas → <code>git push origin main</code> → EasyPanel construye y redespliega solo</strong>. Para una app nueva, repites del paso 1 al 6 cambiando el nombre del repo y el <code>Dockerfile</code>.</p>
      </div>

      <footer>
        Manual de alta de apps en EasyPanel · ejemplo <code>miorg/miapp</code> · PHP 8.3 · PostgreSQL · Docker
      </footer>
    </section>
  </main>
</div>

<script>
  // Copiar código
  document.querySelectorAll('figure.code').forEach(function (fig) {
    var btn = fig.querySelector('.copybtn');
    var code = fig.querySelector('pre');
    if (!btn || !code) return;
    btn.addEventListener('click', function () {
      navigator.clipboard.writeText(code.innerText).then(function () {
        var prev = btn.textContent;
        btn.textContent = '¡Copiado!';
        btn.classList.add('ok');
        setTimeout(function () { btn.textContent = prev; btn.classList.remove('ok'); }, 1400);
      });
    });
  });

  // Scrollspy en la TOC
  var links = Array.prototype.slice.call(document.querySelectorAll('.toc a'));
  var map = {};
  links.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });
  var spy = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        links.forEach(function (l) { l.classList.remove('active'); });
        if (map[e.target.id]) map[e.target.id].classList.add('active');
      }
    });
  }, { rootMargin: '-15% 0px -70% 0px', threshold: 0 });
  document.querySelectorAll('section.step, #intro').forEach(function (s) { spy.observe(s); });

  // Toggle de tema
  var root = document.documentElement;
  var btn = document.getElementById('themeBtn');
  var ic = document.getElementById('themeIc');
  var lbl = document.getElementById('themeLbl');
  function prefersDark() { return window.matchMedia('(prefers-color-scheme: dark)').matches; }
  function apply(mode) {
    if (mode === 'system') { root.removeAttribute('data-theme'); }
    else { root.setAttribute('data-theme', mode); }
    var dark = mode === 'dark' || (mode === 'system' && prefersDark());
    ic.textContent = dark ? '☀' : '☾';
    lbl.textContent = dark ? 'Claro' : 'Oscuro';
  }
  var cur = 'light';
  try { cur = localStorage.getItem('ep-theme') || 'light'; } catch (e) {}
  apply(cur);
  btn.addEventListener('click', function () {
    var darkNow = cur === 'dark' || (cur === 'system' && prefersDark());
    cur = darkNow ? 'light' : 'dark';
    try { localStorage.setItem('ep-theme', cur); } catch (e) {}
    apply(cur);
  });
</script>
</body>
</html>
