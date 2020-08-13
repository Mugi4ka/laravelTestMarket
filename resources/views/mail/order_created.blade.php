<p>
    Уважаемый {{ $name }},
</p>
<p>
    Ваш заказ на сумму {{ $fullSum }} создан
</p>
<table>
    <tbody>
    @foreach($order->products as $product)
        <td><span class="badge">{{ $product->pivot->count }}</span>
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
        <td>{{ $product->price }} ₽</td>
        <td>{{ $product->getPriceForCount() }} ₽</td>
    @endforeach
    </tbody>
</table>