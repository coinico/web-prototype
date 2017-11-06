@extends('front.layout')

@section('main')

<section class="crypto-currency-abm">
    <h1>
        Mostrar Crypto-Moneda
    </h1>
    <br>
    <a href='{!!url("cryptoCurrency")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Índice de Crypto Monedas</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Campo</th>
            <th>Valor</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>Nombre</b> </td>
                <td>{!!$crypto_currency->name!!}</td>
            </tr>
            <tr>
                <td> <b>Alias</b> </td>
                <td>{!!$crypto_currency->alias!!}</td>
            </tr>
            <tr>
                <td> <b>Imagen</b> </td>
                <td>{!!$crypto_currency->image!!}</td>
            </tr>
            <tr>
                <td> <b>Valor Dólar</b> </td>
                <td>{!!$crypto_currency->usd_value!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection