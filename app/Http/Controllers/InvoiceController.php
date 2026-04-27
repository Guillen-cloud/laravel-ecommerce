<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        $order->load(['customer', 'items.product', 'paymentMethod', 'status']);

        $pdf = Pdf::loadView('invoices.order', [
            'order' => $order,
        ])->setPaper('a4');

        return $pdf->download('factura-orden-' . $order->id . '.pdf');
    }
}
