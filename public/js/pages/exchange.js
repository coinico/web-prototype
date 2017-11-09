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
                    },{},{},
                    {
                        "mData":"Cambio",
                        "render": function ( mData, type,row, meta ) {
                            var changeStringNumber = row[3].substring(0, row[3].length-1);
                            var floatChange = parseFloat(changeStringNumber);
                            if (floatChange  !== 0.0) {
                                var changevalueAndColor = (floatChange > 0) ? '<font color="green">'+row[3]+'</font>' : '<font color="red">'+row[3]+'</font>';
                                return changevalueAndColor + ' <img class="arrow_percent" src="/images/'+(floatChange > 0 ? 'up_arrow.png' : 'down_arrow.png')+'"></img>';
                            }

                            return row[3] + ' <img class="arrow_percent" src="/images/leftandright.png"></img>';
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
        autoplayTimeout:5000,
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

