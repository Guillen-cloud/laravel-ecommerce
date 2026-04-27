@extends('layouts.app')

@section('title', 'Inicio | ElectroStore')

@section('content')
<div class="container">
    <section class="hero-banner rounded-4 p-4 p-lg-5 mb-4 text-white">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="display-6 fw-bold mb-3">Tecnología para tu hogar y tu trabajo</h1>
                <p class="mb-4">Descubre productos con entrega rápida, stock actualizado y precios competitivos.</p>
                <a href="{{ route('products.index') }}" class="btn btn-warning fw-semibold">Ver catálogo</a>
            </div>
            <div class="col-lg-5">
                <div class="bg-white text-dark rounded-3 p-3 shadow-sm">
                    <h2 class="h6 mb-3">Categorías destacadas</h2>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($categories as $category)
                            <span class="badge text-bg-light border">{{ $category->name }}</span>
                        @empty
                            <span class="text-muted small">Sin categorías cargadas.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Productos destacados</h2>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
        </div>

        <div class="row g-3">
            @forelse($featuredProducts as $product)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <span class="badge text-bg-primary-subtle text-primary-emphasis mb-2">{{ $product->category->name ?? 'General' }}</span>
                            <h3 class="h6 fw-semibold">{{ $product->name }}</h3>
                            <p class="small text-muted flex-grow-1">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold">Bs {{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-dark">Detalle</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">Aún no hay productos cargados.</div>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
