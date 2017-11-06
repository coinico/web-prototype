@extends('front.layout')

@section('main')

   <section id="wallets">
      <div class="row">
      @if( !count($wallets))
         <p> Todavía no tienes billeteras, pero puedes <a href="wallets/start">comenzar ahora</a> </p>
      @else
         {{dump($wallets)}}
      @endif
      </div>
   </section>

@endsection

@section('scripts')

@stop
