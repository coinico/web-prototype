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
                @include('front.panel.votes')
            </section>

        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/pages/properties.js') }}" ></script>
@stop