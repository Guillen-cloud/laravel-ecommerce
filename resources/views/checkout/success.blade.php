@extends('layouts.app')

@section('title', 'Pedido confirmado | ElectroStore')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
            <h1 class="h4 mb-2">Pedido confirmado</h1>
            <p class="text-muted">Tu pedido #{{ $order->id }} fue creado correctamente.</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Seguir comprando</a>
                <a href="{{ route('invoices.download', $order) }}" class="btn btn-primary">Descargar factura PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection
