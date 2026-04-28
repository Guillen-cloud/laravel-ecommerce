@extends('layouts.admin')

@section('title', 'Admin Productos | ElectroStore')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Productos</h1>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">Nuevo producto</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Categoria</th>
                        <th>Industria</th>
                        <th class="text-end">Precio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->brand->name ?? 'N/D' }}</td>
                            <td>{{ $product->category->name ?? 'N/D' }}</td>
                            <td>{{ $product->industry->name ?? 'N/D' }}</td>
                            <td class="text-end">Bs {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->status }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.productos.edit', $product) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form method="POST" action="{{ route('admin.productos.destroy', $product) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Eliminar este producto?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Sin productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection
