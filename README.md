# Laravel Ecommerce

Proyecto ecommerce academico en Laravel + MySQL (Laragon), orientado a arquitectura MVC con vistas Blade, AJAX, Bootstrap y facturacion PDF con DomPDF.

## Stack

- Laravel 10
- PHP 8.1+
- MySQL
- Bootstrap 5
- Vite
- DomPDF

## Estado actual

- Base de datos ecommerce completa en migraciones.
- Catalogo publico implementado:
    - Home comercial.
    - Listado con filtros AJAX.
    - Detalle de producto con stock por sucursal.
- Base de factura PDF por orden.
- Documentacion de avance en `docs/bitacora-desarrollo.md` y `docs/scrum-backlog.md`.

## Puesta en marcha

1. Instalar dependencias PHP:
    - `composer install`
2. Instalar dependencias frontend:
    - `npm install`
3. Configurar variables:
    - Copiar `.env.example` a `.env` y ajustar conexion MySQL.
4. Crear estructura de BD y datos semilla:
    - `php artisan migrate:fresh --seed`
5. Iniciar desarrollo:
    - `php artisan serve`
    - `npm run dev`

## Rutas principales

- `/` home
- `/productos` catalogo
- `/productos/{product}` detalle
- `/facturas/{order}/pdf` descarga factura PDF base
