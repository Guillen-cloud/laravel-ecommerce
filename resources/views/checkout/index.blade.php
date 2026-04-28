@extends('layouts.app')

@section('title', 'Checkout | ElectroStore')

@section('content')
<div class="container">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h5 mb-3">Datos del cliente</h1>
                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">CI</label>
                                <input type="text" name="ci" value="{{ old('ci') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefono</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Direccion</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Metodo de pago</label>
                                <select name="payment_method_id" class="form-select" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}" @selected(old('payment_method_id') == $method->id)>{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 d-grid">
                            <button class="btn btn-primary" type="submit">Confirmar pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">Resumen</h2>
                    @foreach($cart['items'] as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div class="fw-semibold">{{ $item['name'] }}</div>
                                <small class="text-muted">Cantidad: {{ $item['quantity'] }}</small>
                            </div>
                            <span>Bs {{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>Bs {{ number_format($cart['total'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
