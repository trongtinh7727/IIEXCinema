<script>
    function fillEditForm(btn) {
        $("#addEmployeeModalLabel").val("Update Staff");
        let tds = $(btn).closest('tr').find('td')
        let ID = tds[0].innerHTML;
        $("#action").val(ID);
        $.post("./?api/client/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#USERNAME').val(object.USERNAME)
                $('.pass').hide();
                $('#FNAME').val(object.FIRSTNAME)
                $('#LNAME').val(object.LASTNAME)
                $('#BIRTHDAY').val(object.BIRTHDAY)
                $('#PHONE').val(object.PHONE)
                $('#ADDRESS').val(object.ADDRESS)
            });

        }, "json");
    }
    $(document).ready(function() {

        var table = $('#dataTable').DataTable({
            ajax: "./?api/client/getall",
            columns: [{
                    data: "ID"
                },
                {
                    data: "USERNAME"
                },
                {
                    data: "PHONE"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return data.FIRSTNAME + ' ' + data.LASTNAME;
                    }
                },
                {
                    data: "SEX"
                },
                {
                    data: "BIRTHDAY"
                },
                {
                    data: "ADDRESS"
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
            let USERNAME = $('#USERNAME').val()
            let FIRSTNAME = $('#FNAME').val()
            let LASTNAME = $('#LNAME').val()
            let SEX = $("#SEX").val() === "M" ? "nam" : "nữ"
            let BIRTHDAY = $("#BIRTHDAY").val()
            let PHONE = $('#PHONE').val()
            let ADDRESS = $('#ADDRESS').val()
            let SALARY = $('#SALARY').val()
            let ROLE = $("#ROLE").val()
            let action = $("#action").val();
            console.log(action);
            if (action == "Add") {
                $.post("./?api/client/add", {
                    USERNAME,
                    FIRSTNAME,
                    LASTNAME,
                    SEX,
                    BIRTHDAY,
                    PHONE,
                    ADDRESS,
                    ROLE
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
                $.post("./?api/client/update", {
                    USERNAME,
                    FIRSTNAME,
                    LASTNAME,
                    SEX,
                    BIRTHDAY,
                    PHONE,
                    ADDRESS,
                    ROLE,
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
            $.post("./?api/client/delete", {
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
        document.getElementById("student_name").innerHTML = tds[3].innerText;
        console.log(tds[2].innerText)
        $('#delete-button').attr('uid', tds[0].innerHTML)
        var myModal = new bootstrap.Modal(document.getElementById("confirm-removal-modal"), {});
        myModal.show();
    }
    $('#addEmployeeModal').on('hidden.bs.modal', function() {
        clearForm()
    })

    function clearForm() {
        $('#USERNAME').val("")
        $('#FNAME').val("")
        $('#LNAME').val("")
        $('#BIRTHDAY').val("")
        $('#PHONE').val("")
        $('#ADDRESS').val("")
        $('#SALARY').val("")
    }
    $(document).ready(function() {});
</script>