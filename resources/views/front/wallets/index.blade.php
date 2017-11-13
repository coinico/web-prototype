@extends('front.layout')

@section('main')

   <section id="wallets">
      <div class="row">
         <div class="info-results">
            <div class="results">
               <h3>@lang('Mostrando ') {{count($standardWallets)}} @lang('billeteras')</h3>
            </div>
            <div class="actions">
               <a href="#" id="wallets-normal-view-btn">
                  <i class="fa fa-th" aria-hidden="true"></i>
               </a>
            </div>
         </div>

         <div class="wallets">
            @foreach ($standardWallets as $standardWallet)
               @include('front.wallets.wallet_detail')
            @endforeach
         </div>

         <div class="info-results">
            <div class="results">
               <h3>Tokens de propiedad</h3>
            </div>
            <div class="actions">
               <a href="#" id="tokens-normal-view-btn">
                  <i class="fa fa-th" aria-hidden="true"></i>
               </a>
            </div>
         </div>

         <div class="tokens">
            @foreach ($tokenWallets as $tokenWallet)
               @include('front.wallets.token_detail')
            @endforeach
         </div>
      </div>
   </section>

@endsection

@section('scripts')
   <script type="text/javascript" src="{{ asset('js/pages/wallets.js') }}" ></script>
   <script type="text/javascript">
      function startIntro(){
         var intro = introJs();
         intro.setOptions({
            steps: [
               {
                  element: '.wallets',
                  intro: "Hey! Parece que ya tienes billeteras! Hemos depositado 100 de ETH y 10000 CTF por defecto en ellas."
               }
            ],
            doneLabel : "Pág. sig."
         }).oncomplete(function() {
            var url = $('.wallets .wallet:first-child a').attr('href');
            window.location.href = url+'?tuto=true';
         });

         intro.start();
      }
      if (RegExp('tuto', 'gi').test(window.location.search)) {
         startIntro();
      }
   </script>
@stop
