<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $cart = $this->getCartData($request);

        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('checkout.index', [
            'cart' => $cart,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function store(Request $request)
    {
        $cart = $this->getCartData($request);

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito esta vacio.');
        }

        $validated = $request->validate([
            'ci' => ['required', 'string', 'max:20'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100'],
            'address' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
        ]);

        $role = Role::firstOrCreate(['name' => 'customer']);

        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'password' => Hash::make(Str::random(12)),
                'role_id' => $role->id,
            ]
        );

        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'ci' => $validated['ci'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'user_id' => $user->id,
            ]
        );

        $status = OrderStatus::firstOrCreate(['name' => 'pending']);

        $order = Order::create([
            'customer_id' => $customer->id,
            'payment_method_id' => $validated['payment_method_id'],
            'status_id' => $status->id,
            'total' => $cart['total'],
        ]);

        foreach ($cart['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        if (auth()->check()) {
            $cartModel = Cart::where('user_id', auth()->id())->first();
            if ($cartModel) {
                $cartModel->items()->delete();
            }
        } else {
            $request->session()->forget('cart');
        }

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        $order->load(['items.product', 'paymentMethod', 'status']);

        return view('checkout.success', [
            'order' => $order,
        ]);
    }

    private function getCartData(Request $request): array
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $sessionCart = $request->session()->get('cart');

            if ($sessionCart && isset($sessionCart['items'])) {
                foreach ($sessionCart['items'] as $item) {
                    $cartItem = CartItem::firstOrNew([
                        'cart_id' => $cart->id,
                        'product_id' => $item['product_id'],
                    ]);
                    $cartItem->quantity = ($cartItem->quantity ?? 0) + (int) $item['quantity'];
                    $cartItem->save();
                }
                $request->session()->forget('cart');
            }

            $items = $cart->items()->with('product')->get();
            $mapped = [];
            $total = 0;
            $count = 0;

            foreach ($items as $item) {
                $price = (float) ($item->product?->price ?? 0);
                $quantity = (int) $item->quantity;
                $subtotal = $price * $quantity;
                $mapped[$item->product_id] = [
                    'product_id' => $item->product_id,
                    'name' => $item->product?->name ?? 'Producto',
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
                $count += $quantity;
            }

            return [
                'items' => $mapped,
                'total' => $total,
                'count' => $count,
            ];
        }

        return $request->session()->get('cart', [
            'items' => [],
            'total' => 0,
            'count' => 0,
        ]);
    }
}
