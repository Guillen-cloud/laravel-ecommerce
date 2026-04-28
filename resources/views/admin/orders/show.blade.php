@extends('layouts.admin')

@section('title', 'Pedido | Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Pedido #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6 mb-2">Cliente</h2>
                <p class="mb-1">{{ $order->customer->first_name ?? '' }} {{ $order->customer->last_name ?? '' }}</p>
                <p class="mb-1">{{ $order->customer->email ?? 'N/D' }}</p>
                <p class="mb-0">{{ $order->customer->phone ?? 'N/D' }}</p>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body">
                <h2 class="h6 mb-2">Actualizar estado</h2>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf
                    @method('PUT')
                    <div class="d-flex gap-2">
                        <select name="status_id" class="form-select">
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" @selected($order->status_id === $status->id)>{{ $status->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body">
                <h2 class="h6 mb-2">Factura</h2>
                <a href="{{ route('invoices.download', $order) }}" class="btn btn-outline-primary">Descargar PDF</a>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6 mb-3">Items</h2>
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item->product->name ?? 'Producto' }} x {{ $item->quantity }}</span>
                            <span>Bs {{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="text-end mt-3 fw-semibold">Total: Bs {{ number_format($order->total, 2) }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
