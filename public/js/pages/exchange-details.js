
$(document).ready(function(){

    $.extend( $.fn.dataTable.defaults, {
            order: [[ 2, "desc" ]],
            columnDefs: [
                { "className": "dt-body-left", targets: [0] },
                { "className": "dt-body-center", targets: [1] },
                { "className": "dt-body-right", targets: [2, 3, 4] }
            ],
            info: true,
            dom: '<if<t>lp>',
            language: {
                "search": "",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": '<i class="fa fa-arrow-right" aria-hidden="true" style="color: #4767af"></i>',
                    "previous": '<i class="fa fa-arrow-left" aria-hidden="true" style="color: #4767af"></i>'
                }
            }
        }
    );

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
                language: {
                    "info": "<strong>Últimas órdenes ejecutadas</strong>"
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

});