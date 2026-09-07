# Alta de una app nueva en EasyPanel

> Manual paso a paso: de cero a un **"hola mundo"** en producción con **deploy automático desde GitHub**.
> Seguimos **una sola app de ejemplo** de punta a punta — PHP sin framework, PostgreSQL, estructura MVC, todo construido con Docker.

**Stack del ejemplo:** `PHP 8.3` · sin framework · MVC · PostgreSQL · Docker · EasyPanel · GitHub

> 🧭 **La app de ejemplo.** Todo el manual usa un proyecto llamado `miapp` del usuario/organización `miorg`. Donde veas esos nombres, reemplazalos por los tuyos. El flujo es idéntico para cualquier stack: cambia solo el contenido del `Dockerfile` y del esqueleto que pedís en el paso 2.

## Índice

1. [Crear el repositorio en GitHub](#1-crear-el-repositorio-en-github)
2. [Armar el esqueleto con Claude](#2-armar-el-esqueleto-con-claude)
3. [Crear la aplicación en EasyPanel](#3-crear-la-aplicación-en-easypanel)
4. [Conectar deploy automático: deploy key + webhook](#4-conectar-deploy-automático-deploy-key--webhook)
5. [Todo se construye con Docker](#5-todo-se-construye-con-docker)
6. [Primer deploy: ver el "hola mundo"](#6-primer-deploy-ver-el-hola-mundo)

---

## 1. Crear el repositorio en GitHub

El repo es la fuente de verdad: EasyPanel va a construir y desplegar exactamente lo que esté en la rama que elijas (usamos `main`).

### Opción A — desde la web

1. Entrá a [github.com/new](https://github.com/new).
2. Nombre: `miapp`. Visibilidad: **Private** (el deploy key funciona igual con repos privados).
3. Tildá **Add a README** y dejá el `.gitignore` en **nada aún** (lo agregamos nosotros). Create repository.

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

> 🔑 Anotá la **URL SSH** del repo: `git@github.com:miorg/miapp.git`. La vas a necesitar en el paso 4 para conectar EasyPanel.

---

## 2. Armar el esqueleto con Claude

En vez de crear archivos a mano, le pedís a Claude que genere el esqueleto completo describiendo el **stack** y las **convenciones**. Cuanto más precisa la especificación, menos correcciones después.

### Prompt plantilla (copiar y completar)

Reemplazá lo que está entre `«…»`. Este ejemplo ya viene cargado con el stack del manual:

```text
Armá el esqueleto base de una aplicación web lista para deploy con Docker.

STACK
- Lenguaje: PHP «8.3», sin framework (vanilla).
- Arquitectura: MVC (Model - View - Controller) con un front controller
  único en public/index.php y un router propio simple.
- Autoload: Composer PSR-4, namespace raíz "App\" apuntando a app/.
- Base de datos: PostgreSQL, acceso vía PDO (pdo_pgsql).
- Config por variables de entorno (getenv), nunca hardcodeada.

ESTRUCTURA DE CARPETAS
  public/          -> único directorio expuesto por el servidor web
  app/Core/        -> Router, Database (conexión PDO)
  app/Controllers/ -> HomeController con acción index
  app/Views/       -> home.php
  config/          -> lectura de env
  Dockerfile       -> imagen php:8.3-apache con docroot en /public
  composer.json    -> autoload PSR-4

REQUISITOS
- La ruta "/" debe responder un "Hola mundo" e indicar si la conexión
  a Postgres está OK (sin romper si la DB no está disponible todavía).
- Código PHP 8+ con declare(strict_types=1) y tipado.
- Comentarios breves en español.

Devolveme cada archivo con su ruta y su contenido completo.
```

> 💡 **Qué variar por proyecto.** Las 4 palancas que cambian el esqueleto: **lenguaje/versión** · **framework o vanilla** · **base de datos** · **arquitectura**. Todo lo demás (Docker, deploy) queda igual.

### Estructura resultante

```text
miapp/
├── public/
│   └── index.php          # front controller (única puerta de entrada)
├── app/
│   ├── Core/
│   │   ├── Router.php      # enruta method + path → controlador
│   │   └── Database.php    # conexión PDO a Postgres
│   ├── Controllers/
│   │   └── HomeController.php
│   └── Views/
│       └── home.php
├── config/
│   └── config.php
├── composer.json
├── Dockerfile
└── .gitignore
```

Revisá lo generado, hacé commit y push a `main`:

```bash
git add .
git commit -m "scaffold: esqueleto MVC PHP + Docker"
git push -u origin main
```

---

## 3. Crear la aplicación en EasyPanel

En EasyPanel un **Proyecto** agrupa servicios (tu app + su base de datos). Dentro creás un servicio de tipo **App**.

1. En el dashboard, **Create Project** → nombre `miapp`.
2. Dentro del proyecto, **+ Service** → elegí **App**.
3. Ponele nombre al servicio, ej. `web`. Queda como `miapp_web` a nivel interno.
4. Guardá. Todavía no despliega nada — falta conectar la fuente (paso 4) y definir el build (paso 5).

> 🗄️ El servicio de **Postgres** lo agregamos en el paso 6, cuando conectamos la base. Por ahora alcanza con el servicio **App**.

---

## 4. Conectar deploy automático: deploy key + webhook

Dos piezas trabajan juntas:

- **Deploy key** — clave SSH que le da a EasyPanel permiso de *lectura* sobre tu repo privado para poder clonarlo.
- **Webhook** — aviso que GitHub le manda a EasyPanel en cada `push`, para que reconstruya y redespliegue solo.

### 4.1 · Apuntar EasyPanel al repo

1. En el servicio `web`, pestaña **Source** → elegí **GitHub** (modo Deploy Key, no la GitHub App).
2. Repository: `git@github.com:miorg/miapp.git` · Branch: `main`.
3. EasyPanel genera y muestra una **Deploy Key** (clave pública SSH). Copiala entera.

### 4.2 · Cargar la deploy key en GitHub

1. En el repo → **Settings → Deploy keys → Add deploy key**.
2. Title: `easypanel`. Key: pegá la clave que copiaste.
3. **Dejá SIN tildar "Allow write access"** — EasyPanel solo necesita leer. Add key.

> 🔒 **Solo lectura.** No habilites escritura en la deploy key. EasyPanel clona y construye; nunca necesita escribir en tu repo.

### 4.3 · Registrar el webhook en GitHub

1. En EasyPanel, dentro de **Source** / **Deployments**, copiá la **Webhook URL** que ofrece el servicio.
2. En el repo → **Settings → Webhooks → Add webhook**.
3. Payload URL: la de EasyPanel · Content type: `application/json`.
4. Events: **Just the push event** · Active: ✓. Add webhook.

GitHub manda un ping de prueba: en la lista de webhooks debería aparecer un **✓ verde** (Recent Deliveries → response 200). Si aparece rojo, revisá que la URL esté completa.

> 🔁 A partir de acá: cada `git push origin main` dispara el webhook → EasyPanel clona con la deploy key → construye la imagen Docker → redespliega. Cero pasos manuales.

---

## 5. Todo se construye con Docker

EasyPanel puede usar Nixpacks o buildpacks, pero acá mandamos nosotros: build method **Dockerfile**. Así el entorno de producción es idéntico al que definimos, sin sorpresas.

### Elegir el build en EasyPanel

1. Servicio `web` → pestaña **Build** → método **Dockerfile**.
2. Dockerfile path: `Dockerfile` (raíz del repo). Guardá.

### El `Dockerfile` de la app

Imagen oficial PHP con Apache. Instalamos la extensión de Postgres, movemos el docroot a `/public` (nadie ve el resto del código) e instalamos dependencias con Composer.

```dockerfile
FROM php:8.3-apache

# 1. Extensiones PHP para PostgreSQL
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# 2. Docroot en /public + reescritura de URLs
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite

# 3. Composer + dependencias
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 80
```

> 🌐 **Puerto.** La imagen expone el `80`. En la pestaña **Domains** de EasyPanel, mapeá tu dominio al puerto `80` del servicio (EasyPanel resuelve el TLS solo con Let's Encrypt).

### Piezas clave del esqueleto

El front controller, único punto de entrada expuesto:

```php
<?php
// public/index.php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();
$router->get('/', [App\Controllers\HomeController::class, 'index']);
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
```

La conexión a Postgres, tolerante a que la DB aún no exista:

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
        try {
            $dsn = sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                getenv('DB_HOST'), getenv('DB_PORT') ?: '5432', getenv('DB_NAME')
            );
            return new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException) {
            // La app arranca igual aunque la DB no esté lista
            return null;
        }
    }
}
```

El controlador y la vista del "hola mundo":

```php
<?php
// app/Controllers/HomeController.php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class HomeController
{
    public function index(): void
    {
        $db = Database::connect();
        $dbEstado = $db instanceof \PDO ? 'conectada ✅' : 'sin conexión ⚠️';
        require __DIR__ . '/../Views/home.php';
    }
}
```

```php
<!-- app/Views/home.php -->
<!doctype html>
<html lang="es">
<meta charset="utf-8">
<title>miapp</title>
<body style="font-family:system-ui;padding:3rem">
  <h1>Hola mundo 👋</h1>
  <p>Base de datos: <?= htmlspecialchars($dbEstado) ?></p>
</body>
</html>
```

---

## 6. Primer deploy: ver el "hola mundo"

### 6.1 · Agregar Postgres

1. En el proyecto `miapp` → **+ Service → Postgres**. Nombre: `db`.
2. EasyPanel te muestra las **Credentials**: host interno, puerto, usuario, contraseña y database. El host interno suele ser el nombre del servicio, ej. `miapp_db`.

### 6.2 · Conectar la app a la DB con variables de entorno

En el servicio `web` → pestaña **Environment**, cargá las variables que lee `Database.php`. Usá los valores internos del servicio Postgres:

| Variable   | Valor (ejemplo)              |
|------------|------------------------------|
| `DB_HOST`  | `miapp_db`                   |
| `DB_PORT`  | `5432`                       |
| `DB_NAME`  | `miapp`                      |
| `DB_USER`  | `postgres`                   |
| `DB_PASS`  | `«el que generó EasyPanel»`  |

> 🔌 Los servicios del mismo proyecto se ven por red interna usando el **nombre del servicio** como host — no expongas Postgres a internet.

### 6.3 · Desplegar

1. En el servicio `web`, tocá **Deploy** (o simplemente hacé un `git push` — el webhook lo dispara).
2. Mirá los **Logs / Deployments**: verás el build de Docker (FROM, extensiones, composer install) y luego el contenedor arriba.
3. Abrí el **dominio** asignado en la pestaña Domains.

> ✅ Deberías ver **"Hola mundo 👋"** y la línea **"Base de datos: conectada ✅"**. Si dice *sin conexión ⚠️*, revisá las variables de entorno del paso 6.2.

---

## Listo — y ahora es automático

La app quedó en producción y el pipeline en marcha. De acá en más el ciclo es:

**editás → `git push origin main` → EasyPanel construye y redespliega solo**

Para una app nueva, repetís del paso 1 al 6 cambiando el nombre del repo y el `Dockerfile`.

---

*Manual de alta de apps en EasyPanel · ejemplo `miorg/miapp` · PHP 8.3 · PostgreSQL · Docker*
