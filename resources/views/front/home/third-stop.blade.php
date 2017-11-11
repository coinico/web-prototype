<section id="third-stop">
    <section id="properties" class="third-stop">

    <h1>
        Inversores
    </h1>
    <p>
        Podrás invertir y participar activamente del desarrolllo de alguno de los siguientes activos.
    </p>
    <div class="owl-carousel">
        @foreach ($properties as $property)
            @include('front.properties.detail')
        @endforeach
    </div>
    </section>
</section>
