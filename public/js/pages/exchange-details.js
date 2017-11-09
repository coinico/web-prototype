
$(document).ready(function(){

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