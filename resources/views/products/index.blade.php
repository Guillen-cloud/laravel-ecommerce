@extends('layouts.app')

@section('title', 'Catálogo | ElectroStore')

@section('content')
<div class="container">
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 fw-bold mb-3">Filtros</h2>
                    <form id="catalog-filters" action="{{ route('products.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Buscar</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Ej. Samsung, laptop...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Marca</label>
                            <select name="brand_id" class="form-select">
                                <option value="">Todas</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected((string) request('brand_id') === (string) $brand->id)>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="category_id" class="form-select">
                                <option value="">Todas</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label">Precio mín.</label>
                                <input type="number" step="0.01" min="0" name="min_price" value="{{ request('min_price') }}" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Precio máx.</label>
                                <input type="number" step="0.01" min="0" name="max_price" value="{{ request('max_price') }}" class="form-control">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Aplicar</button>
                            <a href="{{ route('products.index') }}" class="btn btn-light border">Limpiar</a>
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        <section class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">Catálogo de productos</h1>
                <span id="catalog-total" class="badge text-bg-light border">{{ $products->total() }} resultados</span>
            </div>

            <div id="catalog-grid" data-endpoint="{{ route('products.index') }}">
                @include('products.partials.grid', ['products' => $products])
            </div>
        </section>
    </div>
</div>
@endsection
