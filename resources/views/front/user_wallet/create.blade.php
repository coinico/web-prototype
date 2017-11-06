@extends('front.layout')

@section('main')

<div class = 'container'>
    <h1>
        Crear User Wallet
    </h1>
    <form method = 'get' action = '{!!url("userWallet")!!}'>
        <button class = 'btn blue'>Índice de billeteras de usuario</button>
    </form>
    <br>
    <form method = 'POST' action = '{!!url("userWallet")!!}'>
        <input type = 'hidden' name = '_token' value = '{{ Session::token() }}'>
        <div class="input-field col s6">
            <input id="balance" name = "balance" type="text" class="validate">
            <label for="balance">balance</label>
        </div>
        <button class = 'btn red' type ='submit'>Create</button>
    </form>
</div>
@endsection