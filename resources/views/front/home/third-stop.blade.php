<section id="third-stop">

    <section id="properties" class="third-stop">
        <h1>
            Inversores
        </h1>
        <p class="invest-p">
            Fácil acceso a participación parcial en propiedades inmobiliarias a través de los tokens de propiedad de Casatoken. Inversiones a tu medida, con alta liquidez, y con el beneficio de renta proporcional. Portfolio diversificado de inmuebles en múltiples jurisdicciones, y mercado decentralizado online transparente y ágil para compra-venta P2P (persona-a-persona) de tokens de propiedad. Explorá y se parte hoy del mercado inmobiliario del futuro
        </p>
        <div class="owl-carousel">
            @foreach ($properties as $property)
                @include('front.properties.detail')
            @endforeach
        </div>
    </section>
</section>
