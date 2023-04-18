<script>
    function load_movie() {
        let ID = <?php echo $movie_id; ?>;
        $.post("./?api/movie/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#TITLE').text(object.TITLE)
                $('#DIRECTOR').text(object.DIRECTOR)
                $('#ACTORS').text(object.ACTORS)
                $('#GENRE').text(object.GENRE)
                $('#STORY').text(object.STORY)
                $('#DURATION').text(object.DURATION + " phút")
                $('#OPENING_DAY').text("Từ ngày " + object.OPENING_DAY + " đến ngày" + object.CLOSING_DAY)
                $('#POSTER').attr('src', object.POSTER);
                $('#TRAILER').attr('src', object.TRAILER)
                console.log(object)
            });
        }, "json");
    }

    function load_schedule() {
        let ID = <?php echo $movie_id; ?>;
        $.get('./?api/schedule/getByMovie', {
            movie_id: ID
        }, function(data) {
            var shifts = data.data;
            console.log(shifts)
            var container = $('#shift-container');

            // Hiển thị lịch chiếu trên trang web
            shifts.forEach(shift => {
                const startTime = new Date(shift.STARTTIME);
                const endTime = new Date(shift.ENDTIME);

                // Tạo một item mới
                const item = document.createElement('div');
                item.classList.add('moviedetails-main-shift-item', 'col-12', 'col-xl-4', 'my-4');

                // Tạo triamgle
                const triangeB = document.createElement('div');
                triangeB.classList.add('triangle-bottom-left')
                const triangeT = document.createElement('div');
                triangeT.classList.add('triangle-top-left')

                // Thêm phần tử time slot

                const timeslotcontainer = document.createElement('div');
                timeslotcontainer.classList.add('d-flex')

                const timeSlot = document.createElement('div');
                timeSlot.classList.add('moviedetails-main-shift-item-time', 'bg-yellow', 'd-flex', 'align-items-center');

                const timeSlotLink = document.createElement('a');
                timeSlotLink.setAttribute('href', './?ticketbooking&schedule=' +
                    shift.ID);
                timeSlotLink.classList.add('moviedetails-main-shift-item-time-slot', 'ms-3', 'text-white', 'd-flex', 'align-items-center', 'justify-content-center', 'text-decoration-none', 'my-0', 'hover-bg-green');

                const timeSlotText = document.createElement('div');
                timeSlotText.classList.add('fs-4', 'fw-medium');
                timeSlotText.innerText = startTime.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });

                timeSlotLink.appendChild(timeSlotText);
                timeSlot.appendChild(timeSlotLink);
                timeslotcontainer.appendChild(timeSlot);
                timeslotcontainer.appendChild(triangeB);

                // Thêm phần tử ngày


                const dateDM = document.createElement('div');
                dateDM.classList.add('moviedetails-main-shift-item-date-dm', 'fs-4', 'fw-semibold', 'ms-3');
                dateDM.innerText = `${startTime.getDate()}/${startTime.getMonth() + 1}`;

                const dateY = document.createElement('div');
                dateY.classList.add('moviedetails-main-shift-item-date-y', 'fs-4', 'fw-semibold', 'ms-3');
                dateY.innerText = startTime.getFullYear();
                let id = dateDM.innerText + '\/' + dateY.innerText
                console.log(id);
                let itemP = document.getElementById(id);
                if (itemP != null) {
                    itemP.appendChild(timeslotcontainer);
                } else {
                    timeSlot.id = id
                    const date = document.createElement('div');
                    date.classList.add('moviedetails-main-shift-item-date', 'bg-yellow');

                    date.appendChild(dateDM);
                    date.appendChild(dateY);


                    const dmy = document.createElement('div');
                    dmy.classList.add('d-flex')
                    dmy.appendChild(date);
                    dmy.appendChild(triangeT)

                    // Thêm phần tử item vào container
                    item.appendChild(timeslotcontainer)
                    item.appendChild(dmy);
                    container.append(item);
                }


            });
        }, 'json');
    }

    $(function() {
        load_schedule();
        load_movie();
    })
</script>