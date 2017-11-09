@extends('front.layout')

@section('main')

<section id="manage-wallet">

   @lang('Mostrando los detalles de tu billetera')
   </br>
   {{$userWallet}}

   </br>
   @lang('Mostrando ') {{count($userWallet->transactions)}} @lang('transacciones')
   </br>
   @foreach ($userWallet->transactions as $transaction)
         {{$transaction}}
   @endforeach
</section>

@endsection

@section('scripts')
   <script type="text/javascript" src="{{ asset('js/pages/manage-wallets.js') }}" ></script>
@stop
