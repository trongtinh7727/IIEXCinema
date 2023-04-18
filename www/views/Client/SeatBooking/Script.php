<script>
    function drawSeatCol(start, end) {
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
                seatItem.dataset.seat = String.fromCharCode(65 + k) + (k + 1);
                seatCol.appendChild(seatItem);
            }

            // Create the seat letter for this column
            const seatLetter = document.createElement('div');
            seatLetter.classList.add('seat-letter');
            seatLetter.textContent = j + 1;
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
            // const seatCols = drawSeatCol(1, 2)
            seatContainer.appendChild(drawSeatCol(1, 2))
            seatContainer.appendChild(drawSeatCol(3, 8))
            seatContainer.appendChild(drawSeatCol(9, 10))


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
        dawSeat()



        $("#bookticket-seat-main-seat").find($(".seat-item")).click(function() {
            if ($(this).hasClass("seat-choosing")) {
                $(this).removeClass("seat-choosing");
            } else {
                $(this).addClass("seat-choosing");
                console.log($(this).data("seat"))
            }
        });
    })
</script>