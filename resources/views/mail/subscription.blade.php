Уважаемый клиент, товар {{ $sku->__('name') }} появился в наличии.

<a href="{{ route('sku', [$sku->product->category->code, $sku->code]) }}">@lang('mail.subscription.more_info')</a>