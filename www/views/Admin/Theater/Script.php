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

        function load_theater() {
            $.get("./?api/theater/getall", function(data, status) {
                table.clear();
                table.rows.add(data.data);
                table.draw();
            }, "json");
        }


        function deleteRow() {
            var table = document.querySelector("myTable");
            var rowCount = table.rows.length;
            for (let index = rowCount; index > 1; index--) {
                if (rowCount > 1) {
                    table.deleteRow(index - 1);
                }
            }
        }

        function load_data() {
            load_theater();
        }
        load_data();


        $("#addStaff").click(function() {
            let THEATERNUM = $('#THEATERNUM').val();
            let SEATCOUNT = $('#SEATCOUNT').val();
            $.post("./?api/theater/add", {
                THEATERNUM,
                SEATCOUNT
            }, function(data, status) {
                console.log(data)
                if (data.status) {
                    load_data();
                    $.fn.dataTable();
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
            clearForm()
        });

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/theater/delete", {
                id: uid
            }, function(data, status) {
                console.log(data)
                if (data.status) {
                    load_data();
                    $.fn.dataTable();
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