function depositar() {

    $("#tradeModalTitle").html("Depositar fondos");

    $("#confirm-trade-modal").attr("onclick", "confirmarDepositar()");

    $('#tradeModal').modal('show');
}

function retirar() {

    $("#tradeModalTitle").html("Retirar fondos");

    $("#confirm-trade-modal").attr("onclick", "confirmarRetirar()");

    $('#tradeModal').modal('show');
}

function modalMessage(type, message) {

    if (type === "error")
        message = "<font color=red>"+message+"</font>";


    $('#modaldata').html(message);
    $('#myModal').modal('show');
}