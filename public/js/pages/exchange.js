$(document).ready(function(){
    var url = "./markets";
    $.get({
        url: url,
        dataType: "json",
        success: function(res){
            var data = [];
            $.each(res.result, function(){
                var value = [];
                for (var prop in this.Summary) {
                    value.push(this.Summary[prop]);
                }
                data.push(value);
            });
            $('#markets').DataTable( {
                data: data
            } );
        }
    }).done(function() {
        $( this ).addClass( "done" );
    });

});