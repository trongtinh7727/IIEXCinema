<script>
    $(document).ready(function() {
        function deleteRow() {
            var table = document.querySelector("table");
            var rowCount = table.rows.length;
            for (let index = rowCount; index > 1; index--) {
                if (rowCount > 1) {
                    table.deleteRow(index - 1);
                }
            }

        }

        function load_studen() {
            deleteRow()
            $.get("./?api/staff/getall", function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var tr = document.createElement('tr');
                    tr.innerHTML =
                        `
                        <tr >
                            <td>${object.ID}</td>
                            <td>${object.USERNAME}</td>
                            <td>${object.NAME}</td>
                            <td>${object.PHONE}</td>
                            <td>${object.ADDRESS}</td>
                            <td>${object.SALARY}</td>
                            <td>
                                <button name="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)">Delete</button>
                                <button name="btn_edit_employee" class="btn btn-outline-secondary" onclick="fillEditForm(this)" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Edit</button>
                            </td>
                        </tr>
                        `;
                    tr.id = `trv${object.ID}`
                    table.append(tr);
                });

            }, "json");
        }
        load_studen();

        // đọc dữ liệu ngay khi tải trang xong

        $("#addStaff").click(function() {
            let USERNAME = $('#USERNAME').val()
            let PASSWORD = $('#PASSWORD').val().trim()
            let NAME = $('#NAME').val()
            let CODE = $('#CODE').val()
            let PHONE = $('#PHONE').val()
            let ADDRESS = $('#ADDRESS').val()
            let SALARY = $('#SALARY').val()
            $.post("./?api/staff/add", {
                USERNAME,
                PASSWORD,
                NAME,
                CODE,
                PHONE,
                ADDRESS,
                SALARY
            }, function(data, status) {
                console.log(data)
                if (data.status) {
                    console.log("Okee")
                    load_studen();
                    $("#msg-success").css('display', 'flex').text("Add student success")
                    $("#msg-failed").css('display', 'none')
                } else {
                    console.log("Nooo")
                    $("#msg-failed").css('display', 'flex').text("An unknown error occured. Please try again later")
                    $("#msg-success").css('display', 'none')
                }
            }, "json")
            clearForm()
            // kiem tra phai nhap emai name va email hop le
            // var pattern = /^\b[A-Za-z0-9._%-]+@[A-Za-z0-9]+.([A-Za-z]{2,4})+([.A-Za-z]{2,4})?$/
            // if (email == "") {
            //     $("#msg-failed").css('display', 'flex').text("Please enter your email")
            //     $("#msg-success").css('display', 'none')
            // } else
            // if (!pattern.test(email)) {
            //     $("#msg-failed").css('display', 'flex').text("Your email is not correct")
            //     $("#msg-success").css('display', 'none')
            // } else {

            // }
        });

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/staff/delete", {
                id: uid
            }, function(data, status) {
                console.log(data)
                if (data.status) {
                    $(`#trv${uid}`).remove()
                    $("#msg-success").css('display', 'flex')
                    $("#msg-failed").css('display', 'none')
                } else {
                    $("#msg-failed").css('display', 'flex')
                    $("#msg-success").css('display', 'none')
                    $('#confirm-removal-modal').modal({
                        show: false
                    });
                }
            }, "json")
        })

        $("#btn_update").click(function() {
            let id = $('#btn_update').attr('uid');
            let name = $('#name').val()
            let email = $('#email').val().trim()
            let phone = $('#phone').val()
            // kiem tra phai nhap emai name va email hop le
            var pattern = /^\b[A-Za-z0-9._%-]+@[A-Za-z0-9]+.([A-Za-z]{2,4})+([.A-Za-z]{2,4})?$/
            if (email == "") {
                $("#msg-failed").css('display', 'flex').text("Please enter your email")
                $("#msg-success").css('display', 'none')
            } else
            if (!pattern.test(email)) {
                $("#msg-failed").css('display', 'flex').text("Your email is not correct")
                $("#msg-success").css('display', 'none')
            } else {
                $.post("http://localhost/api/update-student.php", {
                    id,
                    name,
                    email,
                    phone
                }, function(data, status) {
                    console.log(data)
                    if (data.status) {
                        load_studen();
                        $("#msg-success").css('display', 'flex').text("Update student success")
                        $("#msg-failed").css('display', 'none')
                    } else {
                        $("#msg-failed").css('display', 'flex').text("An unknown error occured. Please try again later")
                        $("#msg-success").css('display', 'none')
                    }
                }, "json")
                clearForm()
                $('#btn_update').addClass('disabled');
            }

        });

    });


    // hiện dialog xác nhận khi xóa
    function confirmRemoval(btn) {
        let tds = $(btn).closest('tr').find('td')
        document.getElementById("student_name").innerHTML = tds[2].innerText;
        console.log(tds[2].innerText)
        $('#delete-button').attr('uid', tds[0].innerHTML)
        var myModal = new bootstrap.Modal(document.getElementById("confirm-removal-modal"), {});
        myModal.show();
        // $('#confirm-removal-modal').modal({
        //     show: true
        // });
    }

    function clearForm() {
        $('#name').val("");
        $("#email").val("");
        $("#phone").val("");
    }

    function fillEditForm(btn) {
        let tds = $(btn).closest('tr').find('td')
        let ID = tds[0].innerHTML;
        $.post("./?api/staff/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#USERNAME').val(object.USERNAME)
                $('#PASSWORD').val().trim(object.PASSWORD)
                $('#NAME').val(object.NAME)
                $('#CODE').val(object.CODE)
                $('#PHONE').val(object.PHONE)
                $('#ADDRESS').val(object.ADDRESS)
                $('#SALARY').val(object.SALARY)
            });

        }, "json");
    }
</script>