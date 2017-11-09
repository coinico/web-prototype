@extends('front.layout')

@section('main')

   <section id="exchange-details">

       <input type="hidden" id="currencyFrom" value="{{ $currencyFrom->id }}">
       <input type="hidden" id="currencyTo" value="{{ $currencyTo->id }}">

       <div class="row order_book_container">
           <div1 class="order_book_bid">
               <table id="order_book_bid" class="display cell-border hover stripe" cellspacing="0">
                   <thead>
                   <tr>
                       <th>Suma Total</th>
                       <th>Total</th>
                       <th>Cantidad</th>
                       <th>Precio Compra ({{$currencyFrom->alias}})</th>
                   </tr>
                   </thead>
               </table>
           </div1>
           <div1 class="order_book_ask">
               <table id="order_book_ask" class="display cell-border hover stripe" cellspacing="0">
                   <thead>
                   <tr>
                       <th>Precio Venta ({{$currencyFrom->alias}})</th>
                       <th>Cantidad</th>
                       <th>Total</th>
                       <th>Suma Total</th>
                   </tr>
                   </thead>
               </table>
           </div1>
       </div>

       <div class="row">
           <table id="lastExecutedOrders" class="display cell-border hover stripe" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Fecha</th>
                   <th>Comprar/Vender</th>
                   <th>Valor</th>
                   <th>Cantidad</th>
                   <th>Costo Total</th>
               </tr>
               </thead>
           </table>
       </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/pages/exchange-details.js') }}" ></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>

@stop
