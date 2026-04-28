<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-dark" style="background:#b30f0f;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.productos.index') }}">Admin ElectroStore</a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-white small">{{ auth()->user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-2 bg-white border-end min-vh-100 p-3">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-dark btn-sm">Productos</a>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-dark btn-sm">Clientes</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark btn-sm">Pedidos</a>
                    <a href="{{ route('admin.stock.index') }}" class="btn btn-outline-dark btn-sm">Stock</a>
                    <a href="{{ route('admin.stock.movements') }}" class="btn btn-outline-dark btn-sm">Movimientos</a>
                </div>
            </aside>
            <main class="col-lg-10 p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
