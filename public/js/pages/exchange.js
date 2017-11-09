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

    var ctfMarketsUrl = "./ctfMarkets";
    $.get({
        url: ctfMarketsUrl,
        dataType: "json",
        success: function(res){

            $('#ctf').DataTable( {
                data: res,
                order: [[ 2, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-center", targets: [0, 1]},
                    { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7]}
                ],
                language: {
                    "info": "<strong>Mercados CasaToken</strong>"
                }
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

});