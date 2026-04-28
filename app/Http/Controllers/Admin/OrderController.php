<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'status', 'paymentMethod'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'customer', 'status', 'paymentMethod']);
        $statuses = OrderStatus::orderBy('name')->get();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status_id' => ['required', 'integer', 'exists:order_statuses,id'],
        ]);

        $order->update(['status_id' => $validated['status_id']]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado de pedido actualizado.');
    }
}
