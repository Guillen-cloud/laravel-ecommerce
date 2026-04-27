<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        .header { margin-bottom: 14px; }
        .title { font-size: 22px; font-weight: bold; color: #0f3f85; margin: 0; }
        .meta { margin: 0; color: #4b5563; }
        .card { border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #e5e7eb; padding: 7px; text-align: left; }
        th { background: #f9fafb; }
        .right { text-align: right; }
        .total { font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">Factura Electronica</p>
        <p class="meta">ElectroStore | Orden #{{ $order->id }}</p>
        <p class="meta">Fecha: {{ optional($order->created_at)->format('d/m/Y H:i') }}</p>
    </div>

    <div class="card">
        <strong>Cliente:</strong>
        {{ $order->customer->first_name ?? '' }} {{ $order->customer->last_name ?? '' }}
        <br>
        <strong>Email:</strong> {{ $order->customer->email ?? 'N/D' }}
        <br>
        <strong>Metodo de pago:</strong> {{ $order->paymentMethod->name ?? 'N/D' }}
        <br>
        <strong>Estado:</strong> {{ $order->status->name ?? 'N/D' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="right">Cantidad</th>
                <th class="right">Precio</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Producto' }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">Bs {{ number_format($item->price, 2) }}</td>
                    <td class="right">Bs {{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="right total">Total: Bs {{ number_format($order->total, 2) }}</p>
</body>
</html>
