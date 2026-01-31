# 📦 Plantilla MVC PHP

Plantilla base para proyectos web usando el patrón MVC (Modelo-Vista-Controlador) en PHP.

## 🚀 Características

- ✅ Arquitectura MVC clara y organizada
- ✅ Enrutamiento dinámico
- ✅ Conexión a base de datos MySQL con PDO
- ✅ Autoload con Composer (PSR-4)
- ✅ Sistema de envío de emails con PHPMailer
- ✅ Ejemplo de modelo y controlador de Usuarios
- ✅ Sistema de sesiones

## 📋 Requisitos

- PHP 8.0 o superior
- MySQL 5.7 o superior
- Composer
- Servidor web (Apache/Nginx) o PHP integrado

## ⚙️ Instalación

### 1. Clonar o descargar el proyecto

```bash
git clone <tu-repositorio>
cd PlantillaMVC
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar la base de datos

1. Importa el archivo `database/db.sql` en tu servidor MySQL
2. Edita `config/config.ini` y actualiza los datos de conexión:

```ini
[database]
host = "localhost"
dbname = "mi_proyecto"        # CAMBIA ESTO
user = "root"                 # CAMBIA ESTO
password = "tu_password"      # CAMBIA ESTO
charset = "utf8mb4"
```

### 4. Configurar el envío de emails (opcional)

Si necesitas enviar emails, crea un archivo `config/.env`:

```env
SMTP_HOST=smtp.gmail.com
SMTP_USER=tu_correo@gmail.com
SMTP_PASS=tu_app_password
SMTP_PORT=587
SMTP_SECURE=tls
SMTP_DEBUG=0
```

**Nota:** Para Gmail, necesitas crear una [App Password](https://support.google.com/accounts/answer/185833).

### 5. Configurar el servidor web

#### Opción A: Servidor integrado de PHP (desarrollo)

```bash
cd public
php -S localhost:8000
```

Accede a: `http://localhost:8000`

#### Opción B: Apache

Configura el DocumentRoot hacia la carpeta `public/`

```apache
<VirtualHost *:80>
    DocumentRoot "C:/ruta/a/PlantillaMVC/public"
    ServerName miapp.local

    <Directory "C:/ruta/a/PlantillaMVC/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## 📁 Estructura del Proyecto

```
PlantillaMVC/
├── app/
│   ├── Controllers/      # Controladores de la aplicación
│   │   └── UsuariosController.php (ejemplo)
│   ├── Models/          # Modelos de datos
│   │   └── Usuario.php (ejemplo)
│   └── Views/           # Vistas HTML/PHP
│       ├── layout/
│       └── usuarios/ (ejemplo)
├── config/
│   └── config.ini       # Configuración de BD
├── core/
│   ├── Controller.php   # Controlador base
│   └── Router.php       # Sistema de rutas
├── database/
│   └── db.sql          # Script de base de datos
├── public/
│   └── index.php       # Punto de entrada
├── tools/
│   ├── Conexion.php    # Gestión de conexión BD
│   ├── Hash.php        # Utilidades de hashing
│   └── Mailer.php      # Envío de emails
├── vendor/             # Dependencias de Composer
└── composer.json
```

## 🎯 Uso

### Crear un nuevo controlador

1. Crea un archivo en `app/Controllers/MiController.php`:

```php
<?php
namespace App\Controllers;

use Core\Controller;

class MiController extends Controller
{
    public function index(): void
    {
        $this->vista("mi_vista/index");
    }

    public function metodo(): void
    {
        // Tu lógica aquí
        $datos = ["mensaje" => "Hola Mundo"];
        $this->vista("mi_vista/metodo", $datos);
    }
}
```

2. Accede a: `http://localhost:8000/mi/index` o `http://localhost:8000/mi/metodo`

### Crear un modelo

1. Crea un archivo en `app/Models/MiModelo.php`:

```php
<?php
namespace App\Models;

use Tools\Conexion;

class MiModelo
{
    private ?int $id = null;
    private ?string $nombre = null;

    // Getters, setters y métodos de BD...

    public static function obtenerTodos(): array
    {
        $bd = Conexion::getConexion();
        $stmt = $bd->query("SELECT * FROM mi_tabla");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
```

### Crear vistas

Crea archivos PHP en `app/Views/mi_vista/`:

```php
<!DOCTYPE html>
<html>
<head>
    <title>Mi Vista</title>
</head>
<body>
    <h1><?= $datos['mensaje'] ?? 'Sin mensaje' ?></h1>
</body>
</html>
```

## 🔒 Seguridad

- **Contraseñas:** Usa `password_hash()` y `password_verify()` para gestionar contraseñas
- **SQL Injection:** Usa siempre consultas preparadas con PDO
- **Sesiones:** La plantilla incluye gestión básica de sesiones
- **XSS:** Escapa siempre la salida con `htmlspecialchars()` o similares

## 📝 Personalización

### Cambiar nombre del proyecto

1. Actualiza `composer.json`:
   - Cambia `name`, `description` y `authors`
2. Actualiza el nombre de la base de datos en:
   - `config/config.ini`
   - `database/db.sql`

### Eliminar el ejemplo de usuarios

Si no necesitas el sistema de usuarios, elimina:

- `app/Controllers/UsuariosController.php`
- `app/Models/Usuario.php`
- `app/Views/usuarios/`

## 🐛 Solución de problemas

### Error de conexión a la base de datos

Verifica que:

1. MySQL esté corriendo
2. Los datos en `config/config.ini` sean correctos
3. La base de datos exista y esté importada

### Error de rutas

Verifica que:

1. El archivo `.htaccess` esté en `public/`
2. El módulo `mod_rewrite` de Apache esté habilitado
3. Estés accediendo desde la carpeta `public/`

## 📄 Licencia

Este proyecto es una plantilla de código abierto. Puedes usarla libremente en tus proyectos.

## 🤝 Contribuir

Siéntete libre de mejorar esta plantilla y compartir tus cambios.

---

**¡Buena suerte con tu proyecto! 🚀**
