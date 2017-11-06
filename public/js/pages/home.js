$(document).ready(function(){
    console.log("Home");
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
});