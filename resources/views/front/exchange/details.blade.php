@extends('front.layout')

@section('main')

   <section id="exchange-details">

       <input type="hidden" id="currencyFrom" value="{{ $currencyFrom->id }}">
       <input type="hidden" id="currencyTo" value="{{ $currencyTo->id }}">
       <input type="hidden" id="currencyFromBalance" value="{{ $walletFrom->available_balance }}">
       <input type="hidden" id="currencyToBalance" value="{{ $walletTo ? $walletTo->available_balance : 0 }}">
       <input type="hidden" id="userLoggedIn" value="{{ $userLoggedIn }}">

       <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:35%; text-align: center">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div id="modaldata" class="modal-body" style="text-align: center">
                   </div>
               </div>
           </div>
       </div>

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
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{number_format($basicDetails->last_value, 8, ".", "")}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->last_value * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Volumen</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{number_format($basicDetails->volume, 4, ".", "")}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->volume * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Venta</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{number_format($basicDetails->ask, 8, ".", "")}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->ask * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">Compra</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{number_format($basicDetails->bid, 8, ".", "")}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->bid * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">24H Máximo</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{number_format($basicDetails->high, 8, ".", "")}}</td>
                       </tr>
                       <tr>
                           <td class="usd_values">$ {{$basicDetails->high * $currencyFrom->usd_value}}</td>
                       </tr>
                       <tr>
                           <td rowspan="2" class="key_values">24H Mínimo</td>
                           <td class="currency_values"><img src="/images/{!!$currencyFrom->image!!}"/>  {{number_format($basicDetails->low, 8, ".", "")}}</td>
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
           <div1 class="order_book_title_trade">
               INTERCAMBIAR
           </div1>
           <div1 class="order_book_title_trade_bid">
               <div1 style="margin-left:10px; float:left;">COMPRAR</div1>
               <div1 style="margin-right:10px; float:right;">{{number_format($walletFrom->available_balance, 8, '.', '')." ".strtoupper($currencyFrom->alias)}} DISPONIBLE</div1>
           </div1>
           <div1 class="order_book_title_trade_ask">
               <div1 style="margin-left:10px; float:left;">VENDER</div1>
               <div1 style="margin-right:10px; float:right;">{{number_format($walletTo ? $walletTo->available_balance : 0, 8, '.', '')." ".strtoupper($currencyTo->alias)}} DISPONIBLE</div1>
           </div1>
           <div1 class="order_book_trade_bid">
               </br>
               <div1 class="input-group">
                   <label for="unitsBid" class="col-md-1 control-label">Cantidad</label>
                   <span class="input-group-btn">
                        <button class="btn btn-primary" id="maxBidBtn" onclick="maxBidSelected();" style="width:100px;" type="button" title="Habilitando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                    <input id="unitsBid" type="text" placeholder="0.00000000" value="0.00000000" class="input-trade" min="0.00050000" required>
                    <span class="input-group-addon">{{strtoupper($currencyTo->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <label for="bidValue" class="col-md-1 control-label">Precio</label>
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Puedes seleccionar el precio que quieras.">Precio</button>
                    </span>
                   <input id="bidValue" type="text" placeholder="0.00000000" value="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyFrom->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <label for="totalBid" class="col-md-1 control-label">Total</label>
                   <span class="input-group-btn">
                        <button class="btn1 btn-primary1" style="width:100px;" type="button"><img src="/images/{!!$currencyFrom->image!!}"/></button>
                    </span>
                   <input id="totalBid" type="text" placeholder="0.00000000" value="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyFrom->alias)}}</span>
               </div1>
               <div1 class="input-group submit_trade">
                   <button type="submit"><i class="fa fa-plus"></i> Comprar {{strtoupper($currencyTo->name)}}</button>
               </div1>
           </div1>
           <div1 class="order_book_trade_ask">
               </br>
               <div1 class="input-group">
                   <label for="unitsAsk" class="col-md-1 control-label">Cantidad</label>
                   <span class="input-group-btn">
                        <button class="btn btn-primary" id="maxAskBtn" onclick="maxAskSelected();" style="width:100px;" type="button" title="Habilitando esta casilla, se va a calcular el maximo disponible que puedas comprar con el precio que escribas.">Max</button>
                    </span>
                   <input id="unitsAsk" type="text" placeholder="0.00000000" value="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyTo->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <label for="askValue" class="col-md-1 control-label">Precio</label>
                   <span class="input-group-btn">
                        <button class="btn btn-primary" style="width:100px;" type="button" title="Puedes seleccionar el precio que quieras.">Precio</button>
                    </span>
                   <input id="askValue" type="text" placeholder="0.00000000" value="0.00000000" class="input-trade">
                   <span class="input-group-addon">{{strtoupper($currencyFrom->alias)}}</span>
               </div1>

               <div1 class="input-group">
                   <label for="totalAsk" class="col-md-1 control-label">Total</label>
                   <span class="input-group-btn">
                        <button class="btn1 btn-primary1" style="width:100px;" type="button"><img src="/images/{!!$currencyFrom->image!!}"/></button>
                   </span>
                   <input id="totalAsk" type="text" placeholder="0.00000000" value="0.00000000" class="input-trade">
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
    <script type="text/javascript" src="{{ asset('js/plugins/modal.js') }}" ></script>

@stop
