@extends('auth.layouts.master')

@section('title', 'Категория ' . $coupon->code)

@section('content')
    <div class="col-md-12">
        <h1>Категория {{ $coupon->code }}</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $coupon->id }}</td>
            </tr>
            <tr>
                <td>Код</td>
                <td>{{ $coupon->code }}</td>
            </tr>
            <tr>
                <td>Описание</td>
                <td>{{ $coupon->description }}</td>
            </tr>
            @isset($coupon->currency)
                <tr>
                    <td>Номинал</td>
                    <td>{{ $coupon->value }}</td>
                </tr>
                <tr>
                    <td>Валюта</td>
                    <td>{{ $coupon->currency->code }}</td>
                </tr>
            @endisset
            <tr>
                <td>Абсолютное значение</td>
                <td>@if($coupon->isAbsolute()) Да @else Нет @endif</td>
            </tr>
            <tr>
                <td>Ипользовать один раз</td>
                <td>@if($coupon->isOnlyOnce()) Да @else Нет @endif</td>
            </tr>
            <tr>
                <td>Ипользован</td>
                <td>{{$coupon->orders->count()}}</td>
            </tr>
            @isset($coupon->expired_at)
                <tr>
                    <td>Действителен до:</td>
                    <td>{{$coupon->expired_at->format('d-m-y')}}</td>
                </tr>
            @endisset
            </tbody>
        </table>
    </div>
@endsection