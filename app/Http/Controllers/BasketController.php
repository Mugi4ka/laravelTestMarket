<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Http\Requests\AddCouponRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
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
        $basket = new Basket();

        if ($basket->getOrder()->hasCoupon()
            && !$basket->getOrder()->coupon->availableForUse()
        ) {
            $basket->clearCoupon();
            session()->flash('warning',
                'Купон был использован');
            return redirect()->route('basket');

        }

        $email = Auth::check() ? Auth::user()->email : $request->email;

        if ($basket->saveOrder($request->name, $request->phone,
            $email)
        ) {
            session()->flash('success', 'Ваш заказ принят в обработку');
        } else {
            session()->flash('warning',
                'Превышено количество имеющегося товара');
        }

        return redirect()->route('index');
    }

    public function basketPlace()
    {
        $basket = new Basket();

        $order = $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('warning',
                'Превышено количество имеющегося товара');
            return redirect()->route('basket');
        }

        return view('order', compact('order'));
    }

    public function basketAdd(Sku $skus)
    {
        $basket = new Basket(true);
        $result = $basket->addSku($skus);

        if ($result) {
            session()->flash('success', $skus->product->name.' добавлен');
        } else {
            session()->flash('warning',
                $skus->product->name.' не доступен для заказа');
        }

        return redirect()->route('basket');
    }

    public function basketRemove(Sku $skus)
    {

        (new Basket())->removeSku($skus);

        session()->flash('warning', $skus->product->name.'удалён');

        return redirect()->route('basket');

    }

    public function setCoupon(AddCouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->coupon)->first();
        if ($coupon->availableForUse()) {
            (new Basket())->setCoupon($coupon);
            session()->flash('success', 'Купон был добавлен');
        } else {
            session()->flash('warning', 'Купон не может быть использован');
        }

        return redirect()->route('basket');

    }

}

