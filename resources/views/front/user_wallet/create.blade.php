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
    <form id="create-user-wallet" method = 'POST' action = '{!!url("userWallet")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="input-field col s6">
            <label for="available_balance">available_balance</label>
            <input id="available_balance" name = "available_balance" type="text" class="validate">
        </div>
        <div class="input-field col s6">
            <label for="book_balance">book_balance</label>
            <input id="book_balance" name = "book_balance" type="text" class="validate">
        </div>
        <div>
            <input type='hidden' id="crypto_currency_id" name="crypto_currency_id" value=""/>
            <label for="crypto_currency">currency</label>
            <select form="create-user-wallet" class="input-field col s6" id="crypto_currency">
                <option value="" selected="selected"></option>
                <?php foreach ($cryptoCurrencies as $key => $value) { ?>
                <option value="<?php echo $key;?>"><?php echo $value;?></option>
                <?php } ?>
            </select>
        </div>
        <button class = 'btn red' type ='submit'>Create</button>
    </form>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function(){
        $("#crypto_currency").change(function() {
            var studentNmae = $('option:selected', this).attr('value');
            $('#crypto_currency_id').val(studentNmae);
        });
    });
</script>

@stop
