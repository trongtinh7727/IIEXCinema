$(document).ready(function () {
    function addCommas(str) {
        str += '';
        x = str.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    function parseNumber(str) {
        return parseInt(str.replaceAll(',', ''));
    }
    $("#bookticket-ticket-main-number-regular-quantity").bind('keyup mouseup', function () {
        $regularPrice = parseNumber($("#bookticket-ticket-main-number-regular-price").html());
        $regularQuantity = $("#bookticket-ticket-main-number-regular-quantity").find("input").val();
        $couplePrice = parseNumber($("#bookticket-ticket-main-number-couple-price").html());
        $coupleQuantity = $("#bookticket-ticket-main-number-couple-quantity").find("input").val();
        $("#bookticket-ticket-main-number-regular-sum").html(addCommas($regularPrice * $regularQuantity))
        $("#bookticket-ticket-main-cart-regular-total").html(addCommas($regularPrice * $regularQuantity))
        $("#bookticket-ticket-main-cart-total-price").html(addCommas($regularPrice * $regularQuantity + $couplePrice * $coupleQuantity))
    });
    $("#bookticket-ticket-main-number-couple-quantity").bind('keyup mouseup', function () {
        $regularPrice = parseNumber($("#bookticket-ticket-main-number-regular-price").html());
        $regularQuantity = $("#bookticket-ticket-main-number-regular-quantity").find("input").val();
        $couplePrice = parseNumber($("#bookticket-ticket-main-number-couple-price").html());
        $coupleQuantity = $("#bookticket-ticket-main-number-couple-quantity").find("input").val();
        $("#bookticket-ticket-main-number-couple-sum").html(addCommas($couplePrice * $coupleQuantity))
        $("#bookticket-ticket-main-cart-couple-total").html(addCommas($couplePrice * $coupleQuantity))
        $("#bookticket-ticket-main-cart-total-price").html(addCommas($regularPrice * $regularQuantity + $couplePrice * $coupleQuantity))
    });
})