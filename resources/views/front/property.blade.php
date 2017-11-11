@extends('front.layout')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery.fancybox.min.css') }}">
@stop

@section('main')

   <section id="property">
       <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:35%; text-align: center">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div id="modaldata" class="modal-body" style="text-align: center">
                   </div>
               </div>
           </div>
       </div>

       <div class="row">
            <h1> {{$property->title}} <span>U$D {{number_format($property->value, 0, ',', '.')}}</span></h1>
            <img src="/images/properties/{{$property->images}}" class="main-image" />

           @if($property->status_id ==1)

               <div class="voting">

               </div>

           @elseif($property->status_id ==4)

               <div class="investment">
                   <div class="item-wrap">
                       <div class="item invest"  data-url="/property/{{ $property->id }}/invest">
                           <h3>Tu inversión <a href="#" id="edit-investment"> <i class="fa fa-pencil" aria-hidden="true"></i> </a></h3>
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

           @endif

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
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5524.64798195098!2d-58.40872520702281!3d-34.57949042016931!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb57b47c8a597%3A0x90b984b5e107f8!2sAv.+del+Libertador+2600%2C+Buenos+Aires%2C+Argentina!5e0!3m2!1ses-419!2sfr!4v1510095957268" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </section>

        </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/plugins/owl.carousel.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.fancybox.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/plugins/modal.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/pages/property.js') }}" ></script>
@stop