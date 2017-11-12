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
    <script type="text/javascript">
        function startIntro(){
            var intro = introJs();
            intro.setOptions({
                steps: [
                    {
                        element: '.main .property:first-child',
                        intro: "Esta es una propiedad en proceso de aceptación, si pasas tu mouse por arriba podrás votar"
                    },
                    {
                        element: '#voting-list',
                        intro: "Acá encontrarás el listado de tus votos",
                        position: 'right'
                    },
                ],
                doneLabel : "Pág. sig."
            }).oncomplete(function() {
                window.location.href = '/investors?tuto=true';
            });

            intro.start();
        }
        if (RegExp('tuto', 'gi').test(window.location.search)) {
            startIntro();
        }
    </script>
@stop