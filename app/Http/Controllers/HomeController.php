<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('active_categories', 3600, function () {
            return ProductCategory::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('name', 'asc')
                ->get();
        });

        $products = Cache::remember('active_products_with_categories', 1800, function () {
            return Product::with('category')
                ->where('is_active', true)
                ->get();
        });

        return view('site.pages.home', compact('categories', 'products'));
    }
}
