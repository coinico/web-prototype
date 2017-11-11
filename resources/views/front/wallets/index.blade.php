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
   <script type="text/javascript" src="{{ asset('js/wallet/lightwallet.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/pages/wallets.js') }}" ></script>
@stop
