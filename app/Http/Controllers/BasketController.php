<?php

namespace App\Http\Controllers;
use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function basket()
    {
        $order = (new Basket())->getOrder();

        return view('basket', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $email = Auth::check() ? Auth::user()->email : $request->email;

        $success = (new Basket())->saveOrder($request->name, $request->phone, $email);

        if($success) {
            session()->flash('success', __('basket.order_processing'));
        }
        else {
            session()->flash('successRemove', __('basket.not_available_full'));
        }

        Order::eraseOrderPrice();

        return redirect()->route('index');
    }

    public function placeOrder()
    {
        $basket = new Basket();
        $order = $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('successRemove', __('basket.not_available_full'));
            return redirect()->route('basket');
        }
        return view('placeOrder', compact('order'));
    }

    public function basketAdd(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);

        if ($result) {
            session()->flash('successAdd', __('basket.the_product') . $product->name . __('basket.added_cart'));
        }
        else {
            session()->flash('successRemove', __('basket.the_product') . $product->name . __('basket.not_available_full'));
        }

        return redirect()->route('basket');
    }

    public function basketRemove(Product $product)
    {
        (new Basket())->removeProduct($product);

        session()->flash('successRemove', __('basket.the_product') . $product->name . __('basket.removed_cart'));

        return redirect()->route('basket');
    }
}
