$(document).ready(function(){
    //$('.properties .wrap')@todo: min height algorithm


    /** Views **/
    $('#horizontal-view-btn').click(function(e){
        e.preventDefault();
        $('#properties').addClass('horizontal-view');
    });

    $('#normal-view-btn').click(function(e){
        e.preventDefault();
        $('#properties').removeClass('horizontal-view');
    });

    /** Timer **/
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

    /** Votes **/
    $('.vote a').click(function(e){
        e.preventDefault();
        var btn = $(this);
        var wrapper = $(this).closest('.vote');
        var url = wrapper.attr('data-url');
        var vote = $(this).parent().hasClass('up') ? '1' : '-1';
        wrapper.find('a').removeClass('selected');
        btn.addClass('selected');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            data: {vote:vote},
            method: 'POST',
            success: function(result){
                console.log(result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var status = xhr.status;
                if(status == 419) {
                    alert("Debes iniciar sesión para votar");
                }
                btn.removeClass('selected');
            }
        });

    });

});