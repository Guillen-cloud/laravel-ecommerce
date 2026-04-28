@extends('layouts.admin')

@section('title', $mode === 'create' ? 'Nuevo producto' : 'Editar producto')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">{{ $mode === 'create' ? 'Nuevo producto' : 'Editar producto' }}</h1>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ $mode === 'create' ? route('admin.productos.store') : route('admin.productos.update', $product) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select" required>
                            @foreach(['available', 'paused', 'sold_out'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $product->status ?: 'available') === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Descripcion</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" class="form-control" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">URL de imagen</label>
                        <input type="text" name="image" value="{{ old('image', $product->image) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marca</label>
                        <select name="brand_id" class="form-select" required>
                            <option value="">Seleccionar</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Categoria</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Seleccionar</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Industria</label>
                        <select name="industry_id" class="form-select" required>
                            <option value="">Seleccionar</option>
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}" @selected(old('industry_id', $product->industry_id) == $industry->id)>{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-light border">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
