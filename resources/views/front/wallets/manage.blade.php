@extends('front.layout')

@section('main')

<section id="manage-wallet" class="panel">

   <input type="hidden" id="result-message" value="{{$message}}">

   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:35%; text-align: center">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div id="modaldata" class="modal-body" style="text-align: center">
            </div>
         </div>
      </div>
   </div>

    <div class="modal fade" id="deposit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog order_book_trade_bid" role="document">
            <div class="modal-content order_book_trade_bid">
                <div class="modal-header">
                    <h4 class="modal-title" id="tradeModalTitle"><img width="20px" src="/images/{{$userWallet->currency->type === "currency"? "".$userWallet->currency->image : "tokens/".$userWallet->currency->image}}" /> Depositar fondos</h4>
                </div>
                <div class="modal-body">
                    <img width="36%" src="/images/wallets/qr_code.png">
                    0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61</br>
                    <div1 class="modal-body-info-chiquit">Información meramente visual. Para realizar un depósito virtual, presione el botón "VIRTUAL".</div1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="depositarVirtual()">Virtual</button>
                </div>
            </div>
        </div>
    </div>

  <form id="deposit-form" action="{{ url("userWallet/$userWallet->id/deposit") }}" method="GET">

       <div class="modal fade" id="deposit-modal-virtual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog order_book_trade_bid" role="document">
             <div class="modal-content order_book_trade_bid">
                   <div class="modal-header">
                      <h4 class="modal-title" id="tradeModalTitle"><img width="20px" src="/images/{{$userWallet->currency->type === "currency"? "".$userWallet->currency->image : "tokens/".$userWallet->currency->image}}" /> Depositar fondos</h4>
                   </div>
                   <div class="modal-body">
                       <div class="input-group">
                           <label class="label-hola" for="modal-trade-cantidad">Cantidad</label>
                           <input id="modal-trade-cantidad" name="cantidad" type="text" placeholder="0.00000000" class="input-hola input-left" required>
                       </div>
                       <div class="input-group">
                           <label class="label-hola" for="modal-trade-memo">Memo</label>
                           <input id="modal-trade-memo" name="memo" type="text" placeholder="Ingresa una descripción." value="" class="input-hola" required>
                       </div>
                   </div>
                   <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <button id="confirm-trade-modal" type="submit" class="btn btn-primary">Confirmar</button>
                   </div>
             </div>
          </div>
       </div>
   </form>

   <form id="withdraw-form" action="{{ url("userWallet/$userWallet->id/withdraw") }}" method="GET">
   <div class="modal fade" id="withdraw-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog order_book_trade_bid" role="document">
         <div class="modal-content order_book_trade_bid">
               <div class="modal-header">
                   <h4 class="modal-title" id="tradeModalTitle"><img width="20px" src="/images/{{$userWallet->currency->type === "currency"? "".$userWallet->currency->image : "tokens/".$userWallet->currency->image}}" /> Retirar fondos</h4>
               </div>
             <div class="modal-body"></br>
                 <div class="input-group">
                     <label class="label-hola" for="modal-trade-cantidad">Address</label>
                     <input id="modal-trade-address" name="address" type="text" value="0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61" class="input-hola input-left input-disabled" required disabled>
                 </div>
                 <div class="input-group">
                     <label class="label-hola" for="modal-trade-cantidad">Cantidad</label>
                     <input id="modal-trade-cantidad" name="cantidad" type="text" placeholder="0.00000000" class="input-hola input-left" required>
                 </div>
                 <div class="input-group">
                     <label class="label-hola" for="modal-trade-memo">Memo</label>
                     <input id="modal-trade-memo" name="memo" type="text" placeholder="Ingresa una descripción." value="" class="input-hola" required>
                 </div>
                 <div1 class="modal-body-info-chiquit">El retiro es meramente virtual, sólo modificará el balance de la billetera.</div1>
             </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button id="confirm-trade-modal" type="submit" class="btn btn-primary">Confirmar</button>
               </div>
         </div>
      </div>
   </div>
   </form>

   <div class="row">
      <section class="main">
         <?php $transactions = $userWallet->transactions->sortByDesc("created_at") ?>
         <div class="info-results">
            <div class="results">
               @lang('Mostrando ') {{count($transactions)}} @lang('transacciones')
            </div>
            <div class="actions">
            </div>
         </div>
         <div class="info items">
            @foreach ( $transactions as $transaction)
               @include('front.panel.transaction')
            @endforeach
            @if($transactions->isEmpty())
               <div class="item">No tienes transacciones.</div>
            @endif
         </div>
      </section>
      <section class="sidebar">
         <div class="title">
            Detalles de billetera
         </div>
         <div class="items">
            <div class="item wallet">
               <img src="/images/{{$userWallet->currency->type === "currency"? "".$userWallet->currency->image : "tokens/".$userWallet->currency->image}}" />
               <span>{{$userWallet->currency->alias}} </span>
               <div class="detail">
                  <span>Disp: {{$userWallet->available_balance}}</span>
                  <small>Real: {{$userWallet->real_balance}}</small>
               </div>
            </div>
            <div1 class="botones_wallet">
               <button class="boton_wallet1" type="submit" onclick="depositar()"><i class="fa fa-plus"></i> Depositar</button>
               <button class="boton_wallet2" type="submit" onclick="retirar()"><i class="fa fa-minus"></i> Retirar</button>
            </div1>
         </div>
      </section>

   </div>

</section>

@endsection

@section('scripts')
   <script type="text/javascript" src="{{ asset('js/pages/manage-wallets.js') }}" ></script>
   <script type="text/javascript" src="{{ asset('js/plugins/modal.js') }}" ></script>
   <script type="text/javascript">
       function startIntro(){
           var intro = introJs();
           intro.setOptions({
               steps: [
                   {
                       element: '.sidebar',
                       intro: "Estos son los detalles de tu billetera, puedes depositar o retirar dinero ficticio desde este panel."
                   },
                   {
                       element: '.info.items',
                       intro: "¡Aquí encontrarás tus últimas transacciones!"
                   }

               ],
               doneLabel : "Pág. sig."
           }).oncomplete(function() {
               window.location.href = '/community?tuto=true';
           });

           intro.start();
       }
       if (RegExp('tuto', 'gi').test(window.location.search)) {
           startIntro();
       }
   </script>
@stop
