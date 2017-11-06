@foreach($cryptoCurrencies as $cryptoCurrency)
    <tr>
        <td>{{ $cryptoCurrency->name }}</td>
        <td>{{ $cryptoCurrency->alias }}</td>
        <td>{{ $cryptoCurrency->image }}</td>
        <td>{{ $cryptoCurrency->usd_value }}</td>
        <td>
            <input type="checkbox" name="seen" value="{{ $cryptoCurrency->id }}" {{ is_null($cryptoCurrency->ingoing) ?  'disabled' : 'checked'}}>
        </td>
        <td><a class="btn btn-success btn-xs btn-block" href="{{ route('crypto_currencies.show', [$cryptoCurrency->id]) }}" role="button" title="@lang('Mostrar')"><span class="fa fa-eye"></span></a></td>
        <td><a class="btn btn-warning btn-xs btn-block" href="{{ route('crypto_currencies.edit', [$cryptoCurrency->id]) }}" role="button" title="@lang('Editar')"><span class="fa fa-edit"></span></a></td>
        <td><a class="btn btn-danger btn-xs btn-block" href="{{ route('crypto_currencies.destroy', [$cryptoCurrency->id]) }}" role="button" title="@lang('Borrar')"><span class="fa fa-remove"></span></a></td>
    </tr>
@endforeach

