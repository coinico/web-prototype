$(document).ready(function(){
    var url = "./markets";
    $.get({
        url: url,
        dataType: "json",
        success: function(res){
            $('#btc').DataTable( {
                data: res.BTC,
                order: [[ 2, "desc" ]],
                columnDefs: [
                    { "className": "dt-body-left", targets: [0, 1, 8]},
                    { "className": "dt-body-right", targets: [2, 3, 4, 5, 6, 7]}
                ],
                language: {
                    "search": ""
                },
                lengthChange: false,
                caption: {
                    html: "BTC MARKET"
                }
            });
            $('#eth').DataTable( {
                data: res.ETH,
                order: [[ 2, "desc" ]]
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

});