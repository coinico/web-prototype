@extends('front.layout')

@section('main')

<section id="manage-wallet" class="panel">

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
               </a>-->
               <a href="#" id="normal-view-btn">
                  <i class="fa fa-th" aria-hidden="true"></i>
               </a>
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
@stop
