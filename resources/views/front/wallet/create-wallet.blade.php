@extends('front.layout')

@section('main')

   <section id="create-wallet">

       <br>
       <h1 aria-live="polite">Crear nueva billetera</h1>
       <h4>Ingresa una contraseña</h4>
       <div class="input-group">
           <input id="password" name="password" type="password">
           <button id="pwd-visible-btn" onclick="showHidePassword()">Mostrar/Esconder</button>

           <input id="seed" name="seed" type="text" readonly="readonly">
           <button id="pwd-visible-btn" onclick="generateRandomSeed()">Generar seed aleatoria</button>

           <input id="private-key" name="private-key" type="text" readonly="readonly">

       </div>
       <button id="create-wallet-btn" onclick="createWalletPrivateKey()">Crear</button>
       <br>

   </section>

@endsection

@section('scripts')

    <script type="text/javascript" src="{{ asset('js/wallet/lightwallet.js') }}"></script>

    <script>

        function showHidePassword() {
            var pwdField = $("#password");
            var type = pwdField.attr('type');
            pwdField.attr('type', type === "text" ? "password": "text");
        }

        function generateRandomSeed() {
            var seed = lightwallet.keystore.generateRandomSeed();
            $("#seed").val(seed);
        }

        function createWalletPrivateKey() {

            var password1 = "mypassword";
            var password2 = "mypassword";
            var seed1 = "case hire near rocket raccoon bar put glide million interest scatter muffin";
            var seed2 = "sell pipe hungry inject damage elder bus dice other valley aerobic lunar";
            var hdPathString = "m/0'/0'/0'";

            var opts = {
                password: password1,
                seedPhrase:seed1,
                hdPathString: hdPathString
            };

            lightwallet.keystore.createVault(opts, function(err, vault) {

                vault.keyFromPassword(password1, function (err, pwDerivedKey) {
                    if (err) throw err;

                    var keystore = new lightwallet.keystore(seed1, pwDerivedKey, hdPathString);
                    console.log("pwDerivedKey1. ! "+pwDerivedKey);

                    keystore.generateNewAddress(pwDerivedKey);
                    var address = keystore.getAddresses()[0];
                    var prv_key = keystore.exportPrivateKey(address, pwDerivedKey);
                    console.log('address and key: ', address, prv_key);
                });

            });

            var opts2 = {
                password: password2,
                seedPhrase:seed2,
                hdPathString: hdPathString
            };
            lightwallet.keystore.createVault(opts2, function(err, vault) {

                vault.keyFromPassword(password2, function (err, pwDerivedKey) {
                    if (err) throw err;

                    var keystore = new lightwallet.keystore(seed2, pwDerivedKey, hdPathString);
                    console.log("pwDerivedKey1. ! "+pwDerivedKey);

                    keystore.generateNewAddress(pwDerivedKey);
                    var address = keystore.getAddresses()[0];
                    var prv_key = keystore.exportPrivateKey(address, pwDerivedKey);
                    console.log('address and key: ', address, prv_key);
                });

            });
        }
    </script>

@stop
