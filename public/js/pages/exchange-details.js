var chart = undefined;

$.extend( true, $.fn.dataTable.defaults, {
    dom: '<if<t>lp>',
    language: {
        "search": "",
        "lengthMenu": "_MENU_",
        "zeroRecords": "Cero resultados.",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay información disponible.",
        "infoFiltered": "(filtrados de _MAX_ registros en total)",
        "emptyTable": "Sin resultados.",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": '<i class="fa fa-arrow-right" aria-hidden="true" style="color: #4767af"></i>',
            "previous": '<i class="fa fa-arrow-left" aria-hidden="true" style="color: #4767af"></i>'
        }
    }
} );

function createBidOrder() {

    var quantity = parseFloat($("#unitsBid").val());
    var price = parseFloat($("#bidValue").val());
    var subTotal = quantity * price;
    var commission = subTotal * getCommission();
    var total = subTotal + commission;

    var balance = parseFloat($("#currencyFromBalance").val());

    if (total >= getMinimum()) {
        if (total <= balance) {

            $("#tradeModalTitle").html("Crear Orden de Compra");

            $("#modal-trade-cantidad").val(formatAsCurrency(quantity));
            $("#modal-trade-precio").val(formatAsCurrency(price));
            $("#modal-trade-subtotal").val(formatAsCurrency(subTotal));
            $("#modal-trade-comision").val(formatAsCurrency(commission));
            $("#modal-trade-total").val(formatAsCurrency(total));

            $("#confirm-trade-modal").attr("onclick", "confirmBidOrder()");

            $('#tradeModal').modal('show');

        } else {
            modalMessage("error", "No tienes fondos suficientes para generar la orden.");
        }
    } else {
        modalMessage("error", "La orden debe ser mayor al mínimo: "+getMinimum());
    }
}

function confirmBidOrder() {
    console.log("confirm bid order");

    var cantidad = $("#modal-trade-cantidad").val();
    var precio = $("#modal-trade-precio").val();
    var subtotal = $("#modal-trade-subtotal").val();
    var comision = $("#modal-trade-comision").val();
    var total = $("#modal-trade-total").val();

    var createBidOrder = "./createBidOrder";

    $.get({
        url: createBidOrder,
        data: {
            "cantidad": cantidad,
            "precio": precio,
            "subtotal": subtotal,
            "comision": comision,
            "total": total
        },
        dataType: "json",
        success: function(res){
            modalMessage(res.type, res.message);
        }
    }).done(function() {

    }).fail(function(data) {
        modalMessage("error", data);
    });
}

function confirmAskOrder() {

    var cantidad = $("#modal-trade-cantidad").val();
    var precio = $("#modal-trade-precio").val();
    var subtotal = $("#modal-trade-subtotal").val();
    var comision = $("#modal-trade-comision").val();
    var total = $("#modal-trade-total").val();

    var createAskOrder = "./createAskOrder";

    $.get({
        url: createAskOrder,
        data: {
            "cantidad": cantidad,
            "precio": precio,
            "subtotal": subtotal,
            "comision": comision,
            "total": total
        },
        dataType: "json",
        success: function(res){
            modalMessage(res.type, res.message);
        }
    }).done(function() {

    }).fail(function(data) {
        modalMessage("error", data);
    });
}

function createAskOrder() {

    var quantity = parseFloat($("#unitsAsk").val());
    var price = parseFloat($("#askValue").val());
    var subTotal = quantity * price;
    var commission = subTotal * getCommission();
    var total = subTotal - commission;

    var balance = parseFloat($("#currencyFromBalance").val());

    if (total >= getMinimum()) {
        if (total <= balance) {

            $("#tradeModalTitle").html("Crear Orden de Venta");

            $("#modal-trade-cantidad").val(formatAsCurrency(quantity));
            $("#modal-trade-precio").val(formatAsCurrency(price));
            $("#modal-trade-subtotal").val(formatAsCurrency(subTotal));
            $("#modal-trade-comision").val(formatAsCurrency(commission));
            $("#modal-trade-total").val(formatAsCurrency(total));

            $("#confirm-trade-modal").attr("onclick", "confirmAskOrder()");

            $('#tradeModal').modal('show');

        } else {
            modalMessage("error", "No tienes fondos suficientes para generar la orden.");
        }
    } else {
        modalMessage("error", "La orden debe ser mayor al mínimo: "+getMinimum());
    }
}

