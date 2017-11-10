@extends('front.layout')

@section('main')

   <section id="orders-details">

       <input type="hidden" id="userLoggedIn" value="{{ $userLoggedIn }}">

       <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:35%; text-align: center">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div id="modaldata" class="modal-body" style="text-align: center">
                   </div>
               </div>
           </div>
       </div>

       @auth
           <div class="row">
               <table id="myOpenOrders" class="display cell-border hover stripe" cellspacing="0" width="100%">
                   <thead>
                   <tr>
                       <th>Fecha de Apertura</th>
                       <th>Mercado</th>
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
                       <th>Mercado</th>
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
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
    <script type="text/javascript" src="{{ asset('js/pages/orders.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/plugins/modal.js') }}" ></script>

@stop
