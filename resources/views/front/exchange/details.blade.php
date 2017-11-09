@extends('front.layout')

@section('main')

   <section id="exchange-details">
       <div class="row">
           <table id="lastExecutedOrders" class="display cell-border hover stripe" cellspacing="0" width="100%">
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
    <script type="text/javascript" src="{{ asset('js/pages/exchange-details.js') }}" ></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>

@stop
