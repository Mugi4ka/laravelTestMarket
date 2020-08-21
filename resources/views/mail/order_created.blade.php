<p>
    Уважаемый {{ $name }},
</p>
<p>
    @lang('mail.order_created.your_order') {{ $fullSum }} создан
</p>
<table>
    <tbody>
    @foreach($order->products as $product)
        <td><span class="badge">{{ $product->countInOrder }}</span>
            <div class="btn-group form-inline">
                <form action="{{ route('basket-remove', $product) }}" method="POST">
                    <button type="submit" class="btn btn-danger" href="">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
                    @csrf
                </form>
                <form action="{{ route('basket-add', $product) }}" method="POST">
                    <button type="submit" class="btn btn-success" href="">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    @csrf
                </form>
            </div>
        </td>
        <td>{{ $product->price }} {{ \App\Services\CurrencyConversion::getCurrencySymbol() }}₽</td>
        <td>{{ $product->getPriceForCount() }} ₽</td>
    @endforeach
    </tbody>
</table>