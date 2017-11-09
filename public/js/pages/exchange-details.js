
var $currencyFrom = "<?php Print($currencyFrom->id); ?>";
var $currencyTo = "<?php Print($currencyTo->id); ?>";

$(document).ready(function(){

    $.extend( $.fn.dataTable.defaults, {
            order: [[ 2, "desc" ]],
            columnDefs: [
                { "className": "dt-body-left", targets: [0, 1, 8] },
                { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7] }
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
            "currencyFrom": $currencyFrom,
            "$currencyTo": $currencyTo
        },
        dataType: "json",
        success: function(res){

            $('#lastExecutedOrders').DataTable( {
                data: res,
                order: [[ 2, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-center", targets: [0, 1]},
                    { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7]}
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