<script>
    $(document).ready(function() {
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
        $(".bookticket-confirm-main-cartinfo-total").html(function() {
            $price = parseNumber($(this).parent().find($(".bookticket-confirm-main-cartinfo-price")).html());
            $quantity = parseNumber($(this).parent().find($(".bookticket-confirm-main-cartinfo-quantity")).html());
            $(this).parent().find($(".bookticket-confirm-main-cartinfo-total")).html(addCommas($price * $quantity));
        });

        $("#bookticket-confirm-main-cartinfo-totalall").html(function() {
            $total = 0;
            $(".bookticket-confirm-main-cartinfo-total").each(function() {
                $total += parseNumber($(this).html())
            });
            $(this).append(addCommas($total))
        });

        $('input[type=radio][name=paymentsMethod]').change(function() {
            if (this.value == 'zalo') {
                $("#bookticket-confirm-paymodal-zalo").removeClass("d-none")
                $("#bookticket-confirm-paymodal-momo").addClass("d-none")
            } else if (this.value == 'momo') {
                $("#bookticket-confirm-paymodal-momo").removeClass("d-none")
                $("#bookticket-confirm-paymodal-zalo").addClass("d-none")
            }
        });

        $('#bookticket-prev').click(
            function() {
                $(location).attr('href', '/?combobooking');
            }
        )
        $('#bookticket-next').click(
            function() {
                $(location).attr('href', '/?successbooking');
            }
        )
    })
</script>