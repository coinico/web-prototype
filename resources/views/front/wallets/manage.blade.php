@extends('front.layout')

@section('main')

<section id="manage-wallet" class="panel">

   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:35%; text-align: center">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div id="modaldata" class="modal-body" style="text-align: center">
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="tradeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog order_book_trade_bid" role="document">
         <div class="modal-content order_book_trade_bid">
            <div class="modal-header">
               <h4 class="modal-title" id="tradeModalTitle">Modal title</h4>
            </div>
            <div class="modal-body">
                  <label for="modal-trade-cantidad">Cantidad</label>
                  <input id="modal-trade-cantidad" type="text" placeholder="0.00000000" class="input-hola input-left" required>
                  <label for="modal-trade-memo">Memo</label>
                  <input id="modal-trade-memo" type="text" placeholder="Ingresa una descripción." value="" class="input-hola" required>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
               <button id="confirm-trade-modal" type="button" class="btn btn-primary" data-dismiss="modal">Confirmar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <section class="main">
         <?php $transactions = $userWallet->transactions ?>
         <div class="info-results">
            <div class="results">
               @lang('Mostrando ') {{count($transactions)}} @lang('transacciones')
            </div>
            <div class="actions">
               <!--<a href="#" id="horizontal-view-btn">
                  <i class="fa fa-list" aria-hidden="true"></i>
               </a>
            <!--<a href="#" id="normal-view-btn">
                  <i class="fa fa-th" aria-hidden="true"></i>
               </a>-->
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
               <img src="/images/wallets/qr_code.png" />
               <span>{{$userWallet->getCurrency()}} </span>
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
@stop
