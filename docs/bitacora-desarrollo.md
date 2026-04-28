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

## Sprint 1 - Incremento 2

### Objetivo

Implementar carrito completo con AJAX y flujo de checkout basico para generar orden.

### Cambios aplicados

1. Controladores nuevos: `CartController` y `CheckoutController`.
2. Rutas de carrito, checkout y confirmacion.
3. Vistas: carrito, checkout y confirmacion de pedido.
4. AJAX para agregar, actualizar y eliminar productos del carrito.
5. Contador de carrito en navbar.

### Estado funcional actual

- Carrito AJAX: OK.
- Checkout y creacion de orden: OK.
- Factura PDF descargable desde confirmacion: OK.

## Sprint 1 - Incremento 3

### Objetivo

Persistir el carrito por usuario autenticado en las tablas `carts` y `cart_items`.

### Cambios aplicados

1. Carrito persistente para usuarios autenticados.
2. Merge automatico de carrito en sesion a base de datos al autenticarse.
3. Checkout lee carrito persistido y limpia items en base de datos al confirmar pedido.
4. Contador de carrito usa base de datos para usuarios autenticados.

### Estado funcional actual

- Carrito persistente por usuario: OK.
- Checkout consume carrito persistido: OK.

## Sprint 2 - Incremento 1

### Objetivo

Implementar panel admin CRUD de productos.

### Cambios aplicados

1. Controlador admin para productos.
2. Rutas admin para CRUD.
3. Vistas de listado y formulario.
4. Enlace admin en navbar.

### Estado funcional actual

- Admin CRUD productos: OK.

## Sprint 2 - Incremento 2

### Objetivo

Implementar gestion de stock por sucursal y registro de movimientos.

### Cambios aplicados

1. Controlador admin de stock con entradas y salidas.
2. Rutas admin para gestion y movimientos.
3. Vista de registro de stock y listado de movimientos.
4. Enlace de stock en navbar.

### Estado funcional actual

- Stock por sucursal actualizado con movimientos: OK.

## Sprint 2 - Incremento 3

### Objetivo

Agregar filtros de stock actual y proteger rutas admin con permisos.

### Cambios aplicados

1. Tabla de stock actual con filtros por sucursal y producto.
2. Middleware admin para restringir acceso al panel.
3. Rutas admin protegidas con middleware.

### Estado funcional actual

- Stock actual con filtros: OK.
- Rutas admin protegidas por rol: OK.

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
