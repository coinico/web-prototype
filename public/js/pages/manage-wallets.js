function depositar() {

    $('#deposit-modal').modal('show');
}

function depositarVirtual() {

    $('#deposit-modal-virtual').modal('show');
}

function retirar() {

    $('#withdraw-modal').modal('show');
}

function modalMessage(type, message) {

    if (type === "error")
        message = "<font color=red>"+message+"</font>";


    $('#modaldata').html(message);
    $('#myModal').modal('show');
}

$(document).ready(function(){

    var message = $("#result-message").val();

    if (message !== "")
        modalMessage("success", message);

});