@extends('layouts.admin')

@section('title', 'Cliente | Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Cliente</h1>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6">{{ $customer->first_name }} {{ $customer->last_name }}</h2>
                <p class="mb-1"><strong>CI:</strong> {{ $customer->ci }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $customer->email }}</p>
                <p class="mb-1"><strong>Telefono:</strong> {{ $customer->phone }}</p>
                <p class="mb-0"><strong>Direccion:</strong> {{ $customer->address }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6 mb-3">Pedidos</h2>
                <ul class="list-group list-group-flush">
                    @forelse($customer->orders as $order)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">Pedido #{{ $order->id }}</div>
                                <small class="text-muted">{{ $order->status->name ?? 'N/D' }}</small>
                            </div>
                            <span>Bs {{ number_format($order->total, 2) }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Sin pedidos registrados.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
