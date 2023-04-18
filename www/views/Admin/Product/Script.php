<script>
    function fillEditForm(btn) {
        $("#addCinemaModalLabel").val("Update Cinema");
        let tds = $(btn).closest('tr').find('td');
        let ID = tds[0].innerHTML;
        $("#action").val(ID);

        $.post("./?api/product/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#NAME').val(object.NAME)
                $('#TYPE').val(object.TYPE)
                $('#PRICE').val(object.PRICE)
                $('#QUANTITY').val(object.QUANTITY)
                $('#STORY').val(object.STORY)
                $('#Expiry_Date').val(object.Expiry_Date)

            });
        }, "json");
    }
    $(document).ready(function() {

        var table = $('#dataTable').DataTable({
            ajax: "./?api/product/getall",
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'NAME'
                },
                {
                    data: 'TYPE'
                },
                {
                    data: 'QUANTITY'
                },
                {
                    data: 'Expiry_Date'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button name="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)" > Delete </button> <button name="btn_edit_employee" class="btn btn-outline-secondary" onclick="fillEditForm(this)" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" > Edit </button>';
                    }
                }
            ]
        });


        $("#add").click(function() {
            let NAME = $('#NAME').val()
            let TYPE = $('#TYPE').val()
            let PRICE = $('#PRICE').val()
            let QUANTITY = $('#QUANTITY').val()

            let Expiry_Date = $('#Expiry_Date').val()


            let action = $("#action").val();

            if (action == "Add") {
                $.post("./?api/product/add", {
                    NAME,
                    TYPE,
                    PRICE,
                    QUANTITY,
                    Expiry_Date
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
                $.post("./?api/product/update", {
                    NAME,
                    TYPE,
                    PRICE,
                    QUANTITY,
                    Expiry_Date,
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
            $.post("./?api/product/delete", {
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
    $('#addEmployeeModal').on('hidden.bs.modal', function() {
        clearForm()
        $("#action").val("Add");
    })

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
        $('#NAME').val("")
        $('#TYPE').val("")
        $('#PRICE').val("")
        $('#QUANTITY').val("")
        $('#Expiry_Date').val("")
    }
</script>