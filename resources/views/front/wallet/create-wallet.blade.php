@extends('front.layout')

@section('main')

   <section id="create-wallet">

       <form action="createWallet" method="get">
           <br>
           <h1 aria-live="polite">Crear nueva billetera</h1>
           <h4>Ingresa una contraseña</h4>
           <div class="input-group">
               <input id="password" name="password" type="password" placeholder="No vayas a olvidarla!">
               <button id="pwd-visible-btn" onclick="showHidePassword()" type="button">Mostrar/Esconder</button>
           </div>
           <button id="create-wallet-btn" type="submit">Crear</button>
           <p>Esta contraseña <em> encripta </em> tu llave privada. No se utiliza para generar las llaves. <strong>Vas a necesitar esta contraseña más tu llave privada para acceder a tu cuenta.</strong></p>
           <br>
       </form>
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
