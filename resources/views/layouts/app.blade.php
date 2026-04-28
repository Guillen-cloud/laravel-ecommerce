<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tienda Online')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">ElectroStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Productos</a>
                    </li>
                    @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.productos.index') }}">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.stock.index') }}">Stock</a>
                        </li>
                    @endif
                </ul>
                @php
                    if (auth()->check()) {
                        $cartModel = \App\Models\Cart::where('user_id', auth()->id())->first();
                        $cartCount = $cartModel
                            ? $cartModel->items()->sum('quantity')
                            : 0;
                    } else {
                        $cartCount = collect(session('cart.items', []))->sum('quantity');
                    }
                @endphp
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-sm">
                        Carrito
                        <span id="cart-count" class="badge text-bg-primary ms-1">{{ $cartCount }}</span>
                    </a>
                    @if(auth()->check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-sm">Salir</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">Ingresar</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-dark btn-sm">Crear cuenta</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
