@extends('front.layout')

@section('main')

   <section id="exchange">
       <div class="container">
           <table id="markets" class="display" cellspacing="0" width="100%">
               <thead>
               <tr>
                   <th>MarketName</th>
                   <th>High</th>
                   <th>Low</th>
                   <th>Volume</th>
                   <th>Last</th>
                   <th>BaseVolume</th>
                   <th>TimeStamp</th>
                   <th>Bid</th>
                   <th>Ask</th>
                   <th>OpenBuyOrders</th>
                   <th>OpenSellOrders</th>
                   <th>PrevDay</th>
                   <th>Created</th>
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