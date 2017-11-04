@extends('front.layout')

@section('main')

   <section id="wallet-created">

       <br>
       <h1 aria-live="polite">Esta es tu billetera!</h1>
       <h4>Clave privada</h4>
       <input id="privateKey" name="privateKey" type="text" value="{{ $privateKey }}" readonly="readonly">
       <h4>Contraseña</h4>
       <input id="password" name="password" type="password" value="{{ $password }}" readonly="readonly">
       <button id="pwd-visible-btn" onclick="showHidePassword()" type="button">Mostrar/Esconder</button>

   </section>

@endsection

@section('scripts')
    <script>
        function showHidePassword() {
            var pwdField = $("#password");
            var type = pwdField.attr('type');
            pwdField.attr('type', type === "text" ? "password": "text");
        }
    </script>
@stop
