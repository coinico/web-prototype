var chart = undefined;

function seeHideVolume() {
    if ($("#seeHideVolumeButton").hasClass("seeingVolume")) {
        removePanel();
        $("#seeHideVolumeButton").removeClass("seeingVolume");
    } else {
        addPanel();
        $("#seeHideVolumeButton").addClass("seeingVolume");
    }
}

function addPanel() {
    var chart = AmCharts.charts[ 0 ];
    if ( chart.panels.length == 1 ) {
        var newPanel = new AmCharts.StockPanel();
        newPanel.allowTurningOff = true;
        newPanel.title = "Volume";
        newPanel.showCategoryAxis = false;

        var graph = new AmCharts.StockGraph();
        graph.valueField = "volume";
        graph.fillAlphas = 0.15;
        newPanel.addStockGraph( graph );

        var legend = new AmCharts.StockLegend();
        legend.markerType = "none";
        legend.markerSize = 0;
        newPanel.stockLegend = legend;

        chart.addPanelAt( newPanel, 1 );
        chart.validateNow();
    }
}

function removePanel() {
    var chart = AmCharts.charts[ 0 ];
    if ( chart.panels.length > 1 ) {
        chart.removePanel( chart.panels[ 1 ] );
        chart.validateNow();
    }
}

$(document).ready(function(){

    var chartData = [];

    function generateChartData() {
        var firstDate = new Date();
        firstDate.setHours( 0, 0, 0, 0 );
        firstDate.setDate( firstDate.getDate() - 50 );

        for ( var i = 0; i < 100; i++ ) {
            var newDate = new Date( firstDate );

            newDate.setDate( newDate.getDate() + i );

            var open = Math.round( Math.random() * ( 30 ) + 100 );
            var close = open + Math.round( Math.random() * ( 15 ) - Math.random() * 10 );

            var low;
            if ( open < close ) {
                low = open - Math.round( Math.random() * 5 );
            } else {
                low = close - Math.round( Math.random() * 5 );
            }

            var high;
            if ( open < close ) {
                high = close + Math.round( Math.random() * 5 );
            } else {
                high = open + Math.round( Math.random() * 5 );
            }

            var volume = Math.round( Math.random() * ( 1000 + i ) ) + 100 + i;


            chartData[ i ] = ( {
                "date": newDate,
                "open": open,
                "close": close,
                "high": high,
                "low": low,
                "volume": volume
            } );
        }
    }

    generateChartData();

    chart = AmCharts.makeChart( "chartdiv", {
        "type": "stock",
        "theme": "light",
        "dataSets": [ {
            "fieldMappings": [ {
                "fromField": "open",
                "toField": "open"
            }, {
                "fromField": "close",
                "toField": "close"
            }, {
                "fromField": "high",
                "toField": "high"
            }, {
                "fromField": "low",
                "toField": "low"
            }, {
                "fromField": "volume",
                "toField": "volume"
            }, {
                "fromField": "value",
                "toField": "value"
            } ],
            "color": "#7f8da9",
            "dataProvider": chartData,
            "categoryField": "date"
        } ],
        "balloon": {
            "horizontalPadding": 13
        },
        "panels": [ {
            "title": "Value",
            "stockGraphs": [ {
                "id": "g1",
                "type": "candlestick",
                "openField": "open",
                "closeField": "close",
                "highField": "high",
                "lowField": "low",
                "valueField": "close",
                "lineColor": "#7f8da9",
                "fillColors": "#7f8da9",
                "negativeLineColor": "#db4c3c",
                "negativeFillColors": "#db4c3c",
                "fillAlphas": 1,
                "balloonText": "Apertura:<b>[[open]]</b><br>Cierre:<b>[[close]]</b><br>Baja:<b>[[low]]</b><br>Alta:<b>[[high]]</b>",
                "useDataSetColors": false
            } ]
        } ],
        "scrollBarSettings": {
            "graphType": "line",
            "usePeriod": "WW"
        },
        "panelsSettings": {
            "panEventsEnabled": true
        },
        "cursorSettings": {
            "valueBalloonsEnabled": true,
            "valueLineBalloonEnabled": true,
            "valueLineEnabled": true
        },
        "periodSelector": {
            "position": "bottom",
            "periods": [
                {
                    "period": "mm",
                    "count": 30,
                    "label": "30 Minutos"
                },
                {
                    "period": "hh",
                    "count": 1,
                    "label": "1 hora"
                },
                {
                    "period": "D",
                    "count": 1,
                    "label": "1 día"
                },
                {
                    "period": "DD",
                    "count": 10,
                    "label": "10 días"
                }, {
                    "period": "MM",
                    "selected": true,
                    "count": 1,
                    "label": "1 mes"
                }, {
                    "period": "YYYY",
                    "count": 1,
                    "label": "1 año"
                }, {
                    "period": "YTD",
                    "label": "YTD"
                }, {
                    "period": "MAX",
                    "label": "MAX"
                }
            ]
        }
    } );

    var askOrders = "./askOrders";
    $.get({
        url: askOrders,
        data: {
            "currencyFrom": $("#currencyFrom").val(),
            "currencyTo": $("#currencyTo").val()
        },
        dataType: "json",
        success: function(res){

            $('#order_book_ask').DataTable( {
                "ordering": false,
                "searching": false,
                data: res,
                order: [[ 0, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-right", targets: [0, 1, 2, 3] }
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<strong>Órdenes de Venta</strong>",
                    "search": "",
                    "lengthMenu": "_MENU_",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última",
                        "next": '<i class="fa fa-arrow-right" aria-hidden="true" style="color: #4767af"></i>',
                        "previous": '<i class="fa fa-arrow-left" aria-hidden="true" style="color: #4767af"></i>'
                    }
                }
            });
        }
    });

    var bidOrders = "./bidOrders";
    $.get({
        url: bidOrders,
        data: {
            "currencyFrom": $("#currencyFrom").val(),
            "currencyTo": $("#currencyTo").val()
        },
        dataType: "json",
        success: function(res){

            $('#order_book_bid').DataTable( {
                "searching": false,
                "ordering": false,
                data: res,
                order: [[ 0, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-right", targets: [0, 1, 2, 3] }
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<strong>Órdenes de Compra</strong>",
                    "search": "",
                    "lengthMenu": "_MENU_",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última",
                        "next": '<i class="fa fa-arrow-right" aria-hidden="true" style="color: #4767af"></i>',
                        "previous": '<i class="fa fa-arrow-left" aria-hidden="true" style="color: #4767af"></i>'
                    }
                }
            });
        }
    });


    var lastExecutedOrders = "./lastExecutedOrders";
    $.get({
        url: lastExecutedOrders,
        data: {
            "currencyFrom": $("#currencyFrom").val(),
            "currencyTo": $("#currencyTo").val()
        },
        dataType: "json",
        success: function(res){

            $('#lastExecutedOrders').DataTable( {
                data: res,
                order: [[ 0, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-left", targets: [0] },
                    { "className": "dt-body-center", targets: [1] },
                    { "className": "dt-body-right", targets: [2, 3, 4] }
                ],
                columns:[
                    {},
                    {
                        "mData":"Comprar/Vender",
                        "render": function ( mData, type,row, meta ) {
                            if (row[1]  === "buy") {
                                return '<font color="green">BUY </font><img class="arrow_percent" src="/images/up_arrow.png"/>';
                            } else {
                                return '<font color="red">SELL </font><img class="arrow_percent" src="/images/down_arrow.png"/>';
                            }
                        }
                    }
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<strong>Últimas órdenes ejecutadas</strong>",
                    "search": "",
                    "lengthMenu": "_MENU_",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": '<i class="fa fa-arrow-right" aria-hidden="true" style="color: #4767af"></i>',
                        "previous": '<i class="fa fa-arrow-left" aria-hidden="true" style="color: #4767af"></i>'
                    }
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

    var myLastExecutedOrders = "./myLastExecutedOrders";
    $.get({
        url: myLastExecutedOrders,
        data: {
            "currencyFrom": $("#currencyFrom").val(),
            "currencyTo": $("#currencyTo").val()
        },
        dataType: "json",
        success: function(res){

            $('#myLastExecutedOrders').DataTable( {
                data: res,
                order: [[ 0, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-center", targets: [0, 1, 2] },
                    { "className": "dt-body-right", targets: [3, 4, 5, 6, 7] }
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<strong>Mis Últimas Órdenes</strong>",
                    "search": "",
                    "lengthMenu": "_MENU_",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": '<i class="fa fa-arrow-right" aria-hidden="true" style="color: #4767af"></i>',
                        "previous": '<i class="fa fa-arrow-left" aria-hidden="true" style="color: #4767af"></i>'
                    }
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });
});