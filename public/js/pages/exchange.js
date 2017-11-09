$(document).ready(function(){

    var ctfMarketsUrl = "./ctfMarkets";
    $.get({
        url: ctfMarketsUrl,
        dataType: "json",
        success: function(res){
            $('#ctf').DataTable( {
                data: res,
                order: [[ 2, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-left", targets: [0, 1]},
                    { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7]}
                ],
                language: {
                    "search": ""
                },
                lengthChange: false,
                caption: {
                    html: "Mercado CasaToken"
                }
            });
        }
    });


    var url = "./markets";
    $.get({
        url: url,
        dataType: "json",
        success: function(res){
            $.extend( $.fn.dataTable.defaults, {
                order: [[ 2, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-left", targets: [0, 1, 8] },
                    { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7] }
                ],
                info: true,
                dom: '<if<t>lp>',
                // lengthChange: false,
                language: {
                    // "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
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

            $('#btc').DataTable( {
                data: res.BTC,
                language: {
                    "info": "<strong>BITCOIN MARKET</strong>"
                }
            });
            $('#eth').DataTable( {
                data: res.ETH,
                language: {
                    "info": "<strong>ETHEREUM MARKET</strong>"
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

});