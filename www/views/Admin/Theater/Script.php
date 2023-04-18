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
        $('#THEATERNUM').val(tds[1].innerText)
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
        $('#THEATERNUM').val("")
        $('#SEATCOUNT').val("")
    }

    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            ajax: "./?api/theater/getall",
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'THEATERNUM'
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


        $("#addStaff").click(function() {
            let THEATERNUM = $('#THEATERNUM').val();
            let action = $("#action").val();
            if (action == "Add") {
                $.post("./?api/theater/add", {
                    THEATERNUM
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
                $.post("./?api/theater/update", {
                    THEATER_ID: ID,
                    THEATERNUM
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
            $.post("./?api/theater/delete", {
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