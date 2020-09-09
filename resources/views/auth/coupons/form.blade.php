@extends('auth.layouts.master')

@isset($coupon)
    @section('title', 'Редактировать купон ' . $coupon->name)
@else
    @section('title', 'Создать купон')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($coupon)
            <h1>Редактировать купон</h1>
        @else
            <h1>Добавить купон</h1>
        @endisset

        <form method="POST" enctype="multipart/form-data"
              @isset($coupon)
              action="{{ route('coupons.update', $coupon) }}"
              @else
              action="{{ route('coupons.store') }}"
                @endisset
        >
            <div>
                @isset($coupon)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Код: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'code'])
                        <input type="text" class="form-control" name="code" id="code"
                               value="{{ old('code', isset($coupon) ? $coupon->code : null) }}">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label"> Номинал: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'value'])
                        <input type="text" class="form-control" name="value" id="value"
                               value="{{ old('value', isset($coupon) ? $coupon->value : null) }}">
                    </div>
                </div>
                <br>

                <div class="input-group row">
                    <label for="currency" class="col-sm-2 col-form-label">Валюта: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'currency_id'])
                        <select name="currency_id" id="currency_id" class="form-control">
                            <option value="">Без валюты</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}"
                                        @isset($coupon)
                                        @if($coupon->currency_id == $currency->id)
                                        selected
                                        @endif
                                        @endisset
                                >{{ $currency->code }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <br>

                @foreach(['type' => 'Абсолютное значение','only_once' => 'Купон может быть использован только один раз'] as $field => $title)
                    <div class="input-group row">
                        <label for="price" class="col-sm-2 col-form-label">{{$title}}: </label>
                        <div class="col-sm-1">
                            <input type="checkbox" class="form-control" name="{{$field}}" id="{{$field}}"

                                   @if(isset($product) && $product->$field === 1)
                                   checked="checked"
                                    @endif
                            >
                        </div>
                    </div>
                    <br>
                @endforeach

                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label"> Использовать до: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'expired_at'])
                        <input type="date" class="form-control" name="expired_at" id="expired_at"
                               value="@if(isset($coupon) && !is_null($coupon->expired_at)){{ $coupon->expired_at->format('Y-m-d') }}@endif">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'description'])
                        <textarea name="description" id="description" cols="72"
                                  rows="7">@isset($coupon){{ $coupon->description }}@endisset</textarea>
                    </div>
                </div>
                <br>

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection