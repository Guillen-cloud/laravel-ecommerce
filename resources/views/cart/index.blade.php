@extends('layouts.app')

@section('title', 'Carrito | ElectroStore')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Tu carrito</h1>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">Seguir comprando</a>
    </div>

    <div id="cart-alerts"></div>

    @if(empty($items))
        <div class="alert alert-info">No tienes productos en el carrito.</div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            @foreach($items as $item)
                                <tr data-product-id="{{ $item['product_id'] }}">
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">
                                        <input type="number" min="1" class="form-control form-control-sm cart-qty" value="{{ $item['quantity'] }}">
                                    </td>
                                    <td class="text-end">Bs {{ number_format($item['price'], 2) }}</td>
                                    <td class="text-end cart-subtotal">Bs {{ number_format($item['subtotal'], 2) }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-danger cart-remove" type="button">Quitar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    <div class="text-end">
                        <p class="mb-1">Total</p>
                        <p class="h4 mb-0" id="cart-total">Bs {{ number_format($total, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Ir a checkout</a>
        </div>
    @endif
</div>
@endsection
