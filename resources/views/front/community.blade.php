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
                        intro: "Ésta es una propiedad en proceso de aceptación, pasando el ratón por encima de ella, podrás votar",
                        position: 'right'
                    },
                    {
                        element: '.main .tengoduenio:first-child',
                        intro: "Hemos creado esta propiedad a tu nombre, si la votas positivamente, luego podrás verla en el panel de inversión.",
                        position: 'right'
                    },{
                        element: '#voting-list',
                        intro: "Tus votos se verán reflejados en este listado.",
                        position: 'left'
                    },
                    {
                        element: "#top",
                        intro: "OK. ¡Vamos a ver que puedes hacer como inversor!"
                    }
                ].filter(function(obj) { return $(obj.element).length}),
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