$(document).ready(function(){
    //$('.properties .wrap')@todo: min height algh
    $('#horizontal-view-btn').click(function(e){
        e.preventDefault();
        $('#properties').addClass('horizontal-view');
    });

    $('#normal-view-btn').click(function(e){
        e.preventDefault();
        $('#properties').removeClass('horizontal-view');
    })
});