@extends('front.layout')

@section('main')

    <section id="properties" class="panel">
        <div class="row">
            <section class="main">
                <div class="info-results">
                    <div class="results">
                        @lang('Mostrando ') {{count($properties)}} @lang('resultados')
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
            </section>
            <section class="sidebar">
                <div class="title">
                    Mis Contribuciones
                </div>
                <div class="info items">
                    @foreach ($investments as $investment)
                        @include('front.panel.investment')
                    @endforeach
                    @if($investments->isEmpty())
                        <div class="item">No posees contribuciones activas.</div>
                    @endif
                </div>
            </section>

        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/pages/properties.js') }}" ></script>
@stop