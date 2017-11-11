$(document).ready(function() {

    /** Views **/
    $('#wallets-horizontal-view-btn').click(function (e) {
        e.preventDefault();
        $('.wallets').addClass('horizontal-view');
    });

    $('#wallets-normal-view-btn').click(function (e) {
        e.preventDefault();
        $('.wallets').removeClass('horizontal-view');
    });

    $('#tokens-horizontal-view-btn').click(function (e) {
        e.preventDefault();
        $('.tokens').addClass('horizontal-view');
    });

    $('#tokens-normal-view-btn').click(function (e) {
        e.preventDefault();
        $('.tokens').removeClass('horizontal-view');
    });
    
});