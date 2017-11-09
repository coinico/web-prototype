
$(document).ready(function(){

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

});