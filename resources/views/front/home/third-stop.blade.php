<section id="third-stop">

    <section id="properties" class="third-stop">
        <h1>
            Inversores
        </h1>
        <div class="owl-carousel">
            @foreach ($properties as $property)
                @include('front.properties.detail')
            @endforeach
        </div>
    </section>
</section>
