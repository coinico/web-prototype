$(document).ready(function(){
    //$('.properties .wrap')@todo: min height algorithm

    function standarHeight() {
        var height = 0;
        $('#properties .property').each(function () {
            $(this).css('height', 'auto');
            if (height < $(this).outerHeight()) {
                height = $(this).outerHeight();
            }
        });

        $('#properties .property').each(function () {
            $(this).css('height', height+10);
        });
    }

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
    }, 1000*60);

    /** Votes **/
    $('.vote a').click(function(e){
        e.preventDefault();
        var btn = $(this);
        var wrapper = $(this).closest('.vote');
        var url = wrapper.attr('data-url');
        var vote = $(this).parent().hasClass('up') ? '1' : '-1';

        if(!$(this).hasClass('selected') && wrapper.find('.selected').length){
            var votes = $(this).parent().find('small');
            votes.html(Number(votes.html())+1);
            votes = wrapper.find('.selected').parent().find('small');
            votes.html(Number(votes.html())-1);
        }

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
                //
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var status = xhr.status;
                if(status == 401) {
                    alert("Debes iniciar sesión para votar");
                }
                btn.removeClass('selected');
            }
        });

    });


    /** Invest **/
    $('.invest a').click(function(e){
        e.preventDefault();
        var btn = $(this);
        var wrapper = $(this).closest('.invest');
        var url = wrapper.attr('data-url');
        var parent = $(this).parent();
        var value = $(this).parent().find('input').val();

        $(this).addClass('loading');
        $(this).find('i').attr('class','fa fa-circle-o-notch fa-spin');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            data: {value:value},
            method: 'POST',
            success: function(result){
                btn.find('i').attr('class','fa fa-check');
                setTimeout(function(){
                    btn.removeClass('loading');
                    btn.find('i').attr('class','fa fa-paper-plane');
                },2000);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var status = xhr.status;
                if(status == 401) {
                    alert("Debes iniciar sesión para votar");
                }else{
                    console.log(xhr);
                }
                btn.find('i').attr('class','fa fa-times');
                setTimeout(function(){
                    btn.removeClass('loading');
                    btn.find('i').attr('class','fa fa-paper-plane');
                },2000);
            }
        });
    });

    $('.invest input').keydown(function(e){
        if(e.which==13)
            $('.invest a').click();
    });

    standarHeight();

    $(window).resize(function(){
        standarHeight();
    });

});

