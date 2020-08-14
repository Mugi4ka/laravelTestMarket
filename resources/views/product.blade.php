@extends('layouts.master')

@section('title', 'Товар')

@section('content')
    <h1>{{ $product->name }}</h1>
    <h2>{{ $product->category->name }}</h2>
    <p>Цена: <b>{{ $product->price }} ₽</b></p>
    <img src="{{Storage::url($product->image)}}">
    <p>{{ $product->description }}</p>
    @if($product->isAvailable())
        <form action="{{route('basket-add', $product)}}" method="POST">
            <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
            @csrf
        </form>
    @else
        <p>Нет в продаже</p>
        <p>Уведомление о поступлении</p>
        @if($errors->get('email'))
        <div class="warning">
            {!! $errors->get('email')[0] !!}
        </div>
        @endif
        <form action="{{ route('subscription', $product) }}" method="POST">
            <input type="text" name="email">
            <button type="submit">Отправить</button>
            @csrf
        </form>
    @endif
@endsection
