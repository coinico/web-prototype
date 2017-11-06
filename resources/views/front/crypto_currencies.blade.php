@extends('front.layout')

@section('main')

   <section id="properties">
       <div class="row">
            <div class="info-results">
                <div class="results">
                    @lang('Mostrando ') {{count($cryptoCurrencies)}} @lang('resultados')
                </div>
                <div class="actions">
                    <a href="#" id="horizontal-view-btn">
                        <i class="fa fa-list" aria-hidden="true"></i>
                    </a>
                    <a href="#" id="normal-view-btn">
                        <i class="fa fa-th" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
           @foreach ($cryptoCurrencies as $cryptoCurrency)
               @include('front.crypto_currencies.detail')
           @endforeach

        </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/pages/crypto_currencies.js') }}" ></script>
@stop