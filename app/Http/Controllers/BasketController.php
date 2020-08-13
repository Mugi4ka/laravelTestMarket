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

        if ($success) {
            session()->flash('success', 'Ваш заказ принят в обработку');
        } else {
            session()->flash('warning', 'Превышено количество имеющегося товара');
        }

        Order::eraseOrderSum();

        return redirect()->route('index');
    }

    public function basketPlace()
    {
        $basket = new Basket();

        $order = $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('warning', 'Превышено количество имеющегося товара');
            return redirect()->route('basket');
        }

        return view('order', compact('order'));
    }

    public function BasketAdd(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);

        if ($result) {
            session()->flash('success', $product->name . ' добавлен');
        } else {
            session()->flash('warning', $product->name . ' не доступен для заказа');
        }

        return redirect()->route('basket');
    }

    public function BasketRemove(Product $product)
    {

        (new Basket())->removeProduct($product);

        session()->flash('warning', $product->name . 'удалён');

        return redirect()->route('basket');

    }

}

