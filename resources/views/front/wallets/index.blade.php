@extends('front.layout')

@section('main')

   <section id="wallets">
      <!--<div class="row">
      @if( !count($wallets))
         <p> Todavía no tienes billeteras, pero puedes <a href="wallets/start">comenzar ahora</a> </p>
      @else
         {{dump($wallets)}}
      @endif
      </div>-->

      <div class="row">
         <div class="info-results">
            <div class="results">
               <h3>Billeteras</h3>
            </div>
            <div class="actions">
               <a href="#" id="wallets-horizontal-view-btn">
                  <i class="fa fa-list" aria-hidden="true"></i>
               </a>
               <a href="#" id="wallets-normal-view-btn">
                  <i class="fa fa-th" aria-hidden="true"></i>
               </a>
            </div>
         </div>

         <div class="wallets">
            <div class="wallet-wrapper">
               <a href="#" class="wallet">
                  <img src="images/wallets/ethereum.png" />
                  <p>Ethereum</p>
               </a>
            </div>
            <div class="wallet-wrapper">
               <a href="#" class="wallet">
                  <img src="images/wallets/casatoken.png" />
                  <p>Ethereum</p>
               </a>
            </div>
         </div>

         <div class="info-results">
            <div class="results">
               <h3>Tokens de propiedad</h3>
            </div>
            <div class="actions">
               <a href="#" id="tokens-horizontal-view-btn">
                  <i class="fa fa-list" aria-hidden="true"></i>
               </a>
               <a href="#" id="tokens-normal-view-btn">
                  <i class="fa fa-th" aria-hidden="true"></i>
               </a>
            </div>
         </div>

         <div class="tokens">
            <div class="wallet-wrapper">
               <a href="#" class="wallet">
                  <img src="images/tokens/house.png" />
                  <p>ARG-00-NADA</p>
               </a>
            </div>
            <div class="wallet-wrapper">
               <a href="#" class="wallet">
                  <img src="images/tokens/house.png" />
                  <p>Ethereum</p>
               </a>
            </div>
         </div>



      </div>


   </section>

@endsection

@section('scripts')
   <script type="text/javascript" src="{{ asset('js/pages/wallets.js') }}" ></script>
@stop
