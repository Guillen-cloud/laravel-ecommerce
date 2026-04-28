@extends('layouts.app')

@section('title', 'Gestion de stock | ElectroStore')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Gestion de stock por sucursal</h1>
        <a href="{{ route('admin.stock.movements') }}" class="btn btn-outline-secondary">Ver movimientos</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.stock.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Sucursal</label>
                        <select name="branch_id" class="form-select" required>
                            <option value="">Seleccionar</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Producto</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">Seleccionar</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tipo</label>
                        <select name="type" class="form-select" required>
                            <option value="in">Entrada</option>
                            <option value="out">Salida</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" min="1" name="quantity" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Descripcion</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Registrar movimiento</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h2 class="h6 mb-3">Stock actual</h2>
            <form method="GET" class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Sucursal</label>
                    <select name="branch_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @selected((string) request('branch_id') === (string) $branch->id)>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Producto</label>
                    <select name="product_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected((string) request('product_id') === (string) $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                        <a href="{{ route('admin.stock.index') }}" class="btn btn-light border">Limpiar</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sucursal</th>
                            <th>Producto</th>
                            <th class="text-end">Stock</th>
                            <th class="text-end">Ajuste rapido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockEntries as $entry)
                            <tr>
                                <td>{{ $entry->branch_name }}</td>
                                <td>{{ $entry->product_name }}</td>
                                <td class="text-end">{{ $entry->stock }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.stock.adjust') }}" class="d-inline-flex gap-2">
                                        @csrf
                                        <input type="hidden" name="branch_id" value="{{ $entry->branch_id }}">
                                        <input type="hidden" name="product_id" value="{{ $entry->product_id }}">
                                        <input type="number" min="0" name="stock" value="{{ $entry->stock }}" class="form-control form-control-sm" style="max-width: 120px;">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Guardar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Sin registros para estos filtros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $stockEntries->links() }}
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h2 class="h6 mb-3">Stock total por producto</h2>
            <form method="GET" class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Producto</label>
                    <select name="summary_product_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected((string) request('summary_product_id') === (string) $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                        <a href="{{ route('admin.stock.index') }}" class="btn btn-light border">Limpiar</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-end">Stock total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockSummary as $summary)
                            <tr>
                                <td>{{ $summary->product_name }}</td>
                                <td class="text-end">{{ $summary->total_stock }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">Sin registros disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $stockSummary->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
