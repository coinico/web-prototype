$(document).ready(function(){
    var url = "./markets";
    $.get({
        url: url,
        dataType: "json",
        success: function(res){
            $('#btc').DataTable( {
                data: res.BTC
            });
            $('#eth').DataTable( {
                data: res.ETH
            });
            $('#usdt').DataTable( {
                data: res.USDT
            });
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

});