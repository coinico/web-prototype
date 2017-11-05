$(document).ready(function(){
    //$('.properties .wrap')@todo: min height algh
    $('#horizontal-view-btn').click(function(e){
        e.preventDefault();
        $('#properties').addClass('horizontal-view');
    });

    $('#normal-view-btn').click(function(e){
        e.preventDefault();
        $('#properties').removeClass('horizontal-view');
    });

    //Timer
    setInterval(function(){
        $('.time_left').each(function(){
            var days =  Number($(this).find('.days').html());
            var hs =  Number($(this).find('.hs').html());
            var min = Number($(this).find('.min').html()) -1;
            if(min == -1){
                min = 59;
                hs =  Number($(this).find('.hs').html()) - 1;
                if(hs == -1){
                    hs = 23;
                    days =  Number($(this).find('.days').html()) - 1;
                    if(days == -1){
                        min = hs = days = 0;
                    }
                }
            }
            $(this).find('.min').html(min);
            $(this).find('.hs').html(hs);
            $(this).find('.days').html(days);
        });

    }, 1000);
});