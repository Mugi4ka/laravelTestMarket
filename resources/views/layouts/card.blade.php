<div class="col-md-3">
    <div class="card-wrap thumbnail">
        <div class="labels">
            @if($sku->product->isNew())
                <span class="badge badge-success">@lang('main.properties.new')</span>
            @endif
            @if($sku->product->isRecommend())
                <span class="badge badge-warning">@lang('main.properties.recommend')</span>
            @endif
            @if($sku->product->isHit())
                <span class="badge badge-danger">@lang('main.properties.hit')</span>
            @endif
        </div>
        <a href="{{ route('sku', [isset($category) ? $category->code : $sku->product->category->code, $sku->product->code, $sku->id]) }}"><img src="{{ Storage::url($sku->product->image) }}" alt="{{ $sku->product->__('name') }}"></a>
        <div class="caption text-left">
            <h3 class="text-center">{{ $sku->product->__('name') }}</h3>
            @isset($sku->product->properties)
                @foreach($sku->propertyOptions as $propertyOption)
                    <h6>{{ $propertyOption->property->name }}: {{ $propertyOption->name }}</h6>
                @endforeach
            @endisset
            <p>Доступное количество: {{ $sku->count }}</p>
            <p>
            <form class="text-center" action="{{ route('basket-add', $sku) }}" method="POST">
                @if($sku->isAvailable())
                    <button type="submit" class="btn btn-primary" role="button">@lang('main.add_to_basket')</button>
                @else
                    @lang('main.not_available')
                @endif
                <a href="{{ route('sku', [isset($category) ? $category->code : $sku->product->category->code, $sku->product->code, $sku->id]) }}"
                   class="btn btn-default"
                   role="button">@lang('main.more')</a>
                @csrf
            </form>
            </p>
            <p class="text-right">Цена: <b>{{ $sku->price }} {{ $currencySymbol }}</b></p>
        </div>
    </div>
</div>