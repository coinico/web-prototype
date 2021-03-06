@extends('front.layout')

@section('main')

   <section id="panel">

       <div class="row">
       <section class="sidebar">
            <div class="title">
                Mis billeteras
            </div>
            <div class="info items">
                @foreach ($standardWallets as $standardWallet)
                    @include('front.panel.wallet')
                @endforeach
            </div>
           <div class="divider"></div>
           <div class="title">
               Mis Tokens de Propiedad
           </div>
           <div class="info items">
               @foreach ($tokenWallets as $tokenWallet)
                   @include('front.panel.token')
               @endforeach
           </div>
           <div class="divider"></div>
           <div class="title">
               Mis Contribuciones
           </div>
           <div class="info items">
               @foreach ($investments as $investment)
                   @include('front.panel.investment')
               @endforeach
           </div>
       </section>
       <section class="main">

           <div class="row sopenco">
               <h1>¡Hola {{$user->name}}! Bienvenido a CasaToken (DEMO)</h1>
               <div class="message">
                   <!--También creamos una propiedad a tu nombre, la misma será sometida a votación entre los miembros de la plataforma. De ser aprobada, podrás verla en tu panel de inversión.</br></br>-->
                   <!--Déjanos ayudarte a empezar a interactuar con la plataforma haciendo click <a href="#" onclick="startIntro()"> <strong><u>aquí</u></strong>  </a>-->
                   ¿Quieres saber de que se trata?, Haz click <a href="#" onclick="startIntro()"><strong><u>aquí</u></strong></a> para comenzar el tutorial.
              </div>
          </div>
          <div class="row sopenco">
          <div class="tabs-selector">
              <div class="tab-selector active">{{$standardWallets->last()->currency->name}} ({{$standardWallets->last()->currency->alias}}) · {{$standardWallets->last()->currency->usd_value}} USD  </div>
              <div class="tab-selector">{{$standardWallets->first()->currency->name}} ({{$standardWallets->first()->currency->alias}}) · {{$standardWallets->first()->currency->usd_value}} USD</div>
          </div>
          <div class="tabs">
               <div class="tab active">
                   <div class="currency-info">
                       <div class="price">
                           <div>
                               <span>{{$standardWallets->last()->currency->usd_value}} USD</span>
                               <small>PRECIO CTK</small>
                           </div>
                       </div>
                       <div class="variation">
                           <div>
                               <span><b>+</b>0,23 USD</span>
                               <small>DESDE EL MES PASADO (USD)</small>
                           </div>
                       </div>
                       <div class="percent_variation">
                           <div>
                               <span><b>+</b>23.00%</span>
                               <small>DESDE EL MES PASADO (%)</small>
                           </div>
                       </div>
                   </div>
                   <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
               </div>
               <div class="tab">
                  <div class="currency-info">
                      <div class="price">
                          362,43 €
                          <small>PRECIO ETHEREUM</small>
                      </div>
                      <div class="variation">
                          +83,03 €
                          <small>DESDE EL MES PASADO (ETH)</small>
                      </div>
                      <div class="percent_variation">
                          +22.94%
                          <small>DESDE EL MES PASADO (%)</small>
                      </div>
                  </div>
                  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
               </div>
          </div>
          <div class="divider"></div>
           </div>
       </section>
       </div>
   </section>

@endsection

@section('scripts')


    <script src="js/plugins/highcharts.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            //$.getJSON('https://api.coinbase.com/v2/prices/BTC-EUR/historic?period=month', function (data) {
        $.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=usdeur.json&callback=?', function (data) {
            Highcharts.chart('container', {
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: ''
                },
                subtitle: {

                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillOpacity: 0.1,
                        marker: {
                            radius: 2
                        },
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },

                series: [{
                    type: 'area',
                    name: 'CTK to USD',
                    data: data
                }]
            });
        });
        });

        function startIntro(){
            var intro = introJs();
            intro.setOptions({
                steps: [
                    {
                        element: '.sidebar',
                        intro: "Aquí encontrarás el balance de tus billeteras, tokens de propiedad y tus contribuciones activas.",
                        position: "left"
                    },
                    {
                        element: ".info.items",
                        intro: "¡Podrás acceder a la administración de las mismas dándoles un click!"
                    },
                    {
                        element: "#top",
                        intro: "¡Vamos a ver tus billeteras!"
                    }
                ],
                doneLabel : "Pág. sig."
            }).oncomplete(function() {
                window.location.href = '/wallets?tuto=true';
            });

            intro.start();
        }
    </script>

@stop