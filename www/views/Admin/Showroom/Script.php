<script>
    $('#addEmployeeModal').on('hidden.bs.modal', function() {
        clearForm()
    })

    function fillEditForm(btn) {
        $("#addEmployeeModal").val("Update");
        let tds = $(btn).closest('tr').find('td');
        let ID = tds[0].innerHTML;
        $("#action").val(ID);
        $("#SEATCOUNT").prop('disabled', true);
        $('#SHOWROOMNUM').val(tds[1].innerText)
        console.log("edit")
        console.log(tds[1].innerText)
    }

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
        $('#SHOWROOMNUM').val("")
        $('#SEATCOUNT').val("")
    }

    $(document).ready(function() {
        function load_cinema() {
            $.get("./?api/cinema/getall", function(data, status) {

                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.innerText = object.NAME;
                    $('#cinemaBox').append(option);
                });
            }, "json");
        }
        load_cinema();


        var table = $('#dataTable').DataTable({
            ajax: "./?api/showroom/getByCinema&cinema_id=-1",
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'SHOWROOMNUM'
                },
                {
                    data: 'SEATCOUNT'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button name="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)" > Delete </button> <button name="btn_edit_employee" class="btn btn-outline-secondary" onclick="fillEditForm(this)" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" > Edit </button>';
                    }
                }
            ]
        });

        $('#cinemaBox').change(function() {
            let cinema_id = $('#cinemaBox').val();
            console.log(cinema_id);
            table.ajax.url("./?api/showroom/getByCinema&cinema_id=" + cinema_id).load();
        })


        $("#addStaff").click(function() {
            let SHOWROOMNUM = $('#SHOWROOMNUM').val();
            let CINEMA_ID = $('#cinemaBox').val();
            let action = $("#action").val();
            if (action == "Add") {
                $.post("./?api/showroom/add", {
                    SHOWROOMNUM,
                    CINEMA_ID
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
                    }
                }, "json")
            } else {
                let ID = $("#action").val();
                $.post("./?api/showroom/update", {
                    SHOWROOM_ID: ID,
                    CINEMA_ID,
                    SHOWROOMNUM
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
                    }
                }, "json")
            }
        });

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/showroom/delete", {
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


    })
</script>