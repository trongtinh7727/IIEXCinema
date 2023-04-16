$(document).ready(function () {
    $regularPrice = parseInt($("#bookticket-ticket-main-number-regular-price").html());
    $("#bookticket-ticket-main-number-regular-quantity").bind('keyup mouseup', function () {
        $regularQuantity = $("#bookticket-ticket-main-number-regular-quantity").find("input").val();
        $("#bookticket-ticket-main-number-regular-sum").html($regularPrice * $regularQuantity)
    });
    $couplePrice = parseInt($("#bookticket-ticket-main-number-couple-price").html());
    $("#bookticket-ticket-main-number-couple-quantity").bind('keyup mouseup', function () {
        $coupleQuantity = $("#bookticket-ticket-main-number-couple-quantity").find("input").val();
        $("#bookticket-ticket-main-number-couple-sum").html($couplePrice * $coupleQuantity)
    });
})