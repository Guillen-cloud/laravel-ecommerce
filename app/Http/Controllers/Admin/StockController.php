<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        $summaryQuery = DB::table('product_branch')
            ->join('products', 'products.id', '=', 'product_branch.product_id')
            ->select([
                'products.id as product_id',
                'products.name as product_name',
                DB::raw('SUM(product_branch.stock) as total_stock'),
            ])
            ->groupBy('products.id', 'products.name')
            ->orderBy('products.name');

        if ($request->filled('summary_product_id')) {
            $summaryQuery->where('products.id', $request->integer('summary_product_id'));
        }

        $stockSummary = $summaryQuery->paginate(10, ['*'], 'summary_page');
        $stockSummary->appends($request->query());

        $stockQuery = DB::table('product_branch')
            ->join('products', 'products.id', '=', 'product_branch.product_id')
            ->join('branches', 'branches.id', '=', 'product_branch.branch_id')
            ->select([
                'product_branch.stock',
                'products.name as product_name',
                'branches.name as branch_name',
                'products.id as product_id',
                'branches.id as branch_id',
            ])
            ->orderBy('branches.name')
            ->orderBy('products.name');

        if ($request->filled('branch_id')) {
            $stockQuery->where('branches.id', $request->integer('branch_id'));
        }

        if ($request->filled('product_id')) {
            $stockQuery->where('products.id', $request->integer('product_id'));
        }

        $stockEntries = $stockQuery->paginate(15);
        $stockEntries->appends($request->query());

        return view('admin.stock.index', compact('branches', 'products', 'stockEntries', 'stockSummary'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => ['required', 'integer', 'exists:branches,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $branch = Branch::findOrFail($validated['branch_id']);
        $product = Product::findOrFail($validated['product_id']);

        $currentStock = $branch->products()
            ->where('products.id', $product->id)
            ->first()?->pivot->stock ?? 0;

        $newStock = $validated['type'] === 'in'
            ? $currentStock + $validated['quantity']
            : $currentStock - $validated['quantity'];

        if ($newStock < 0) {
            return redirect()->back()->with('error', 'Stock insuficiente para esta salida.');
        }

        $branch->products()->syncWithoutDetaching([
            $product->id => ['stock' => $newStock],
        ]);

        StockMovement::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.stock.index')
            ->with('success', 'Movimiento registrado. Nuevo stock: ' . $newStock);
    }

    public function movements()
    {
        $movements = StockMovement::with(['product', 'branch'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.stock.movements', compact('movements'));
    }
}
