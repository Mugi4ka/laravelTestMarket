@extends('layouts.master')

@section('title', 'Товар')

@section('content')
    <div class="col-md-12">
        <div class="col-md-6">
            <img src="{{Storage::url($skus->product->image)}}">
        </div>
        <div class="col-md-6">
            <h1>{{ $skus->product->__('name') }}</h1>
            <h5>{{ $skus->product->category->name }}</h5>
            <h2>Цена: <b>{{ $skus->price }} ₽</b></h2>
            <div class="properties text-left">
                @isset($skus->product->properties)
                    @foreach($skus->propertyOptions as $propertyOption)
                        <h4>{{ $propertyOption->property->name }}: {{ $propertyOption->name }}</h4>
                    @endforeach
                @endisset
            </div>


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
        </div>
    </div>
@endsection
