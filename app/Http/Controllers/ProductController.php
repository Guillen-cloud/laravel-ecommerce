<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['brand', 'category']);

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->integer('brand_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $products = $query->orderBy('name')->paginate(12)->withQueryString();

        if ($request->boolean('ajax')) {
            return response()->json([
                'html' => view('products.partials.grid', compact('products'))->render(),
                'total' => $products->total(),
            ]);
        }

        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'brands', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['brand', 'category', 'industry', 'branches']);

        return view('products.show', compact('product'));
    }
}
