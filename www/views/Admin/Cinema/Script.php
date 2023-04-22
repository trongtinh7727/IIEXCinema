<script>
    function fillEditForm(btn) {
        $("#addCinemaModalLabel").val("Update Cinema");
        let tds = $(btn).closest('tr').find('td');
        let ID = tds[0].innerHTML;
        $("#action").val(ID);
        $.post("./?api/cinema/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#NAME').val(object.NAME)
                $('#PHONE').val(object.PHONE)
                $('#ADDRESS').val(object.ADDRESS)
            });
        }, "json");
    }
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            ajax: "./?api/cinema/getall",
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'NAME'
                },
                {
                    data: 'PHONE'
                },
                {
                    data: 'ADDRESS'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button name="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)" > Delete </button> <button name="btn_edit_employee" class="btn btn-outline-secondary" onclick="fillEditForm(this)" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" > Edit </button>';
                    }
                }
            ]
        });

        $('#addEmployeeModal').on('hidden.bs.modal', function() {
            clearForm()
        })


        $("#add").click(function() {
            let NAME = $('#NAME').val()
            let PHONE = $('#PHONE').val()
            let ADDRESS = $('#ADDRESS').val()
            let action = $("#action").val();

            if (action == "Add") {
                $.post("./?api/cinema/add", {
                    NAME,
                    PHONE,
                    ADDRESS
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
            } else {
                let ID = $("#action").val();
                $.post("./?api/cinema/update", {
                    NAME,
                    PHONE,
                    ADDRESS,
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
            clearForm()
        });


        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/cinema/delete", {
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
        document.getElementById("student_name").innerHTML = tds[1].innerText;
        console.log(tds[2].innerText)
        $('#delete-button').attr('uid', tds[0].innerHTML)
        var myModal = new bootstrap.Modal(document.getElementById("confirm-removal-modal"), {});
        myModal.show();
    }

    function clearForm() {
        $('#NAME').val("");
        $("#PHONE").val("");
        $("#ADDRESS").val("");
    }
</script>