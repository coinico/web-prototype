@extends('front.layout')

@section('main')

   <section id="exchange">
       <div class="row">
           <table id="ctf" class="display cell-border hover stripe" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Mercado</th>
                   <th>Moneda</th>
                   <th>Volúmen</th>
                   <th>Cambio</th>
                   <th>Último Precio</th>
                   <th>Máximo</th>
                   <th>Mínimo</th>
                   <th>Margen</th>
               </tr>
               </thead>
           </table>
       </div>

       <div class="row">
           <table id="btc" class="display cell-border hover stripe" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Mercado</th>
                   <th>Moneda</th>
                   <th>Volúmen</th>
                   <th>Cambio</th>
                   <th>Último Precio</th>
                   <th>Máximo</th>
                   <th>Mínimo</th>
                   <th>Margen</th>
                   <th>Añadido</th>
               </tr>
               </thead>
           </table>
       </div>
       <div class="row">
           <table id="eth" class="display" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Mercado</th>
                   <th>Moneda</th>
                   <th>Volúmen</th>
                   <th>Cambio</th>
                   <th>Último</th>
                   <th>Máximo</th>
                   <th>Mínimo</th>
                   <th>Margen</th>
                   <th>Añadido</th>
               </tr>
               </thead>
           </table>
       </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/pages/exchange.js') }}" ></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>

@stop
