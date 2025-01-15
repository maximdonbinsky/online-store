<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Currency;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use function Symfony\Component\String\s;

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
        $product = Product::withTrashed()->byCode($productCode)->firstOrFail();
        return view('product', compact('product'));
    }

    public function subscribe(SubscriptionRequest $request, Product $product)
    {
        Subscription::create([
            'email' => $request->email,
            'product_id' => $product->id
        ]);
        return redirect()->back()->with('success', __('main.email_specified'));
    }

    public function changeLocale($locale)
    {
        $availableLocale = ['en', 'ru'];
        if (!in_array($locale, $availableLocale)) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();
    }

    public function changeCurrency($currencyCode)
    {
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        session(['currency' => $currency->code]);
        return redirect()->back();
    }
}
