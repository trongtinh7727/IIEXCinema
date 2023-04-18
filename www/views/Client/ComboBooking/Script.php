<script>
    $(document).ready(function() {

        foods = []
        $('.quantity').change(function() {
            var id = $(this).attr('id');
            var name = 'name' + $(this).attr('id');
            var price = 'price' + $(this).attr('id');
            food = {
                id: id,
                name: $(`#${name}`).text(),
                price: $(`#${price}`).text(),
                quantity: $(this).val()
            }

            const index = foods.findIndex((obj) => obj.id === food.id);
            if (index > -1) {
                foods.splice(index, 1);
            }
            
            foods.push(food)
            console.log(foods)


        })

        $('#bookticket-prev').click(
            function() {
                $(location).attr('href', '/?ticketbooking');
            }
        )
        $('#bookticket-next').click(
            function() {
                $.post("./?seatbooking", {
                    seats
                }, function(data, status) {}, "json");
                $(location).attr('href', '/?combobooking');
            }
        )
    })
</script>