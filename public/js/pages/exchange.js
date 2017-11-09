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
                    { "className": "dt-body-center", targets: [0, 1]},
                    { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7]}
                ],
                columns:[
                    {
                        "mData":"Mercado",
                        "render": function ( mData, type,row, meta ) {
                            return '<a href="exchangeDetails?pair='+row[0]+'">' + row[0]+'</a>';
                        }
                    }
                ],
                info: true,
                dom: '<if<t>lp>',
                language: {
                    "info": "<strong>Mercados CasaToken</strong>",
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

    $(".owl-carousel").owlCarousel({
        loop: true,
        autoplay:true,
        autoplayTimeout:3000,
        responsive : {
            0 : {
                items:1
            },

            480 : {
                items:2
            },

            768 : {
                items:3
            },
            992 :{
                items:4
            }
        }
    });

});

