# Bitacora de Desarrollo - Laravel Ecommerce

## Fecha

26-04-2026

## Sprint 1 - Incremento 1

### Objetivo

Levantar base funcional del frontend publico del ecommerce con enfoque MVC + AJAX + Bootstrap.

### Cambios aplicados

1. Rutas MVC de inicio y catalogo.
2. Controladores `HomeController` y `ProductController`.
3. Vistas Blade nuevas:
    - layout principal Bootstrap
    - home comercial
    - listado de productos
    - detalle de producto
    - parcial reutilizable del grid
4. Filtros de productos por busqueda, marca, categoria y rango de precio.
5. Respuesta AJAX en listado para actualizar grid sin recargar.
6. Estilos personalizados iniciales para look retail.
7. Integracion base de facturacion PDF con DomPDF.

### Estado funcional actual

- Inicio publico con productos destacados: OK.
- Catalogo con filtros AJAX: OK.
- Detalle de producto con stock por sucursal: OK.
- Factura PDF por orden (ruta y plantilla base): OK.
- Carrito y checkout: pendiente para siguiente incremento.

### Archivos clave modificados

- routes/web.php
- app/Http/Controllers/HomeController.php
- app/Http/Controllers/ProductController.php
- resources/views/layouts/app.blade.php
- resources/views/home/index.blade.php
- resources/views/products/index.blade.php
- resources/views/products/show.blade.php
- resources/views/products/partials/grid.blade.php
- resources/js/app.js
- resources/css/app.css
- app/Http/Controllers/InvoiceController.php
- resources/views/invoices/order.blade.php

### Notas tecnicas

- Se mantiene Laravel MVC como base de arquitectura.
- AJAX implementado con `fetch` para no acoplarse a librerias externas.
- Bootstrap cargado por CDN en layout base.
- DomPDF instalado para generacion de facturas en PDF.
