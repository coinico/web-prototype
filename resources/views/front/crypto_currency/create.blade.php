@extends('front.layout')

@section('main')
<section class="crypto-currency-abm">
    <h1>
        Crear una Crypto-Moneda
    </h1>
    <a href="{!!url('cryptoCurrency')!!}" class = 'btn btn-danger'><i class="fa fa-home"></i> Índice de Crypto-monedas</a>
    <br>
    <form method = 'POST' action = '{!!url("cryptoCurrency")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="name">name</label>
            <input id="name" name = "name" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="alias">alias</label>
            <input id="alias" name = "alias" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="image">image</label>
            <input id="image" name = "image" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="usd_value">usd_value</label>
            <input id="usd_value" name = "usd_value" type="text" class="form-control">
        </div>
        <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Save</button>
    </form>
</section>
@endsection