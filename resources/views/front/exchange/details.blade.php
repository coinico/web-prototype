@extends('front.layout')

@section('main')

   <section id="exchange-details">

       <input type="hidden" id="currencyFrom" value="{{ $currencyFrom->id }}">
       <input type="hidden" id="currencyTo" value="{{ $currencyTo->id }}">

       <div class="row info_container">
           <div id="chartdiv" class="graphic"></div>
           <input type="button" class="amChartsButton amcharts-period-input" id="seeHideVolumeButton" value="MOSTRAR/OCULTAR VOLUMEN" onclick="seeHideVolume();"/>

           <div class="info_currency">
               <table id="info_currency" class="info_currency_table" cellspacing="0">
                   <thead>
                       <tr>
                           <th class="currency_header" colspan="2">
                               <div><img class="currency_header_img" src="/images/tokens/{!!$currencyTo->image!!}" /></div>
                               <div class="currency_header_title">{{$currencyTo->name}} ({{$currencyTo->alias}})</div>
                            </th>
                       </tr>
                   </thead>
                   <tbody>
                       <tr>
                           <td rowspan="2" class="key_values">Último</td>
                           <td class="currency_values">{{$basicDetails->last_value}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->last_value * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Volumen {{$currencyFrom->alias}}</td>
                           <td class="currency_values">{{$basicDetails->volume}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->volume * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Precio Venta</td>
                           <td class="currency_values">{{$basicDetails->ask}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->ask * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Precio Compra</td>
                           <td class="currency_values">{{$basicDetails->bid}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->bid * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">24H Máximo</td>
                           <td class="currency_values">{{$basicDetails->high}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->high * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">24H Mínimo</td>
                           <td class="currency_values">{{$basicDetails->low}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->low * $currencyFrom->usd_value}}</td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>

       <div class="row order_book_container">
           <div1 class="order_book_title">Libros de Órdenes</div1>
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

       <div class="row">
           <table id="myLastExecutedOrders" class="display cell-border hover stripe" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Fecha de Cierre</th>
                   <th>Fecha de Apertura</th>
                   <th>Tipo</th>
                   <th>Valor</th>
                   <th>Cantidad llenada</th>
                   <th>Cantidad Total</th>
                   <th>Valor de Venta Real</th>
                   <th>Costo Total</th>
               </tr>
               </thead>
           </table>
       </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/amstock.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script type="text/javascript" src="{{ asset('js/pages/exchange-details.js') }}" ></script>

@stop
