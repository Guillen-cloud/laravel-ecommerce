<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['brand', 'category'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('home.index', compact('featuredProducts', 'categories'));
    }
}
