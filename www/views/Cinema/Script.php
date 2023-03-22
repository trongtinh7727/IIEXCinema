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
                    $('#ADDRESS').val(object.ADDRESS)
                    $('#PHONE').val(object.PHONE)
                });
            }, "json");
        }
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
            $.get("./?api/cinema/getall", function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var tr = document.createElement('tr');
                    tr.innerHTML =
                        `
                        <tr >
                            <td>${object.ID}</td>
                            <td>${object.NAME}</td>
                            <td>${object.PHONE}</td>
                            <td>${object.ADDRESS}</td>
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
        
        
        $("#addCinema").click(function() {
            let NAME = $('#NAME').val()
            let PHONE = $('#PHONE').val()
            let ADDRESS = $('#ADDRESS').val()

            let action = $("#action").val();
            
            if(action == "Add"){
                $.post("./?api/cinema/add", {
                    NAME,
                    PHONE,
                    ADDRESS,
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
            }
            else{
                let ID = $("#action").val();
                $.post("./?api/cinema/update", {
                NAME,
                PHONE,
                ADDRESS,
                ID,
                }, function(data, status) {
                    console.log(data)
                    if (data.status) {
                        console.log("Okee")
                        load_studen();
                        $("#msg-success").css('display', 'flex').text("Update student success")
                        $("#msg-failed").css('display', 'none')
                    } else {
                        console.log("Nooo")
                        $("#msg-failed").css('display', 'flex').text("An unknown error occured. Please try again later")
                        $("#msg-success").css('display', 'none')
                    }
                }, "json")
                $("#action").val("Add");
            }
            clearForm()
        });

        //update
        // $("#updateCinema").click(function() {
        //     let NAME = $('#NAME').val()
        //     let PHONE = $('#PHONE').val()
        //     let ADDRESS = $('#ADDRESS').val()
           
        //     clearForm();
        //     $("#updateCinema").attr("id","addCinema");
                
        // });

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/cinema/delete", {
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
        
      
    });

    // hiện dialog xác nhận khi xóa
    function confirmRemoval(btn) {
        let tds = $(btn).closest('tr').find('td')
        document.getElementById("student_name").innerHTML = tds[2].innerText;
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

</script>