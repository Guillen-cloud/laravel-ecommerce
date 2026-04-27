@extends('layouts.app')

@section('title', $product->name . ' | ElectroStore')

@section('content')
<div class="container">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h3 mb-3">{{ $product->name }}</h1>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge text-bg-light border">Marca: {{ $product->brand->name ?? 'N/D' }}</span>
                        <span class="badge text-bg-light border">Categoría: {{ $product->category->name ?? 'N/D' }}</span>
                        <span class="badge text-bg-light border">Industria: {{ $product->industry->name ?? 'N/D' }}</span>
                    </div>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h2 class="h6 text-muted mb-1">Precio</h2>
                    <p class="display-6 fw-bold mb-0">Bs {{ number_format($product->price, 2) }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">Stock por sucursal</h2>
                    <ul class="list-group list-group-flush">
                        @forelse($product->branches as $branch)
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>{{ $branch->name }}</span>
                                <span class="fw-semibold">{{ $branch->pivot->stock }} unid.</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">Sin stock asociado todavía.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="mt-3 d-grid">
                <button class="btn btn-primary" disabled>Agregar al carrito (siguiente sprint)</button>
            </div>
        </div>
    </div>
</div>
@endsection
