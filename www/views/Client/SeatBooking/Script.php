<script>
    
    function drawSeatCols(start, end) {
        const seatCols = document.createElement('div');
        seatCols.classList.add('seatcol-big', 'd-flex');
        for (let j = start; j <= end; j++) {
            // Create a new seat item column
            const seatCol = document.createElement('div');
            seatCol.classList.add('seatcol');

            // Loop through each seat item and create it
            for (let k = 0; k < 8; k++) {
                const seatItem = document.createElement('div');
                seatItem.classList.add('seat-item');
                seatItem.dataset.seat = String.fromCharCode(65 + k) + (j);
                seatCol.appendChild(seatItem);
            }

            // Create the seat letter for this column
            const seatLetter = document.createElement('div');
            seatLetter.classList.add('seat-letter');
            seatLetter.textContent = j ;
            seatCol.appendChild(seatLetter);

            // Add the seat item column to the seatCols container
            seatCols.appendChild(seatCol);
        }
        return seatCols
    }

    $(document).ready(function() {

        function dawSingle() {
            const seatContainer = document.getElementById('bookticket-seat-main-seat-single');

            const letterColL = document.createElement('div');
            letterColL.classList.add('seatcol');
            for (let l = 0; l < 8; l++) {
                const seatLetter = document.createElement('div');
                seatLetter.classList.add('seat-letter');
                seatLetter.textContent = String.fromCharCode(65 + l);
                letterColL.appendChild(seatLetter);
            }

            seatContainer.appendChild(letterColL)
            // Define the number of seat rows and columns
            const numRows = 3;
            const numCols = 10;
            // Loop through each row and column to create the seat grid
            // const seatCols = drawSeatCols(1, 2)
            seatContainer.appendChild(drawSeatCols(1, 2))
            seatContainer.appendChild(drawSeatCols(3, 8))
            seatContainer.appendChild(drawSeatCols(9, 10))

            const letterColR = document.createElement('div');
            letterColR.classList.add('seatcol');
            for (let l = 0; l < 8; l++) {
                const seatLetter = document.createElement('div');
                seatLetter.classList.add('seat-letter');
                seatLetter.textContent = String.fromCharCode(65 + l);
                letterColR.appendChild(seatLetter);
            }
            seatContainer.appendChild(letterColR)

        }
        dawSingle()

        // 10 cuple | 80 single
        const seats = [];
        var ticket_quantity = parseInt($('#quantity_regular').text()) + parseInt($('#quantity_couple').text())

        $("#bookticket-seat-main-seat").find($(".seat-item")).click(function() {
            
            if ($(this).hasClass("seat-choosing")) {
                ticket_quantity += 1;
                const index = seats.indexOf($(this).data("seat"));
                if (index > -1) { // only splice array when item is found
                    seats.splice(index, 1); // 2nd parameter means remove one item only
                }
                console.log($(this).data("seat"));
                console.log(seats)
                $(this).removeClass("seat-choosing");
            } else {
                if (ticket_quantity<=0) {
                alert("Đã chọn đủ số vé! Vui lòng bấm vào 'Tiếp theo' để sang bước tiếp theo")
                }else{
                    ticket_quantity -=1;
                seats.push($(this).data("seat"));
                console.log(seats)
                $(this).addClass("seat-choosing");
                console.log($(this).data("seat"));
                }
               
            }
        });

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
