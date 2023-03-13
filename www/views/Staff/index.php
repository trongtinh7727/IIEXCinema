<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

    <style>
        .columns {
            border: 2px solid darkgrey;
            border-radius: 5px;
            padding-top: 15px;
        }

        .alert {
            max-width: 500px;
            margin: auto;
        }
    </style>

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
                $.get("http://localhost/api/get-students.php", function(data, status) {
                    var table = $('#table');
                    data.data.forEach(function(object) {
                        var tr = document.createElement('tr');
                        tr.innerHTML =
                            `
                        <tr >
                            <td>${object.id}</td>
                            <td>${object.name}</td>
                            <td>${object.email}</td>
                            <td>${object.phone}</td>
                            <td>
                                <a href="#" onclick="fillEditForm(this)">Edit</a> | <a href="#"
                                    onclick="confirmRemoval(this)">Delete</a>
                            </td>
                        </tr>
                        `;
                        tr.id = `trv${object.id}`
                        table.append(tr);
                    });

                }, "json");
            }
            load_studen();


            // đọc dữ liệu ngay khi tải trang xong




            $(".add-student").click(function() {
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
                    $.post("http://localhost/api/add-student.php", {
                        name,
                        email,
                        phone
                    }, function(data, status) {
                        console.log(data)
                        if (data.status) {
                            load_studen();
                            $("#msg-success").css('display', 'flex').text("Add student success")
                            $("#msg-failed").css('display', 'none')
                        } else {
                            $("#msg-failed").css('display', 'flex').text("An unknown error occured. Please try again later")
                            $("#msg-success").css('display', 'none')
                        }
                    }, "json")
                    clearForm()
                }
            });

            $("#delete-button").on('click', function() {
                let uid = $('#delete-button').attr('uid');
                $.post("http://localhost/api/delete-student.php", {
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
            document.getElementById("student_name").innerHTML = tds[1].innerText;
            $('#delete-button').attr('uid', tds[0].innerHTML)
            $('#confirm-removal-modal').modal({
                show: true
            });
        }

        function clearForm() {
            $('#name').val("");
            $("#email").val("");
            $("#phone").val("");
        }



        function fillEditForm(btn) {
            let tds = $(btn).closest('tr').find('td')
            $('#name').val(tds[1].innerText);
            $("#email").val(tds[2].innerText);
            $("#phone").val(tds[3].innerText);
            $('#btn_update').removeClass('disabled');
            $('#btn_update').attr('uid', tds[0].innerHTML)
        }


        // hiện thông báo lỗi
        function showFailedDialog() {
            document.getElementById("error-message").innerHTML = "An unknown error occured. Please try again later";
            $('#delete-failed-modal').modal({
                show: true
            });
        }
    </script>

    <div class="container">
        <h1>jQuery</h1>
        <p>Khi trang web vừa được tải, cần gửi một request đến server, nhận về danh sách sinh viên đang có & hiện lên
            bảng.</p>
        <p>Nhấn <b>Add</b> để thêm một sinh viên vào danh sách: trước hết thông tin sẽ gửi lên server và lưu vào
            database, server sẽ trả về kết quả. Nếu kết quả là <b>true</b> thì đưa thông tin sinh viên vừa thêm vào
            bảng. Nếu lỗi hoặc thành công thì hiện thông báo tương ứng như phía dưới rồi tự ẩn đi sau 5 giây.</p>
        <p>Khi nhấn <b>Edit</b> thông tin sẽ được chuyển qua form để sửa, lúc này disable nút <b>Add</b> và enable nút
            <b>Update</b>, quá trình update cũng tương tự như thêm, gửi thông tin lên server, nhận kết quả rồi cập nhật
            bảng/hiển thị thông báo tương ứng.
        </p>
        <p>Khi nhấn <b>Delete</b> thì hiện dialog xác nhận trước rồi gửi lệnh xóa lên server, lúc nhận kết quả về làm
            tương tự các bước trước.</p>
        <div class="row">
            <div class="col-sm-6 col-md-5 columns">


                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" placeholder="Enter name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" placeholder="Enter email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="phone">Phone:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="phone" placeholder="Enter phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default add-student">Add</button>
                            <button type="submit" class="btn btn-success disabled" id="btn_update">Update</button>
                        </div>
                    </div>
                </form>


            </div> <!-- Col 1 -->
            <div class="col-sm-6 col-md-7 columns">

                <table class="table table-hover" id="table">
                    <thead>
                        <tr id="trID">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">


                    </tbody>
                </table>


            </div> <!-- col 2-->
        </div>


        <br><br>
        <div class="alert alert-success alert-dismissable fade in" id="msg-success" style="display: none;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Delete student success.
        </div>
        <br>
        <div class="alert alert-danger alert-dismissable fade in" id="msg-failed" style="display: none;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failed!</strong> An unknown eror occured. Please try again later.
        </div>

    </div>


    <!-- Confirm Removal Modal -->
    <div class="modal fade" id="confirm-removal-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Xóa sinh viên</h4>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa sinh viên <strong id="student_name">My Tam</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="delete-button" class="btn btn-danger" data-dismiss="modal">Xóa</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                </div>
            </div>

        </div>
    </div><!-- Confirm Removel modal -->


</body>

</html>