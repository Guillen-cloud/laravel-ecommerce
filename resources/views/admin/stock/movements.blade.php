@extends('layouts.app')

@section('title', 'Movimientos de stock | ElectroStore')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Movimientos de stock</h1>
        <a href="{{ route('admin.stock.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Sucursal</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th class="text-end">Cantidad</th>
                        <th>Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                        <tr>
                            <td>{{ $movement->created_at }}</td>
                            <td>{{ $movement->branch->name ?? 'N/D' }}</td>
                            <td>{{ $movement->product->name ?? 'N/D' }}</td>
                            <td>{{ $movement->type === 'in' ? 'Entrada' : 'Salida' }}</td>
                            <td class="text-end">{{ $movement->quantity }}</td>
                            <td>{{ $movement->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Sin movimientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $movements->links() }}
    </div>
</div>
@endsection
