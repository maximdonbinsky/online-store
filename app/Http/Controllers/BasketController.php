<?php

namespace App\Http\Controllers;
use App\Models\Order;

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
        $result = $order->saveOrder($request->name, $request->phone);
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
        
        return redirect()->route('basket');
    }
}
