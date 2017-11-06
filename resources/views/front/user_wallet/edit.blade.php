@extends('front.layout')

@section('main')

<div class = 'container'>
    <h1>
        Edit userwallet
    </h1>
    <form method = 'get' action = '{!!url("userWallet")!!}'>
        <button class = 'btn blue'>userwallet Index</button>
    </form>
    <br>
    <form method = 'POST' action = '{!! url("userWallet")!!}/{!!$userWallet->
        id!!}/update'> 
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="input-field col s6">
            <input id="balance" name = "balance" type="text" class="validate" value="{!!$userWallet->
            balance!!}"> 
            <label for="balance">balance</label>
        </div>
        <button class = 'btn red' type ='submit'>Update</button>
    </form>
</div>
@endsection