<script>
    function fillEditForm(btn) {
        $("#addModalLabel").text = "Update";
        let tds = $(btn).closest('tr').find('td')
        let ID = tds[0].innerHTML;
        $("#action").val(ID);
        $.post("./?api/schedule/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#movieBox').val(object.MOV_ID);
                $('#startTimne').val(object.STARTTIME);
            });

        }, "json");
    }
    $('#addEmployeeModal').on('hidden.bs.modal', function() {
        clearForm()
    })

    $(document).ready(function() {

        function load_theater() {
            $('#theaterBox').empty()
            var option = document.createElement('option');
            option.value = -1;
            option.innerText = "Chọn phòng chiếu";
            $('#theaterBox').append(option);
            $.get("./?api/theater/getall", function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.innerText = "Phòng số " + object.THEATERNUM;
                    $('#theaterBox').append(option);
                });
            }, "json");
        }
        load_theater()

        var table = $('#dataTable').DataTable({
            ajax: "./?api/schedule/getByTheater&theater_id=-1",
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'TITLE'
                },
                {
                    data: 'DURATION'
                },
                {
                    data: 'STARTTIME'
                },
                {
                    data: 'ENDTIME'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return data.SEATCOUNT - data.EMPTYSEAT + "/" + data.SEATCOUNT;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button name="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)" > Delete </button> <button name="btn_edit_employee" class="btn btn-outline-secondary" onclick="fillEditForm(this)" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" > Edit </button>';
                    }
                }
            ]
        });


        function load_ongoing_movie() {
            $.get("./?api/movie/ongoing", function(data, status) {

                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.dataset.duration = object.DURATION;
                    option.innerText = object.TITLE;
                    $('#movieBox').append(option);
                });
            }, "json");
        }
        load_ongoing_movie();
        let jsonArrayObj = [{}];
        $('#theaterBox').change(function() {
            let theater_id = $('#theaterBox').val();
            table.ajax.url("./?api/schedule/getByTheater&theater_id=" + theater_id).load();
        })


        $("#addStaff").click(function() {

            let THEA_ID = $('#theaterBox').val();
            if (THEA_ID == '-1') {
                $("#msg-failed").css('display', 'flex').text("Vui lòng chọn rạp và phòng chiếu!")
                $("#msg-success").css('display', 'none')
            } else {
                $("#msg-failed").css('display', 'none')
                let MOV_ID = $('#movieBox').val();
                let STARTTIME = $('#startTimne').val();
                let duration = $('#movieBox option:selected').data('duration');
                const start = new Date(STARTTIME);
                const end = new Date(start.getTime() + (duration + 15) * 60000 + 7 * 60 * 60 * 1000);
                const ENDTIME = end.toISOString();
                let PRICE = $('#price').val();
                let action = $("#action").val();
                if (action == "Add") {
                    // Tao lich chieu
                    $.post("./?api/schedule/add", {
                        THEA_ID,
                        MOV_ID,
                        STARTTIME,
                        ENDTIME,
                        PRICE
                    }, function(data, status) {
                        console.log(data)
                        if (data.status) {
                            table.ajax.reload();

                            let msg = data.data;
                            schedule_id = msg.schedule_id;
                            console.log(schedule_id)
                            $("#msg-success").css('display', 'flex').text(msg.message)
                            $("#msg-failed").css('display', 'none')
                        } else {
                            let msg = data.data;
                            console.log(msg)
                            $("#msg-failed").css('display', 'flex').text("Có lỗi xảy ra! Vui lòng thử lại sau: " + msg)
                            $("#msg-success").css('display', 'none')
                        }
                    }, "json")
                } else {
                    let ID = $("#action").val();
                    $.post("./?api/schedule/update", {
                        THEA_ID,
                        MOV_ID,
                        STARTTIME,

                        ENDTIME,
                        ID
                    }, function(data, status) {
                        console.log(data)
                        if (data.status) {
                            console.log("Okee")
                            table.ajax.reload();

                            let msg = data.data;
                            console.log(msg)
                            $("#msg-success").css('display', 'flex').text(msg)
                            $("#msg-failed").css('display', 'none')
                        } else {
                            let msg = data.data;
                            console.log(msg)
                            $("#msg-failed").css('display', 'flex').text("Có lỗi xảy ra! Vui lòng thử lại sau: " + msg)
                            $("#msg-success").css('display', 'none')
                        }
                    }, "json")
                    $("#action").val("Add");
                }
            }
            clearForm()
        });

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/schedule/delete", {
                id: uid
            }, function(data, status) {
                console.log(data)
                if (data.status) {
                    table.ajax.reload();
                    let msg = data.data;
                    console.log(msg)
                    $("#msg-success").css('display', 'flex').text(msg)
                    $("#msg-failed").css('display', 'none')
                } else {
                    let msg = data.data;
                    console.log(msg)
                    $("#msg-failed").css('display', 'flex').text("Có lỗi xảy ra! Vui lòng thử lại sau: " + msg)
                    $("#msg-success").css('display', 'none')
                    $('#confirm-removal-modal').modal({
                        show: false
                    });
                }
            }, "json")
        })
    });


    // hiện dialog xác nhận khi xóa
    function confirmRemoval(btn) {
        let tds = $(btn).closest('tr').find('td')
        let msg = `Lịch chiếu của phim ${tds[1].innerText} (ID = ${tds[0].innerText})`;
        document.getElementById("student_name").innerHTML = msg;
        console.log(tds[2].innerText)
        $('#delete-button').attr('uid', tds[0].innerHTML)
        var myModal = new bootstrap.Modal(document.getElementById("confirm-removal-modal"), {});
        myModal.show();
    }

    function clearForm() {
        $('#name').val("");
        $("#email").val("");
        $("#phone").val("");
    }
    $(document).ready(function() {});
</script>