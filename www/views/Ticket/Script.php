<script>
    function fillEditForm(btn) {
            $("#addTicketModalLabel").val("Update ticket");
            let tds = $(btn).closest('tr').find('td');
            let ID = tds[0].innerHTML;
            $("#action").val(ID);
            $.post("./?api/ticket/getbyid", {
                ID
            }, function(data, status) {
                var table = $('#table');
                console.log(data)
                console.log("fill");
                data.data.forEach(function(object) {
                    // $('#ID').val(object.ID)
                    $('#SCH_ID').val(object.SCH_ID)
                    $('#BOO_ID').val(object.BOO_ID)
                    $('#SEAT_ID').val(object.SEAT_ID)
                    $('#PRICE').val(object.price)
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
            $.get("./?api/ticket/getall", function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var tr = document.createElement('tr');
                    tr.innerHTML =
                        `
                        <tr >
                            <td>${object.ID}</td>
                            <td>${object.SCH_ID}</td>
                            <td>${object.BOO_ID}</td>
                            <td>${object.SEAT_ID}</td>
                            <td>${object.price}</td>
                            <td>
                                <button S="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)">Delete</button>
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
        
        
        $("#addTicket").click(function() {
            let SCH_ID = $('#SCH_ID').val()
            let BOO_ID = $('#BOO_ID').val()
            let SEAT_ID = $('#SEAT_ID').val()
            let PRICE = $('#PRICE').val()

            let action = $("#action").val();
            console.log(action);
            if(action == "Add"){
                $.post("./?api/ticket/add", {
                    SCH_ID,
                    BOO_ID,
                    SEAT_ID,
                    PRICE,
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
                $.post("./?api/ticket/update", {
                SCH_ID,
                BOO_ID,
                SEAT_ID,
                PRICE,
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
        // $("#updateticket").click(function() {
        //     let NAME = $('#NAME').val()
        //     let PHONE = $('#PHONE').val()
        //     let ADDRESS = $('#ADDRESS').val()
           
        //     clearForm();
        //     $("#updateticket").attr("id","addticket");
                
        // });

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/ticket/delete", {
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
        $('#SCH_ID').val("");
        $("#BOO_ID").val("");
        $("#SEAT_ID").val("");
        $("#PRICE").val("");
    }

</script>