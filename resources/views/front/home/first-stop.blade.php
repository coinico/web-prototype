<section id="first-stop" class="first-stop">

    <p>
        Bienvenido a
    </p>

    <div class="casatoken-title">CasaToken</div>
    </br>

    <p>
        <span>El futuro del negocio Inmobiliario</span>
    </p>

    @guest
        <a href="{{ route('register') }}">@lang('COMENZAR CON LA DEMO')</a>
    @endguest

    <div class="example-wrapper">
        <div class="arrow-example -hidden">
            <div class="dot -center"></div>
            <div class="dot -center"></div>
            <div class="dot -center"></div>
            <div class="dot -center"></div>
            <div class="dot -center"></div>
            <div class="dot -center"></div>
            <div class="dot -left-1"></div>
            <div class="dot -left-2"></div>
            <div class="dot -right-1"></div>
            <div class="dot -right-2"></div>
        </div>
    </div>

    <div class="example-wrapper1">
        <div class="arrow-example1 -hidden">
            <div class="dot1 -center"></div>
            <div class="dot1 -center"></div>
            <div class="dot1 -center"></div>
            <div class="dot1 -center"></div>
            <div class="dot1 -center"></div>
            <div class="dot1 -center"></div>
            <div class="dot1 -left-1"></div>
            <div class="dot1 -left-2"></div>
            <div class="dot1 -right-1"></div>
            <div class="dot1 -right-2"></div>
        </div>
    </div>

    </br>
    </br>

</section>
@section('scripts')
    <script type="text/javascript">
        var arrow = document.querySelector('.arrow-example');
        var arrow2 = document.querySelector('.arrow-example1');

        setInterval(function () {
            arrow.classList.toggle('-hidden');
            arrow2.classList.toggle('-hidden');
        }, 2000);
    </script>
@stop