# Sistema Web Administrativo - Labor Social

Modulo base de autenticacion para la tesis:
"Implementacion de aplicacion movil para el registro y control de actividades de labor social de la U.E.P. Instituto Elena de Bueno".

## Stack

- PHP 8+
- Laravel (estructura de controlador, modelo, rutas, vistas y migracion)
- MySQL con XAMPP
- Bootstrap 5

## Credenciales iniciales

- Correo: `admin@labor.social`
- Contrasena: `Admin12345`

## Base de datos

1. Crea la base de datos ejecutando `database.sql` en phpMyAdmin.
2. Verifica que el archivo `.env` tenga estos valores:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=labor_social_db
DB_USERNAME=root
DB_PASSWORD=
```

## Archivos principales

- Conexion Eloquent: `config/database.php`
- Controlador de autenticacion: `app/Http/Controllers/AuthController.php`
- Modelo de usuario: `app/Models/User.php`
- Rutas web: `routes/web.php`
- Vistas: `resources/views/auth/login.blade.php`, `resources/views/auth/register.blade.php`, `resources/views/dashboard.blade.php`
- Script SQL: `database.sql`
- Migracion: `database/migrations/2026_04_07_000000_create_usuarios_table.php`

## Seguridad aplicada

- Hash de contrasenas con `Hash::make()`
- Validacion del lado del servidor
- Normalizacion de correo y cedula
- Proteccion frente a SQL Injection usando Eloquent
- Regeneracion de sesion al iniciar y cerrar sesion
- Limitacion basica de intentos de inicio de sesion
- El rol `administrador` no se expone en el registro publico

## Nota importante

Este repositorio contiene el modulo funcional de autenticacion y su estructura en estilo Laravel, pero todavia no incluye un proyecto Laravel completo con archivos base como `artisan`, `composer.json`, `public/`, `bootstrap/` y `vendor/`.

Para ejecutarlo directamente como aplicacion Laravel, debes integrar estos archivos dentro de una instalacion base de Laravel o generar un proyecto Laravel nuevo y copiar este modulo.
