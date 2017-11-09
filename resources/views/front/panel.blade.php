@extends('front.layout')

@section('main')

   <section id="panel">
       <div class="row">
       <section class="sidebar">
            <div class="title">
                Su billetera
            </div>
            <div class="info items">
                @foreach ($standardWallets as $standardWallet)
                    @include('front.panel.wallet')
                @endforeach
            </div>
           <div class="divider"></div>
           <div class="title">
               Tokens de propiedad
           </div>
           <div class="info items">
               @foreach ($tokenWallets as $tokenWallet)
                   @include('front.panel.token')
               @endforeach
           </div>
       </section>
       <section class="main">
           <div class="tabs-selector">
               <div class="tab-selector active">Casatoken · 1,01 USD  </div>
               <div class="tab-selector">Ethereum · 267,87 USD</div>
           </div>
           <div class="tabs">
                <div class="tab active">
                    <div class="currency-info">
                        <div class="price">
                            <div>
                                <span>1,43 USD</span>
                                <small>PRECIO CASATOKEN</small>
                            </div>
                        </div>
                        <div class="variation">
                            <div>
                                <span><b>+</b>0,43 USD</span>
                                <small>DESDE EL MES PASADO (EUR)</small>
                            </div>
                        </div>
                        <div class="percent_variation">
                            <div>
                                <span><b>+</b>55.94%</span>
                                <small>DESDE EL MES PASADO (%)</small>
                            </div>
                        </div>
                    </div>
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
                <div class="tab">
                   <div class="currency-info">
                       <div class="price">
                           6.362,43 €
                           <small>PRECIO BITCOIN</small>
                       </div>
                       <div class="variation">
                           +2.283,03 €
                           <small>DESDE EL MES PASADO (EUR)</small>
                       </div>
                       <div class="percent_variation">
                           +55.94%
                           <small>DESDE EL MES PASADO (%)</small>
                       </div>
                   </div>
                   <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
           </div>
           <!--<div class="summary">
               <h3>Resumen</h3>
               <div class="">
                    <h4>Ethereum</h4>
                    <span>100,00000000</span>
                    <small>350,00000000 €</small>
               </div>
               <div class="">
                   <h4>CasaToken</h4>
                   <span>10,00000000</span>
                   <small>480,00000000 €</small>
               </div>
           </div>-->
       </section>
       </div>
   </section>

@endsection

@section('scripts')


    <script src="js/plugins/highcharts.js"></script>


    <script type="text/javascript">
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
                    name: 'USD to EUR',
                    data: data
                }]
            });
        });
    </script>

@stop