function getMinimum(){ return parseFloat($("#order-minimum-value").val()); }

function getCommission(){ return 0.0025; }

function formatAsCurrency(value) {
    return value.toFixed(8)
}

function priceChange(price) {
    bidPriceChange(price);
    askPriceChange(price);
}

function bidPriceChange(price) {
    $("#bidValue").val(formatAsCurrency(price));
    calculateBidTotal();
}

function askPriceChange(price) {
    $("#askValue").val(formatAsCurrency(price));
    calculateAskTotal();
}

function quantityChange(quantity) {
    $("#unitsBid").val(formatAsCurrency(quantity));
    $("#unitsAsk").val(formatAsCurrency(quantity));
    calculateTotals();
}

function calculateTotals() {
    calculateBidTotal();
    calculateAskTotal();
}

function calculateBidTotal() {

    var maxSelected = $("#maxBidBtn").hasClass("btnmax-selected");
    var balance = parseFloat($("#currencyFromBalance").val());
    var units = parseFloat($("#unitsBid").val());
    var value = parseFloat($("#bidValue").val());

    if (maxSelected) {
        if (balance !== 0 && value !== 0) {
            $("#unitsBid").val(formatAsCurrency(balance/(value*(1+getCommission()))));
            $("#totalBid").val(formatAsCurrency(balance));
        }
    } else {
        if (units !== 0 && value !== 0) {
            $("#totalBid").val(formatAsCurrency(units * (value*(1+getCommission()))));
        }
    }
}

function calculateAskTotal() {

    var maxSelected = $("#maxAskBtn").hasClass("btnmax-selected");
    var balance = parseFloat($("#currencyToBalance").val());
    var units = parseFloat($("#unitsAsk").val());
    var value = parseFloat($("#askValue").val());

    if (maxSelected) {
        if (balance !== 0 && value !== 0) {
            $("#unitsAsk").val(formatAsCurrency(balance/value));
            $("#totalAsk").val(formatAsCurrency(balance));
        }
    } else {
        if (units !== 0 && value !== 0) {
            $("#totalAsk").val(formatAsCurrency(units * (value*(1-getCommission()))));
        }
    }
}


function maxBidSelected() {
    if ($("#maxBidBtn").hasClass("btnmax-selected")) {
        $("#unitsBid").attr("disabled", false);
        $("#unitsBid").removeClass("units-selected");
        $("#totalBid").removeClass("units-selected");
        $("#maxBidBtn").removeClass("btnmax-selected");
    } else {
        $("#unitsBid").addClass("units-selected");
        $("#unitsBid").attr("disabled", true);
        $("#totalBid").addClass("units-selected");
        $("#maxBidBtn").addClass("btnmax-selected");
    }
    calculateTotals();
}

function maxAskSelected() {
    if ($("#maxAskBtn").hasClass("btnmax-selected")) {
        $("#maxAskBtn").removeClass("btnmax-selected");
        $("#totalAsk").removeClass("units-selected");
        $("#unitsAsk").attr("disabled", false);
        $("#unitsAsk").removeClass("units-selected");
    } else {
        $("#maxAskBtn").addClass("btnmax-selected");
        $("#unitsAsk").addClass("units-selected");
        $("#totalAsk").addClass("units-selected");
        $("#unitsAsk    ").attr("disabled", true);
    }
    calculateTotals();
}

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

    var isLoggedIn = $("#userLoggedIn").val();

    if (isLoggedIn) {
        fillOpenOrdersTable();
        fillMyLastExecutedOrdersTable();
    }

    fillAskOrdersTable();
    fillBidOrdersTable();
    fillLastExecutedOrdersTable();
    buildTestGraph();

});


