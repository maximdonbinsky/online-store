<?php

namespace App\Http\Controllers;
use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function basket()
    {
        $order = (new Basket())->getOrder();

        return view('basket', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $success = (new Basket())->saveOrder($request->name, $request->phone);

        if($success) {
            session()->flash('success', 'Ваш заказ принят в обработку!');
        }
        else {
            session()->flash('successRemove', 'Товар недоступен для заказа в полном объеме!');
        }

        Order::eraseOrderPrice();

        return redirect()->route('index');
    }

    public function placeOrder()
    {
        $basket = new Basket();
        $order = $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('successRemove', 'Товар недоступен для заказа в полном объеме!');
            return redirect()->route('basket');
        }
        return view('placeOrder', compact('order'));
    }

    public function basketAdd(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);

        if ($result) {
            session()->flash('successAdd', 'Товар, ' . $product->name . ', добавлен в корзину!');
        }
        else {
            session()->flash('successRemove', 'Товар, ' . $product->name . ', недоступен для заказа!');
        }

        return redirect()->route('basket');
    }

    public function basketRemove(Product $product)
    {
        (new Basket())->removeProduct($product);

        session()->flash('successRemove', 'Товар, ' . $product->name . ', удален из карзины!');

        return redirect()->route('basket');
    }
}
