<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class MainController extends Controller
{
    public function index(ProductsFilterRequest $request) {
        $queryProducts = Product::with('category');
        if ($request->filled('price_from')) {
            $queryProducts->where('price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $queryProducts->where('price', '<=', $request->price_to);
        }
        foreach (['hit', 'new', 'recommend'] as $field) {
            if ($request->has($field)) {
                $queryProducts->$field();
            }
        }

        $products = $queryProducts->paginate(3)->withPath('?' . $request->getQueryString());
        return view('index', compact('products'));
    }

    public function categories() {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function category($code) {
        $category = Category::where('code', $code)->first();
        return view('category', compact('category'));
    }

    public function product($category, $productCode) {
        $product = Product::withTrashed()->byCode($productCode)->first();
        return view('product', compact('product'));
    }
}
