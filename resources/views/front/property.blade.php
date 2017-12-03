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
                    Ambientes <span>{{number_format($property->value*0.000011, 0, ',', '.')}}</span>
                </div>
                <div class="feature">
                    Dormitorios <span>{{number_format($property->value*0.000008, 0, ',', '.')}}</span>
                </div>
                <div class="feature">
                    Baños <span>{{number_format($property->value*0.000002, 0, ',', '.')}}</span>
                </div>
                <div class="feature">
                    Superficie Total <span> {{number_format($property->value*0.0009, 0, ',', '.')}} m2</span>
                </div>
                <div class="feature">
                    Superficie Cubierta <span> {{number_format($property->value*0.00045, 0, ',', '.')}} m2</span>
                </div>
                <div class="feature">
                    Expensas <span>U$D {{number_format($property->value*0.0013, 0, ',', '.')}}</span>
                </div>
                <div class="feature">
                    Servicios <span> GAS, LUZ, AGUA </span>
                </div>
                <div class="feature">
                    Orientación <span> OESTE </span>
                </div>
                <div class="feature">
                    Pisos <span> {{number_format($property->value*0.000002, 0, ',', '.')}} </span>
                </div>
                <div class="feature">
                    Cocheras <span> {{number_format($property->value*0.000003, 0, ',', '.')}} </span>
                </div>
            </section>

           <section class="decription">
               <h3> Descripción </h3>
               <p>{{$property->description}}</p>

               <h4>Detalles para contribuir:</h4>
               <p>Se realizó la correspondiente tasación de la propiedad en un valor de U$D {{number_format($property->value, 0, ',', '.')}} y se emitieron 100.000 unidades del token TPI-BN-001 a un valor inicial de U$D {{number_format($property->value/100000, 0, ',', '.')}} c/u.</p>
               <p>El objetivo de la operación es captar fondos por {{number_format($property->value*0.4, 0, ',', '.')}} dólares mediante la licitación inicial del 40% de los tokens emitidos o 40.000 unidades (el resto permanecerán en la tenencia del original propietario).</p>
               <p>-Plazo - 2 años</p>
               <p>-Renta - U$D {{number_format($property->value*0.005, 0, ',', '.')}} el primer año y U$D {{number_format($property->value*0.006, 0, ',', '.')}} durante el segundo.</p>

               <h4>Plazos de Contribución:</h4>
               <p>Se puede contribuir al fondo de inversión de la propiedad durante el período comprendido entre {{(new DateTime('first day of this month'))->format("d-m-Y")}} y {{(new DateTime('first day of next month'))->format("d-m-Y")}}.</p>


           </section>

            <section class="decription">
                <h3> Detalle </h3>
                <p>Se trata de una casa en un barrio residencial de lujo en las afueras de {{$property->city}}.
                    La propiedad cuenta con un diseño moderno y está dispuesta sobre un amplio terreno.
                </p>

                <p>{{$property->description}}</p>
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