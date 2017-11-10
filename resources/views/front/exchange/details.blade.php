@extends('front.layout')

@section('main')

   <section id="exchange-details">

       <input type="hidden" id="currencyFrom" value="{{ $currencyFrom->id }}">
       <input type="hidden" id="currencyTo" value="{{ $currencyTo->id }}">
       <input type="hidden" id="userLoggedIn" value="{{ $userLoggedIn }}">

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
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{$basicDetails->last_value}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->last_value * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Volumen</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{$basicDetails->volume}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->volume * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Precio Venta</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{$basicDetails->ask}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->ask * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Precio Compra</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{$basicDetails->bid}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->bid * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">24H Máximo</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{$basicDetails->high}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->high * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">24H Mínimo</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{$basicDetails->low}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->low * $currencyFrom->usd_value}}</td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>

       @auth
       <div class="row order_book_trade_container">
           <div1 class="order_book_title_trade_bid">COMPRAR {{strtoupper($currencyTo->name)}}</div1>
           <div1 class="order_book_title_trade_ask">VENDER {{strtoupper($currencyTo->name)}}</div1>
           <div1 class="order_book_trade_bid">
               </br>
               <div1 class="input-group">
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Habilistando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                    <input id="units" type="text" placeholder="0.00000000" class="input-trade">
                    <span class="input-group-addon">{{strtoupper($currencyTo->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Habilistando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                   <input id="bid" type="text" placeholder="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyFrom->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Habilistando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                   <input id="total" type="text" placeholder="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyFrom->alias)}}</span>
               </div1>
               <div1 class="input-group submit_trade">
                   <button type="submit"><i class="fa fa-plus"></i> Comprar {{strtoupper($currencyTo->name)}}</button>
               </div1>
           </div1>
           <div1 class="order_book_trade_ask">
               </br>
               <div1 class="input-group">
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Habilistando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                   <input id="units" type="text" placeholder="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyTo->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Habilistando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                   <input id="bid" type="text" placeholder="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyFrom->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Habilistando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                   <input id="total" type="text" placeholder="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyFrom->alias)}}</span>
               </div1>
               <div1 class="input-group submit_trade">
                   <button type="submit"><i class="fa fa-minus"></i> Vender {{strtoupper($currencyTo->name)}}</button>
               </div1>
           </div1>
       </div>
       @endauth

       <div class="row order_book_container">
           <div1 class="order_book_title_bid">ORDENES DE COMPRA</div1>
           <div1 class="order_book_title_ask">ORDENES DE VENTA</div1>
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

       @auth
           <div class="row">
               <table id="myOpenOrders" class="display cell-border hover stripe" cellspacing="0" width="100%">
                   <thead>
                   <tr>
                       <th>Fecha de Apertura</th>
                       <th>Tipo</th>
                       <th>Valor</th>
                       <th>Cantidad llenada</th>
                       <th>Cantidad Total</th>
                       <th>Valor Promedio</th>
                       <th>Total Estimado</th>
                       <th><i class="fa fa-times"></i></th>
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
                       <th>Valor Promedio</th>
                       <th>Total</th>
                   </tr>
                   </thead>
               </table>
           </div>

       @endauth

       <div class="row">
           <table id="lastExecutedOrders" class="display cell-border hover stripe" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Fecha</th>
                   <th>Comprar/Vender</th>
                   <th>Valor</th>
                   <th>Cantidad</th>
                   <th>Total</th>
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