function fillMyLastExecutedOrdersTable() {
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
                "order": [],
                data: res,
                columnDefs: [
                    { "className": "dt-body-center", targets: [0, 1, 2] },
                    { "className": "dt-body-right", targets: [3, 4, 5, 6, 7] }
                ],
                info: true,
                language: {
                    "info": "<div1 class='datatablesCustomTitle'>MI HISTORIAL DE ORDENES</div1>",
                    "infoEmpty": "<div1 class='datatablesCustomTitle'>MI HISTORIAL DE ORDENES</div1>"
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });
}


function fillLastExecutedOrdersTable() {
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
                "order": [],
                data: res,
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
                    },
                    {},
                    {},
                    {}
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<div1 class='datatablesCustomTitle'>HISTORIAL DEL MERCADO</div1>",
                    "infoEmpty": "<div1 class='datatablesCustomTitle'>HISTORIAL DEL MERCADO</div1>"
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });
}

function fillBidOrdersTable() {
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
                columnDefs: [
                    { "className": "dt-body-right", targets: [0, 1, 2, 3] }
                ],
                info: false,
                columns:[
                    {},
                    {},
                    {
                        "render": function ( mData, type,row, meta ) {
                            return "<papanata onclick='quantityChange("+row[2]+")'>"+row[2]+"</papanata>";
                        }
                    },
                    {
                        "render": function ( mData, type,row, meta ) {
                            return "<papanata onclick='priceChange("+row[3]+")'>"+row[3]+"</papanata>";
                        }
                    }
                ]
            });
        }
    });
}

function fillAskOrdersTable() {
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
                columnDefs: [
                    { "className": "dt-body-right", targets: [0, 1, 2, 3] }
                ],
                info: false,
                columns:[
                    {
                        "render": function ( mData, type,row, meta ) {
                            return "<papanata onclick='priceChange("+row[0]+")'>"+row[0]+"</papanata>";
                        }
                    },
                    {
                        "render": function ( mData, type,row, meta ) {
                            return "<papanata onclick='quantityChange("+row[1]+")'>"+row[1]+"</papanata>";
                        }
                    }
                ]
            });
        }
    });

}

function deleteOrder(id) {

    var deleteOrder = "./deleteOrder";
    $.get({
        url: deleteOrder,
        data: {
            "orderId": id
        },
        dataType: "json",
        success: function(res){
            modalMessage(res.type, res.message);
            fillOpenOrdersTable();
        }
    }).fail(function(data) {
        modalMessage("error", data);
    });
}


function modalMessage(type, message) {

    if (type === "error")
        message = "<font color=red>"+message+"</font>";


    $('#modaldata').html(message);
    $('#myModal').modal('show');
}

var myOpenOrdersDataTable = undefined;

function fillOpenOrdersTable() {

    if (myOpenOrdersDataTable !== undefined)
        myOpenOrdersDataTable.destroy();

    var myOpenOrders = "./myOpenOrders";
    $.get({
        url: myOpenOrders,
        data: {
            "currencyFrom": $("#currencyFrom").val(),
            "currencyTo": $("#currencyTo").val()
        },
        dataType: "json",
        success: function(res){

            myOpenOrdersDataTable = $('#myOpenOrders').DataTable( {
                "order": [],
                data: res,
                columnDefs: [
                    { "className": "dt-body-center", targets: [0, 1] },
                    { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7] }
                ],
                columns:[
                    {},
                    {},
                    {},
                    {},
                    {},
                    {},
                    {},
                    {
                        "mData":"Comprar/Vender",
                        "render": function ( mData, type,row, meta ) {
                            return '<a href="javascript:deleteOrder('+row[7]+')"><i class="fa fa-times" style="color:red"></i></a>';
                        }
                    }
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<div1 class='datatablesCustomTitle'>MIS ORDENES ABIERTAS</div1>",
                    "infoEmpty": "<div1 class='datatablesCustomTitle'>MIS ORDENES ABIERTAS</div1>"
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });
}

function buildTestGraph() {

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
}