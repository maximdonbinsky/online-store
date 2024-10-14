<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function basket() {
        $orderId = session('orderId');
        if(!is_null($orderId)){
            $order = Order::findOrFail($orderId);
        }
        return view('basket', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $orderId = session('orderId');
        if(is_null($orderId)) {
            return redirect()->route('index');
        }
        $order = Order::find($orderId);
        $success = $order->saveOrder($request->name, $request->phone);
        if($success) {
            session()->flash('success', 'Ваш заказ принят в обработку!');
        }
        else {
            session()->flash('warning', 'Произошла ошибка!');
        }

        Order::eraseOrderPrice();

        return redirect()->route('index');
    }

    public function placeOrder() {
        $orderId = session('orderId');
        if(is_null($orderId)) {
            return redirect()->route('index');
        }
        $order = Order::find($orderId);
        return view('placeOrder', compact('order'));
    }

    public function basketAdd($productId)
    {
        $orderId = session('orderId');
        if(is_null($orderId)){
            $order = Order::create()->id;
            session(['orderId'=>$order]);
        }
        else{
            $order = Order::find($orderId);
        }

        if($order->products->contains($productId)) {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            $pivotRow->count++;
            $pivotRow->update();
        }
        else {
            $order->products()->attach($productId);
        }

        if(Auth::check()) {
            $order->user_id = Auth::id();
            $order->save();
        }

        $product = Product::find($productId);

        Order::changeFullPrice($product->price);

        session()->flash('successAdd', 'Товар, ' . $product->name . ', добавлен в корзину!');

        return redirect()->route('basket');
    }

    public function basketRemove($productId)
    {
        $orderId = session('orderId');
        if(is_null($orderId)){
            return view('basket', compact('order'));
        }
        $order = Order::find($orderId);

        if($order->products->contains($productId)) {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            if($pivotRow->count < 2) {
                $order->products()->detach($productId);
            }
            else {
            $pivotRow->count--;
            $pivotRow->update();
            }
        }
        $product = Product::find($productId);

        Order::changeFullPrice(-$product->price);

        session()->flash('successRemove', 'Товар, ' . $product->name . ', удален из карзины!');

        return redirect()->route('basket');
    }
}
