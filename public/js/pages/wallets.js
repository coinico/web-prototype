function walletOnClick() {
    if ($('.wallets').hasClass("horizontal-view")) {
        $('#wallets-normal-view-btn').click();
    } else {
        $('#wallets-horizontal-view-btn').click();
    }
}

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

    lightwallet.keystore.createVault({password:"password"}, function(err, vault) {

        vault.keyFromPassword("password", function (err, pwDerivedKey) {
            if (err) throw err;
            var seed = "case hire near rocket raccoon bar put glide million interest scatter muffin";
            var hdPathString = "m/0'/0'/0'";
            var keystore = new lightwallet.keystore(seed, pwDerivedKey, hdPathString);

            keystore.generateNewAddress(pwDerivedKey);
            var address = keystore.getAddresses()[0];
            $('.address').html(address);
        });

    });

});