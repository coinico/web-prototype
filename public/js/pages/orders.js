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

$(document).ready(function(){

    var isLoggedIn = $("#userLoggedIn").val();

    if (isLoggedIn) {
        fillOpenOrdersTable();
        fillMyLastExecutedOrdersTable();
    }

});

function fillMyLastExecutedOrdersTable() {
    var myLastExecutedOrders = "./allMyLastExecutedOrders";
    $.get({
        url: myLastExecutedOrders,
        dataType: "json",
        success: function(res){

            $('#myLastExecutedOrders').DataTable( {
                "order": [],
                data: res,
                columnDefs: [
                    { "className": "dt-body-center", targets: [0, 1, 2, 3] },
                    { "className": "dt-body-right", targets: [4, 5, 6, 7, 8] }
                ],
                info: true,
                language: {
                    "info": "<div1 class='datatablesCustomTitle'>COMPLETADAS</div1>",
                    "infoEmpty": "<div1 class='datatablesCustomTitle'>COMPLETADAS</div1>"
                },
                columns:[
                    {},
                    {},
                    {
                        "mData":"Mercado",
                        "render": function ( mData, type,row, meta ) {
                            return '<a href="exchangeDetails?pair='+row[2]+'">' + row[2]+'</a>';
                        }
                    }
                ]
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
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

    var myOpenOrders = "./allMyOpenOrders";
    $.get({
        url: myOpenOrders,
        dataType: "json",
        success: function(res){

            myOpenOrdersDataTable = $('#myOpenOrders').DataTable( {
                "order": [],
                data: res,
                columnDefs: [
                    { "className": "dt-body-center", targets: [0, 1, 2] },
                    { "className": "dt-body-right", targets: [3, 4, 5, 6, 7, 8] }
                ],
                columns:[
                    {},
                    {
                        "mData":"Mercado",
                        "render": function ( mData, type,row, meta ) {
                            return '<a href="exchangeDetails?pair='+row[1]+'">' + row[1]+'</a>';
                        }
                    },
                    {},
                    {},
                    {},
                    {},
                    {},
                    {},
                    {
                        "mData":"Comprar/Vender",
                        "render": function ( mData, type,row, meta ) {
                            return '<a href="javascript:deleteOrder('+row[8]+')"><i class="fa fa-times" style="color:red"></i></a>';
                        }
                    }
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<div1 class='datatablesCustomTitle'>ABIERTAS</div1>",
                    "infoEmpty": "<div1 class='datatablesCustomTitle'>ABIERTAS</div1>"
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });
}