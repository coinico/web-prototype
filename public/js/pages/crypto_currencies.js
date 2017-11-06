$(document).ready(function(){

    /** Views **/
    $('#horizontal-view-btn').click(function(e){
        e.preventDefault();
        $('#crypto_currencies').addClass('horizontal-view');
    });

    $('#normal-view-btn').click(function(e){
        e.preventDefault();
        $('#crypto_currencies').removeClass('horizontal-view');
    });

});