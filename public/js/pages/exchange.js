$(document).ready(function(){
    var url = "./markets";
    $.get({
        url: url,
        dataType: "json",
        success: function(res){
            $('#btc').DataTable( {
                data: res.BTC,
                order: [[ 2, "desc" ]]
            });
            $('#eth').DataTable( {
                data: res.ETH,
                order: [[ 2, "desc" ]]
            });
            $('#usdt').DataTable( {
                data: res.USDT,
                order: [[ 2, "desc" ]]
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

});