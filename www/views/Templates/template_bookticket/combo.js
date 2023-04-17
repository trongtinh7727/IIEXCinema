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
    $(".bookticket-combo-main-combo-item-quantity").bind('keyup mouseup', function () {
        // Ticket info
        // $regularPrice = parseNumber($("#bookticket-ticket-main-number-regular-price").html());
        // $regularQuantity = $("#bookticket-ticket-main-number-regular-quantity").find("input").val();
        // $regularPrice = parseNumber($("#bookticket-ticket-main-number-regular-price").html());
        // $regularQuantity = $("#bookticket-ticket-main-number-regular-quantity").find("input").val();

        // Combo info
        $comboName = $(this).parent().find(".bookticket-combo-main-combo-item-info").html();
        $comboPrice = parseNumber($(this).parent().find(".bookticket-combo-main-combo-item-price").html());
        $comboQuantity = $(this).find("input").val();

        $(".bookticket-combo-main-cart-combo-item").each(function () {
            if ($(this).find("h5:nth-child(1)").html() === $comboName) {
                $(this).find("h5:nth-child(2)").html(addCommas($comboPrice * $comboQuantity));
            }
        });
        $total = 0;
        $(".bookticket-combo-main-cart-combo-item-total").each(function () {
            $total += parseNumber($(this).html());
        });
        $("#bookticket-combo-main-cart-total-price").html(addCommas($total));
    });
})