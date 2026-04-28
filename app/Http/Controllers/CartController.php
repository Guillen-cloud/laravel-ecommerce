<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getCart($request);

        return view('cart.index', [
            'items' => $cart['items'],
            'total' => $cart['total'],
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $validated['quantity'] ?? 1;
        $product = Product::findOrFail($validated['product_id']);

        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $item = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
            ]);
            $item->quantity = ($item->quantity ?? 0) + $quantity;
            $item->save();

            $cartData = $this->getDatabaseCart($request, $cart);

            return response()->json([
                'message' => 'Producto agregado al carrito.',
                'cart' => $cartData,
            ]);
        }

        $cart = $this->getCart($request);
        $items = $cart['items'];

        if (isset($items[$product->id])) {
            $items[$product->id]['quantity'] += $quantity;
        } else {
            $items[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $quantity,
            ];
        }

        $cart = $this->recalculateCart($items);
        $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Producto agregado al carrito.',
            'cart' => $cart,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $validated['product_id'])
                ->first();

            if (!$item) {
                return response()->json(['message' => 'Producto no encontrado en el carrito.'], 404);
            }

            $item->quantity = $validated['quantity'];
            $item->save();

            return response()->json([
                'message' => 'Cantidad actualizada.',
                'cart' => $this->getDatabaseCart($request, $cart),
            ]);
        }

        $cart = $this->getCart($request);
        $items = $cart['items'];

        if (!isset($items[$validated['product_id']])) {
            return response()->json(['message' => 'Producto no encontrado en el carrito.'], 404);
        }

        $items[$validated['product_id']]['quantity'] = $validated['quantity'];

        $cart = $this->recalculateCart($items);
        $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Cantidad actualizada.',
            'cart' => $cart,
        ]);
    }

    public function remove(Request $request, int $productId)
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->delete();

            return response()->json([
                'message' => 'Producto eliminado del carrito.',
                'cart' => $this->getDatabaseCart($request, $cart),
            ]);
        }

        $cart = $this->getCart($request);
        $items = $cart['items'];

        if (isset($items[$productId])) {
            unset($items[$productId]);
        }

        $cart = $this->recalculateCart($items);
        $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Producto eliminado del carrito.',
            'cart' => $cart,
        ]);
    }

    public function summary(Request $request)
    {
        return response()->json($this->getCart($request));
    }

    private function getCart(Request $request): array
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

            return $this->getDatabaseCart($request, $cart);
        }

        $cart = $request->session()->get('cart');

        if (!$cart || !isset($cart['items'])) {
            return [
                'items' => [],
                'total' => 0,
                'count' => 0,
            ];
        }

        return $this->recalculateCart($cart['items']);
    }

    private function getDatabaseCart(Request $request, Cart $cart): array
    {
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
        foreach ($items as $item) {
            $mapped[$item->product_id] = [
                'product_id' => $item->product_id,
                'name' => $item->product?->name ?? 'Producto',
                'price' => (float) ($item->product?->price ?? 0),
                'quantity' => (int) $item->quantity,
            ];
        }

        return $this->recalculateCart($mapped);
    }

    private function recalculateCart(array $items): array
    {
        $total = 0;
        $count = 0;

        foreach ($items as $productId => $item) {
            $quantity = (int) $item['quantity'];
            $price = (float) $item['price'];
            $items[$productId]['subtotal'] = $price * $quantity;
            $total += $items[$productId]['subtotal'];
            $count += $quantity;
        }

        return [
            'items' => $items,
            'total' => $total,
            'count' => $count,
        ];
    }
}
