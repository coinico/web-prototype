@extends('front.layout')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery.fancybox.min.css') }}">
@stop

@section('main')

   <section id="property">
       <div class="row">
            <h1> ARG-BN-001 <span>U$D 1.000.000</span></h1>
            <img src="/images/example.jpg" />

            <div class="economic">
                <div class="item-wrap">
                    <div class="item"><p>29,25%</p></div>
                </div>
                <div class="item-wrap">
                    <div class="item"><p>486 <small>Suscriptores</small></p></div>
                </div>
                <div class="item-wrap">
                    <div class="item"><p>U$D 117.000</p></div>
                </div>
            </div>

            <section class="features owl-carousel">
                <div class="feature">
                    Ambientes <span>4</span>
                </div>
                <div class="feature">
                    Dormitorios <span>2</span>
                </div>
                <div class="feature">
                    Baños <span>2</span>
                </div>
                <div class="feature">
                    Superficie Total <span> 300</span>
                </div>
                <div class="feature">
                    Superficie Cubierta <span> 85</span>
                </div>
                <div class="feature">
                    Expensas <small>U$s2.000</small>
                </div>
                <div class="feature">
                    Servicios <small> GAS, LUZ, AGUA </small>
                </div>
                <div class="feature">
                    Orientacion <small> Oeste </small>
                </div>
                <div class="feature">
                    Pisos <span> 2 </span>
                </div>
                <div class="feature">
                    Cocheras <span> 2 </span>
                </div>
            </section>

           <section class="decription">
               <h3> Descripción </h3>
               <p>Proyecto destinado a la acumulación de capital colaborativo para la adquisición parcial de la titularidad del inmueble detallado en este documento. Se suscribe inicialmente a la participación mediante la compra mínima de de un token ARG-BN-001 y se establece como contraprestación la obtención de beneficios, proporcionales al capital suscripto, originados por el arrendamiento de la propiedad y por la recompra por parte del inquilino de la totalidad de los tokens en la fecha de finalización del proyecto.
               La participación en el proyecto se extingue al completarse el plazo y las condiciones previstas. Se puede recuperar el capital invertido en cualquier momento mediante el intercambio de los token en el mercado donde estos presentan cotización.</p>

               <h4>Detalles:</h4>
               <p>Se realizó la correspondiente tasación de la propiedad en U$D 1.000.000 y se procede a emitir 100.000 unidades de ARG-BN-001 por un valor inicial de U$D 10 c/u.</p>
               <p>El objetivo de la operación es captar fondos U$D 400.000 dólares mediante la licitación inicial del 40% de los de token emitidos o 40.000 unidades (el resto permanecen en la tenencia del inquilino).</p>
               <p>-Plazo - 2 años</p>
               <p>-Renta - U35.000 el primer año y U$D 40.000 el segundo</p>

               <h4>Fecha de licitación:</h4>
               <p>Se puede comprar participación entre el 12-12-2017  y 12-01-2018.</p>


           </section>

            <section class="decription">
                <h3> Detalle </h3>
                <p>Se trata de una casa en un barrio residencial de lujo en las afueras de Londres.
                    La propiedad cuenta con un diseño moderno y está dispuesta sobre un amplio terreno.
                </p>
            </section>

            <section class="plans">
                <h3>Planos</h3>
                <a href="/images/plans.jpg" id="view-plans">
                    <img src="/images/plans.jpg" />
                </a>
            </section>

            <section class="location">
                <h3>Ubicación</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5524.64798195098!2d-58.40872520702281!3d-34.57949042016931!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb57b47c8a597%3A0x90b984b5e107f8!2sAv.+del+Libertador+2600%2C+Buenos+Aires%2C+Argentina!5e0!3m2!1ses-419!2sfr!4v1510095957268" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </section>

        </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/plugins/owl.carousel.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.fancybox.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/pages/property.js') }}" ></script>
@stop