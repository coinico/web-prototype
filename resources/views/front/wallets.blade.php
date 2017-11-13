@extends('front.layout')

@section('main')

   <section id="properties">
       <div class="row">
            <div class="info-results">
                <div class="results">
                    @lang('Showing ') {{count($properties)}} @lang('results')
                </div>
                <div class="actions">
                    <a href="#" id="horizontal-view-btn">
                        <i class="fa fa-list" aria-hidden="true"></i>
                    </a>
                    <a href="#" id="normal-view-btn">
                        <i class="fa fa-th" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
           @foreach ($properties as $property)
               @include('front.properties.detail')
           @endforeach

        </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/pages/wallets.js') }}" ></script>

@stop