@extends('front.layout')

@section('main')

<section class="crypto-currency-abm">
    <h1>
        Show crypto_currency
    </h1>
    <br>
    <a href='{!!url("crypto_currency")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Crypto_currency Index</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>name</b> </td>
                <td>{!!$crypto_currency->name!!}</td>
            </tr>
            <tr>
                <td> <b>alias</b> </td>
                <td>{!!$crypto_currency->alias!!}</td>
            </tr>
            <tr>
                <td> <b>image</b> </td>
                <td>{!!$crypto_currency->image!!}</td>
            </tr>
            <tr>
                <td> <b>usd_value</b> </td>
                <td>{!!$crypto_currency->usd_value!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection