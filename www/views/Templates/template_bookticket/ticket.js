$(document).ready(function () {
    $("#bookticket-ticket-main-number-regular-quantity").bind('keyup mouseup', function () {
        $regularPrice = parseInt($("#bookticket-ticket-main-number-regular-price").html());
        $regularQuantity = $("#bookticket-ticket-main-number-regular-quantity").find("input").val();
        $couplePrice = parseInt($("#bookticket-ticket-main-number-couple-price").html());
        $coupleQuantity = $("#bookticket-ticket-main-number-couple-quantity").find("input").val();
        $("#bookticket-ticket-main-number-regular-sum").html($regularPrice * $regularQuantity)
        $("#bookticket-ticket-main-cart-regular-total").html($regularPrice * $regularQuantity)
        $("#bookticket-ticket-main-cart-total-price").html($regularPrice * $regularQuantity + $couplePrice * $coupleQuantity)
    });
    $("#bookticket-ticket-main-number-couple-quantity").bind('keyup mouseup', function () {
        $regularPrice = parseInt($("#bookticket-ticket-main-number-regular-price").html());
        $regularQuantity = $("#bookticket-ticket-main-number-regular-quantity").find("input").val();
        $couplePrice = parseInt($("#bookticket-ticket-main-number-couple-price").html());
        $coupleQuantity = $("#bookticket-ticket-main-number-couple-quantity").find("input").val();
        $("#bookticket-ticket-main-number-couple-sum").html($couplePrice * $coupleQuantity)
        $("#bookticket-ticket-main-cart-couple-total").html($couplePrice * $coupleQuantity)
        $("#bookticket-ticket-main-cart-total-price").html($regularPrice * $regularQuantity + $couplePrice * $coupleQuantity)
    });
})