@extends('layouts.master')

@section('title', 'Товар')

@section('content')
        <h1>{{ $product }}</h1>
        <h2>Мобильные телефоны</h2>
        <p>Цена: <b>71990 ₽</b></p>
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg">
        <p>Отличный продвинутый телефон с памятью на 64 gb</p>
        <form action="#" method="POST">
            <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
                @csrf
        </form>
@endsection
