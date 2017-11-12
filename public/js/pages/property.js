$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        loop: true,
        autoplay:true,
        autoplayTimeout:3000,
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

    $("a#view-plans").fancybox();

    $('#edit-investment').click(function(e){
        e.preventDefault();
        var input = $(this).closest('.item').find('input');
        input.removeAttr('readonly').focus();
        input.val(Number(input.val()));
        input.attr('type','number');
    });

    $('fieldset a').click(function(e){
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
                    location.reload();
                },2000);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var status = xhr.status;
                if(status == 401) {
                    alert("Debes iniciar sesión para votar");
                    return;
                }
                if(status == 400) {
                    alert("Tu saldo no es suficiente");
                    return;
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
            $('fieldset a').click();
    });


});