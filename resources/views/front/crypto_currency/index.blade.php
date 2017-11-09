@extends('front.layout')

@section('main')

<section class="crypto-currency-abm">
    <h1>
        Crypto_currency Index
    </h1>
    <a href='{!!url("cryptoCurrency")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> New</a>
    <br>
    <br>
    <div class = "info-results">
        <div class="results">
            <table>
                <thead>
                    <th>Nombre</th>
                    <th>Alias</th>
                    <th>Imagen</th>
                    <th>Imagen2</th>
                    <th>Valor Dólar</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach($crypto_currencies as $crypto_currency)
                    <tr>
                        <td>{!!$crypto_currency->name!!}</td>
                        <td>{!!$crypto_currency->alias!!}</td>
                        <td>{!!$crypto_currency->image!!}</td>
                        <td><img width="25" height="25" src="../images/{!!$crypto_currency->image!!}" alt="{!!$crypto_currency->name!!}"></td>
                        <td>{!!$crypto_currency->usd_value!!}</td>
                        <td>
                            <a href = "cryptoCurrency/{!!$crypto_currency->id!!}/delete" ><i class = 'fa fa-trash'> delete</i></a>
                            <a href = 'cryptoCurrency/{!!$crypto_currency->id!!}/edit'><i class = 'fa fa-edit'> edit</i></a>
                            <a href = 'cryptoCurrency/{!!$crypto_currency->id!!}' disabled="" ><i class = 'fa fa-eye'> info</i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $crypto_currencies->render() !!}
        </div>
    </div>

</section>
@endsection