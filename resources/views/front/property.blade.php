@extends('front.layout')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery.fancybox.min.css') }}">
@stop

@section('main')

   <section id="property">
       <div class="row">
            <h1> {{$property->title}} <span>U$D {{number_format($property->value, 0, ',', '.')}}</span></h1>
           <div class="investment">
                <img src="/images/properties/{{$property->images}}" class="main-image" />
           </div>

           @if($property->status_id ==1)

               <div class="voting">

               </div>

               <div class="economic">
                   <div class="item-wrap">
                       <div class="item">
                           <p>{{number_format($property->getVotingStatus('percentage'), 2, ',', '.')}}%
                               <small>Aprobación requerida: 95%</small>
                           </p>
                       </div>
                   </div>
                   <div class="item-wrap">
                       <div class="item"><p>{{$property->getTotalVoters()}} <small>Votantes</small></p></div>
                   </div>
                   <div class="item-wrap">
                       <div class="item">
                           <p>
                               {{$property->getPositiveVotes()}} <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                               <small>
                                   {{$property->getNegativeVotes()}} <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                               </small>
                           </p>
                       </div>
                   </div>
               </div>

           @elseif($property->status_id ==4)
            @guest

                   @else
               <div class="investment">
                   <div class="item-wrap">
                       <div class="item invest"  data-url="/property/{{ $property->id }}/invest">
                           <h3>Mi inversión <a href="#" id="edit-investment"> <i class="fa fa-pencil" aria-hidden="true"></i> </a></h3>
                           <fieldset>
                               <input readonly class="eth" value="{{number_format($property->getUserInvestment(), 2, ',', '.')}}" />
                               <a href="#">
                                   <small>ETH</small>
                                   <i class="fa fa-paper-plane" aria-hidden="true"></i>
                               </a>
                           </fieldset>
                           <p><small>{{number_format($property->getUserInvestment('usd'), 0, ',', '.')}} U$D</small></p>
                       </div>
                   </div>
               </div>
                       @endguest

            <div class="economic">
                <div class="item-wrap">
                    <div class="item"><p>{{number_format($property->getTotalInvestment('percentage'), 2, ',', '.')}}%</p></div>
                </div>
                <div class="item-wrap">
                    <div class="item"><p>{{$property->getTotalInvestors()}} <small>Suscriptores</small></p></div>
                </div>
                <div class="item-wrap">
                    <div class="item"><p>U$D {{number_format($property->getTotalInvestment('usd'), 0, ',', '.')}}</p></div>
                </div>
            </div>

           @endif


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
               <p>{{$property->description}}</p>

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
                <iframe src="https://maps.google.com/maps/embed/v1/place?zoom=18&key=AIzaSyBJgltaTNGdMfz9JStUKKnei78pfQZhgF4&q={{$property->address.", ".$property->city}}" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </section>

        </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/plugins/owl.carousel.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.fancybox.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.sparkline.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/pages/property.js') }}" ></script>

@stop