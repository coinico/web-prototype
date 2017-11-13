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
                @include ('front.panel.investments')
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
                        intro: "Esta es una propiedad en proceso de tokenización, pasando el ratón por arriba de la misma, habilitarás la opción de contribuir"
                    },
                    {
                        element: '.main .tengoduenio:first-child',
                        intro: "Esta propiedad fue creada a tu nombre en el paso anterior, puedes invertir en ella. Si inviertes 100 ETH se desencadenará el proceso de tokenización.",
                        position: 'right'
                    },
                    {
                        element: '#investment-list',
                        intro: "Tus contribuciones se verán reflejadas en este listado.",
                        position: 'right'
                    }
                ].filter(function(obj) { return $(obj.element).length}),
                doneLabel : "Pág. sig."
            }).oncomplete(function() {
                window.location.href = '/exchange?tuto=true';
            });

            intro.start();
        }
        if (RegExp('tuto', 'gi').test(window.location.search)) {
            startIntro();
        }
    </script>
@stop