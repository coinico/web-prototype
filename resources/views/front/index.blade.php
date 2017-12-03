@extends('front.layout')

@section('main')

    <!-- masonry
    ================================================== -->
    <section id="home">

        <div class="row masonry">
            @isset($info)
                @component('front.components.alert')
                    @slot('type')
                        info
                    @endslot
                    {!! $info !!}
                @endcomponent
            @endisset
            @if ($errors->has('search'))
                @component('front.components.alert')
                    @slot('type')
                        error
                    @endslot
                    {{ $errors->first('search') }}
                @endcomponent
            @endif  
            <!-- brick-wrapper -->

        </div> <!-- end row -->


        @include('front.home.first-stop')
        @include('front.home.second-stop')
        @include('front.home.fifth-stop')
        @include('front.home.third-stop')
        @include('front.home.fourth-stop')
        @include('front.home.bottom-stop')

    </section> <!-- end bricks -->

@endsection


@section('scripts')
    <script type="text/javascript" src="{{ asset('js/plugins/owl.carousel.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/pages/home.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/pages/properties.js') }}" ></script>

    <script type="text/javascript">
        var arrow = document.querySelector('.arrow-example');
        var arrow2 = document.querySelector('.arrow-example1');

        setInterval(function () {
            arrow.classList.toggle('-hidden');
            arrow2.classList.toggle('-hidden');
        }, 2000);
    </script>
@stop