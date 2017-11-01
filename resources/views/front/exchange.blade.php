@extends('front.layout')

@section('main')

   <section id="exchange">
       <div class="row">
           <h3>BITCOIN MARKETS</h3>
           <table id="btc" class="display" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Market</th>
                   <th>Currency</th>
                   <th>Volume</th>
                   <th>Change</th>
                   <th>Last Price</th>
                   <th>High</th>
                   <th>Low</th>
                   <th>Spread</th>
                   <th>Added</th>
               </tr>
               </thead>
           </table>
       </div>
       <div class="row">
           <h3>ETHEREUM MARKETS</h3>
           <table id="eth" class="display" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Market</th>
                   <th>Currency</th>
                   <th>Volume</th>
                   <th>Change</th>
                   <th>Last Price</th>
                   <th>High</th>
                   <th>Low</th>
                   <th>Spread</th>
                   <th>Added</th>
               </tr>
               </thead>
           </table>
       </div>
       <div class="row">
           <h3>USDT MARKETS</h3>
           <table id="usdt" class="display" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>Market</th>
                   <th>Currency</th>
                   <th>Volume</th>
                   <th>Change</th>
                   <th>Last Price</th>
                   <th>High</th>
                   <th>Low</th>
                   <th>Spread</th>
                   <th>Added</th>
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