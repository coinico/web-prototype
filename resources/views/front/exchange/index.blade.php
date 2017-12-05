@extends('front.layout')

@section('main')

   <section id="exchange">
       <div class="row">
           <div class="owl-carousel">
               @foreach ($volumeCurrencies as $currency)
                   @include('front.exchange.sub_header', array('headerFor'=>'Mayor Volumen'))
               @endforeach
               @foreach ($biggestGainCurrencies as $currency)
                   @include('front.exchange.sub_header', array('headerFor'=>'Mayor Ganancia %'))
               @endforeach
           </div>
       </div>

       <div class="row olinda">
           <table id="ctf" class="display cell-border responsive hover stripe nowrap" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Mercado</th>
                   <th>Moneda</th>
                   <th>Volumen</th>
                   <th>Cambio</th>
                   <th>Último Precio</th>
                   <th>Máximo</th>
                   <th>Mínimo</th>
                   <th>Margen</th>
               </tr>
               </thead>
           </table>
       </div>

       <div class="row recife">
           <table id="eth" class="display cell-border responsive hover stripe nowrap" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Mercado</th>
                   <th>Moneda</th>
                   <th>Volumen</th>
                   <th>Cambio</th>
                   <th>Último Precio</th>
                   <th>Máximo</th>
                   <th>Mínimo</th>
                   <th>Margen</th>
               </tr>
               </thead>
           </table>
       </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/pages/exchange.js') }}" ></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
    <script type="text/javascript" src="//cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js" ></script>
    <script type="text/javascript" src="{{ asset('js/plugins/owl.carousel.min.js') }}" ></script>

@stop
