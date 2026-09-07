# Alta de una app nueva en EasyPanel

> Manual paso a paso: de cero a un **"hola mundo"** en producción con **deploy automático desde GitHub**.
> Seguimos **una sola app de ejemplo** de punta a punta — PHP sin framework, PostgreSQL, estructura MVC, todo construido con Docker.

**Stack del ejemplo:** `PHP 8.3` · sin framework · MVC · PostgreSQL · Docker · EasyPanel · GitHub

> 🧭 **La app de ejemplo.** El manual usa nombres genéricos `miorg/miapp` para que los adaptes. El flujo es idéntico para cualquier stack: cambia solo el contenido del `Dockerfile` y del esqueleto que pides en el paso 2.

> 🚀 **Este tutorial se documenta a sí mismo.** La app desplegada **sirve esta misma wiki** como sitio web: la home `/` renderiza el sitio-wiki que estás leyendo.
> - **Repo:** [`neomemorial-org/tutorial-apps`](https://github.com/neomemorial-org/tutorial-apps)
> - **App (EasyPanel):** `apps-wiki` · build por Docker · deploy key + webhook activos
> - **URL en vivo (la wiki):** <https://apps-wiki.u1xuyr.easypanel.host/>
> - **Demo hola-mundo (estado DB):** <https://apps-wiki.u1xuyr.easypanel.host/demo>
>
> El código vive en la **raíz del repo** (`Dockerfile`, `public/`, `app/`, `config/`), la documentación en `docs/` (versión markdown), y el sitio-wiki en `app/Views/home.php`.

## Índice

1. [Crear el repositorio en GitHub](#1-crear-el-repositorio-en-github)
2. [Armar el esqueleto con Claude](#2-armar-el-esqueleto-con-claude)
3. [Crear la aplicación en EasyPanel](#3-crear-la-aplicación-en-easypanel)
4. [Conectar deploy automático: deploy key + webhook](#4-conectar-deploy-automático-deploy-key--webhook)
5. [Todo se construye con Docker](#5-todo-se-construye-con-docker)
6. [Primer deploy: ver la wiki en vivo](#6-primer-deploy-ver-la-wiki-en-vivo)

---

## 1. Crear el repositorio en GitHub

El repo es la fuente de verdad: EasyPanel va a construir y desplegar exactamente lo que esté en la rama que elijas (usamos `main`).

### Opción A — desde la web

1. Entra a [github.com/new](https://github.com/new).
2. Nombre: `miapp`. Visibilidad: **Private** (el deploy key funciona igual con repos privados).
3. Marca **Add a README** y deja el `.gitignore` en **nada aún** (lo agregamos nosotros). Create repository.

### Opción B — desde la terminal con `gh`

```bash
# crear repo privado y clonar en un paso
gh repo create miorg/miapp --private --clone --add-readme
cd miapp
```

### Un `.gitignore` mínimo para PHP

```gitignore
/vendor/
.env
.env.*
!.env.example
*.log
.DS_Store
```

> 🔑 Anota la **URL SSH** del repo: `git@github.com:miorg/miapp.git`. La vas a necesitar en el paso 4 para conectar EasyPanel.

---

## 2. Armar el esqueleto con Claude

En vez de crear archivos a mano, le pides a Claude que genere el esqueleto completo describiendo el **stack** y las **convenciones**. Cuanto más precisa la especificación, menos correcciones después.

### Prompt plantilla (copiar y completar)

Reemplaza lo que está entre `«…»`. Este ejemplo ya viene cargado con el stack del manual:

```text
Arma el esqueleto base de una aplicación web lista para deploy con Docker.

STACK
- Lenguaje: PHP «8.3», sin framework (vanilla).
- Arquitectura: MVC (Model - View - Controller) con un front controller
  único en public/index.php y un router propio simple.
- Autoload: PSR-4 con un autoloader propio liviano (app/autoload.php),
  namespace raíz "App\" apuntando a app/. Sin dependencias externas
  (Composer opcional, solo si más adelante agregas librerías).
- Base de datos: PostgreSQL, acceso vía PDO (pdo_pgsql).
- Config por variables de entorno (getenv), nunca hardcodeada.

ESTRUCTURA DE CARPETAS
  public/          -> único directorio expuesto por el servidor web
  app/autoload.php -> autoloader PSR-4 propio (sin Composer)
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

Devuélveme cada archivo con su ruta y su contenido completo.
```

> 💡 **Qué variar por proyecto.** Las 4 palancas que cambian el esqueleto: **lenguaje/versión** · **framework o vanilla** · **base de datos** · **arquitectura**. Todo lo demás (Docker, deploy) queda igual.

### Estructura resultante

```text
miapp/
├── public/
│   ├── index.php          # front controller (única puerta de entrada)
│   └── .htaccess          # manda todo al front controller
├── app/
│   ├── autoload.php       # autoloader PSR-4 propio (sin Composer)
│   ├── Core/
│   │   ├── Router.php      # enruta method + path → controlador
│   │   └── Database.php    # conexión PDO a Postgres
│   ├── Controllers/
│   │   ├── HomeController.php   # sirve la wiki en /
│   │   └── DemoController.php   # hola mundo + estado DB en /demo
│   └── Views/
│       ├── home.php    # el sitio-wiki (HTML estático)
│       └── demo.php    # vista del hola mundo
├── config/
│   └── config.php
├── Dockerfile
└── .gitignore
```

Revisa lo generado, haz commit y push a `main`:

```bash
git add .
git commit -m "scaffold: esqueleto MVC PHP + Docker"
git push -u origin main
```

---

## 3. Crear la aplicación en EasyPanel

En EasyPanel un **Proyecto** agrupa servicios (tu app + su base de datos). Dentro creas un servicio de tipo **App**.

1. En el dashboard, **Create Project** → nombre `miapp`.
2. Dentro del proyecto, **+ Service** → elige **App**.
3. Ponle nombre al servicio, ej. `web`. Queda como `miapp_web` a nivel interno.
4. Guarda. Todavía no despliega nada — falta conectar la fuente (paso 4) y definir el build (paso 5).

> 🗄️ El servicio de **Postgres** lo agregamos en el paso 6, cuando conectamos la base. Por ahora alcanza con el servicio **App**.

---

## 4. Conectar deploy automático: deploy key + webhook

Dos piezas trabajan juntas:

- **Deploy key** — clave SSH que le da a EasyPanel permiso de *lectura* sobre tu repo privado para poder clonarlo.
- **Webhook** — aviso que GitHub le manda a EasyPanel en cada `push`, para que reconstruya y redespliegue solo.

### 4.1 · Apuntar EasyPanel al repo

1. En el servicio `web`, pestaña **Source** → elige **GitHub** (modo Deploy Key, no la GitHub App).
2. Repository: `git@github.com:miorg/miapp.git` · Branch: `main`.
3. EasyPanel genera y muestra una **Deploy Key** (clave pública SSH). Cópiala entera.

### 4.2 · Cargar la deploy key en GitHub

1. En el repo → **Settings → Deploy keys → Add deploy key**.
2. Title: `easypanel`. Key: pega la clave que copiaste.
3. **Deja SIN marcar "Allow write access"** — EasyPanel solo necesita leer. Add key.

> 🔒 **Solo lectura.** No habilites escritura en la deploy key. EasyPanel clona y construye; nunca necesita escribir en tu repo.

### 4.3 · Registrar el webhook en GitHub

1. En EasyPanel, dentro de **Source** / **Deployments**, copia la **Webhook URL** que ofrece el servicio.
2. En el repo → **Settings → Webhooks → Add webhook**.
3. Payload URL: la de EasyPanel · Content type: `application/json`.
4. Events: **Just the push event** · Active: ✓. Add webhook.

GitHub manda un ping de prueba: en la lista de webhooks debería aparecer un **✓ verde** (Recent Deliveries → response 200). Si aparece rojo, revisa que la URL esté completa.

> 🔁 A partir de aquí: cada `git push origin main` dispara el webhook → EasyPanel clona con la deploy key → construye la imagen Docker → redespliega. Cero pasos manuales.

---

## 5. Todo se construye con Docker

EasyPanel puede usar Nixpacks o buildpacks, pero aquí mandamos nosotros: build method **Dockerfile**. Así el entorno de producción es idéntico al que definimos, sin sorpresas.

### Elegir el build en EasyPanel

1. Servicio `web` → pestaña **Build** → método **Dockerfile**.
2. Dockerfile path: `Dockerfile` (raíz del repo). Guarda.

### El `Dockerfile` de la app

Imagen oficial PHP con Apache. Instalamos la extensión de Postgres, movemos el docroot a `/public` (nadie ve el resto del código) y copiamos la app. Como el esqueleto no tiene dependencias externas (usa su propio autoloader), **no hace falta el paso de Composer** — el build queda más simple y rápido.

```dockerfile
FROM php:8.3-apache

# 1. Extensiones PHP para PostgreSQL
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# 2. Docroot en /public + rewrite + permitir .htaccess (AllowOverride All)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && printf '<Directory %s>\n    AllowOverride All\n    Require all granted\n</Directory>\n' "$APACHE_DOCUMENT_ROOT" > /etc/apache2/conf-available/app.conf \
    && a2enconf app

# 3. Copiar el codigo (sin dependencias externas: autoloader propio)
WORKDIR /var/www/html
COPY . /var/www/html

EXPOSE 80
```

> ⚠️ **Gotcha importante.** La imagen `php:8.3-apache` viene con `AllowOverride None`, así que **ignora el `.htaccess`**. Sin la línea `AllowOverride All`, la home `/` funciona (la sirve `DirectoryIndex`) pero **cualquier otra ruta da 404 de Apache** (ej. `/demo`), porque el rewrite del front controller nunca corre. Por eso agregamos el bloque `<Directory>` con `AllowOverride All`.

> 🌐 **Puerto.** La imagen expone el `80`. En EasyPanel, servicio → pestaña **Domains**, tu dominio (ej. `apps-wiki.u1xuyr.easypanel.host`) debe apuntar al puerto **`80`** del contenedor. EasyPanel resuelve el TLS solo con Let's Encrypt.

> 📌 **Si más adelante agregas librerías con Composer**, agrega al Dockerfile, antes del `EXPOSE`:
> ```dockerfile
> COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
> RUN composer install --no-dev --optimize-autoloader --no-interaction
> ```
> y cambia el `require` de `public/index.php` a `require __DIR__ . '/../vendor/autoload.php';`.

### El `.htaccess` que enruta todo al front controller

En `public/.htaccess`, para que cualquier URL entre por `index.php` (Apache ya tiene `rewrite` habilitado por el Dockerfile):

```apacheconf
# public/.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

### Piezas clave del esqueleto

El autoloader propio, PSR-4 sin Composer:

```php
<?php
// app/autoload.php
declare(strict_types=1);

// App\ -> app/ . Si agregas librerías de terceros, pasa a Composer.
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
```

El front controller, único punto de entrada expuesto:

```php
<?php
// public/index.php
declare(strict_types=1);

require __DIR__ . '/../app/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\DemoController;

$router = new Router();
$router->get('/', [HomeController::class, 'index']);       // la wiki
$router->get('/demo', [DemoController::class, 'index']);   // hola mundo + estado DB
$router->dispatch($_SERVER['REQUEST_URI'] ?? '/', $_SERVER['REQUEST_METHOD'] ?? 'GET');
```

La config leída de variables de entorno (nunca hardcodeada):

```php
<?php
// config/config.php
declare(strict_types=1);

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: '',
        'port' => getenv('DB_PORT') ?: '5432',
        'name' => getenv('DB_NAME') ?: '',
        'user' => getenv('DB_USER') ?: '',
        'pass' => getenv('DB_PASS') ?: '',
    ],
];
```

La conexión a Postgres, tolerante a que la DB aún no exista (así el "hola mundo" abre aunque todavía no hayas creado el servicio Postgres):

```php
<?php
// app/Core/Database.php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    public static function connect(): ?PDO
    {
        $cfg = require __DIR__ . '/../../config/config.php';
        $db = $cfg['db'];

        // Sin credenciales cargadas todavía -> no intentamos conectar.
        if ($db['host'] === '' || $db['name'] === '') {
            return null;
        }

        try {
            $dsn = sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                $db['host'], $db['port'], $db['name']
            );
            return new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 3,
            ]);
        } catch (PDOException) {
            return null; // La app arranca igual aunque la DB no esté lista
        }
    }
}
```

La home renderiza **esta misma wiki**: `HomeController` incluye la vista `app/Views/home.php`, que es el HTML del sitio (el mismo que ves publicado como Artifact). Es HTML estático, sin lógica PHP:

```php
<?php
// app/Controllers/HomeController.php
declare(strict_types=1);

namespace App\Controllers;

final class HomeController
{
    public function index(): void
    {
        // home.php es el sitio-wiki completo (HTML estatico)
        require __DIR__ . '/../Views/home.php';
    }
}
```

El "hola mundo" de ejemplo queda en `/demo` — sirve para comprobar que las variables de entorno y la conexión a Postgres funcionan:

```php
<?php
// app/Controllers/DemoController.php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class DemoController
{
    public function index(): void
    {
        $db = Database::connect();
        $dbEstado = $db instanceof \PDO ? 'conectada' : 'sin conexion';
        require __DIR__ . '/../Views/demo.php';
    }
}
```

```php
<!-- app/Views/demo.php -->
<!doctype html>
<html lang="es">
<meta charset="utf-8">
<title>apps-wiki · demo</title>
<body style="font-family:system-ui;padding:3rem">
  <h1>Hola mundo 👋</h1>
  <p>Base de datos: <?= htmlspecialchars($dbEstado) ?></p>
  <p><a href="/">← volver a la wiki</a></p>
</body>
</html>
```

> 📝 **Sobre `home.php` (generado).** No se edita a mano. El fuente de la wiki vive en `wiki/source.html` (el mismo HTML que se publica como Artifact) y `home.php` se genera con:
> ```bash
> php bin/build-wiki.php
> ```
> El script envuelve el fuente en un documento HTML completo (`<!doctype>`/`<head>`/`<body>`) y lo escribe en `app/Views/home.php`. Edita `wiki/source.html`, ejecuta el script, haz commit y push → EasyPanel redespliega la wiki actualizada.

---

## 6. Primer deploy: ver la wiki en vivo

### 6.1 · Agregar Postgres (opcional para el primer deploy)

> La wiki (home `/`) abre **sin** base de datos. Postgres solo lo necesita la ruta `/demo` para mostrar el estado de conexión. Puedes saltar 6.1 y 6.2 y sumarlo después.

1. En el proyecto `miapp` → **+ Service → Postgres**. Nombre: `db`.
2. EasyPanel te muestra las **Credentials**: host interno, puerto, usuario, contraseña y database. El host interno suele ser el nombre del servicio, ej. `miapp_db`.

### 6.2 · Conectar la app a la DB con variables de entorno

En el servicio `web` → pestaña **Environment**, carga las variables que lee `Database.php`. Usa los valores internos del servicio Postgres:

| Variable   | Valor (ejemplo)              |
|------------|------------------------------|
| `DB_HOST`  | `miapp_db`                   |
| `DB_PORT`  | `5432`                       |
| `DB_NAME`  | `miapp`                      |
| `DB_USER`  | `postgres`                   |
| `DB_PASS`  | `«el que generó EasyPanel»`  |

> 🔌 Los servicios del mismo proyecto se ven por red interna usando el **nombre del servicio** como host — no expongas Postgres a internet.

### 6.3 · Desplegar

1. En el servicio `web`, toca **Deploy** (o simplemente haz un `git push` — el webhook lo dispara).
2. Mira los **Logs / Deployments**: verás el build de Docker (FROM, extensiones, copy del código) y luego el contenedor arriba.
3. Abre el **dominio** asignado en la pestaña Domains → en la instancia real: <https://apps-wiki.u1xuyr.easypanel.host/>

> ✅ En `/` deberías ver **esta misma wiki**. Y en [`/demo`](https://apps-wiki.u1xuyr.easypanel.host/demo), el "Hola mundo 👋" con **"Base de datos: conectada"** (o **"sin conexion"** si todavía no creaste Postgres — la app abre igual; pasa a "conectada" cuando cargues las variables del paso 6.2).

---

## Listo — y ahora es automático

La app quedó en producción y el pipeline en marcha. De aquí en más el ciclo es:

**editas → `git push origin main` → EasyPanel construye y redespliega solo**

Para una app nueva, repites del paso 1 al 6 cambiando el nombre del repo y el `Dockerfile`.

---

*Manual de alta de apps en EasyPanel · ejemplo `miorg/miapp` · PHP 8.3 · PostgreSQL · Docker*
