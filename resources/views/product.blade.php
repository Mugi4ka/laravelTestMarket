@extends('layouts.master')

@section('title', 'Товар')

@section('content')
    <h1>{{ $skus->product->__('name') }}</h1>
    <h2>{{ $skus->product->category->name }}</h2>
    <p>Цена: <b>{{ $skus->price }} ₽</b></p>
    @isset($skus->product->properties)
        @foreach($skus->propertyOptions as $propertyOption)
            <h4>{{ $propertyOption->property->name }}: {{ $propertyOption->name }}</h4>
        @endforeach
    @endisset
    <img src="{{Storage::url($skus->product->image)}}">
    <p>{{ $skus->product->description }}</p>
    @if($skus->isAvailable())
        <form action="{{route('basket-add', $skus->product)}}" method="POST">
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
        <form action="{{ route('subscription', $skus) }}" method="POST">
            <input type="text" name="email">
            <button type="submit">Отправить</button>
            @csrf
        </form>
    @endif
@endsection
