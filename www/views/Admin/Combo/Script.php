<script>
    $(document).ready(function() {

        var table = $('#dataTable').DataTable({
            ajax: "./?api/foodcombo/getall",
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'Image',
                    render: function(data, type, row) {
                        return '<img src="' + data + '" width="100"/>';
                    }
                },
                {
                    data: 'NAME'
                },
                {
                    data: 'TenDoAn'
                },
                {
                    data: 'QuantityDoAn'
                },

                {
                    data: 'TenDoUong'
                },
                {
                    data: 'QuantityDoUong'
                },

                {
                    data: 'PRICE',
                    render: $.fn.dataTable.render.number(',', '.', 0, '$')
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button name="btn_delete_employee" class="btn btn-outline-danger" onclick="confirmRemoval(this)" > Delete </button>';
                    }
                }
            ]
        });

        function loadFoods() {
            $.get("./?api/foodcombo/getfoods", function(data, status) {
                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.innerText = object.NAME;
                    $('#FOOD').append(option);
                });
            }, "json");
        }
        loadFoods();

        function loadDrinks() {
            $.get("./?api/foodcombo/getdrinks", function(data, status) {
                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.innerText = object.NAME;
                    $('#DRINK').append(option);
                });
            }, "json");
        }
        loadDrinks();


        $("#add").click(function() {
            let NAME = $('#NAME').val()
            let FOOD = $('#FOOD').val()
            let FOOD_QUANTITY = $('#FOOD_QUANTITY').val()
            let DRINK = $('#DRINK').val()
            let DRINK_QUANTITY = $('#DRINK_QUANTITY').val()
            let PRICE = $('#PRICE').val()


            let action = $("#action").val();

            if (action == "Add") {


                // Get the image file from the input element
                var imageFile = $('#Image')[0].files[0];

                // Create a new FormData object
                var formData = new FormData();

                // Append the form data to the FormData object
                formData.append('NAME', NAME);
                formData.append('FOOD', FOOD);
                formData.append('FOOD_QUANTITY', FOOD_QUANTITY);
                formData.append('DRINK', DRINK);
                formData.append('DRINK_QUANTITY', DRINK_QUANTITY);
                formData.append('PRICE', PRICE);
                formData.append('Image', imageFile);

                // Send the POST request with the form data
                $.ajax({
                    url: './?api/foodcombo/add',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data, status) {
                        console.log(data);
                        if (data.status) {
                            console.log('Okee');
                            table.ajax.reload();
                            let msg = data.data;
                            console.log(msg);
                            $('#msg-success').css('display', 'flex').text(msg);
                            $('#msg-failed').css('display', 'none');
                        } else {
                            let msg = data.data;
                            console.log(msg);
                            $('#msg-failed').css('display', 'flex').text('Có lỗi xảy ra! Vui lòng thử lại sau: ' + msg);
                            $('#msg-success').css('display', 'none');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    },
                    dataType: 'json'
                });


                // $.post("./?api/foodcombo/add", {
                //     NAME,
                //     FOOD,
                //     FOOD_QUANTITY,
                //     DRINK,
                //     DRINK_QUANTITY,
                //     PRICE
                // }, function(data, status) {
                //     console.log(data)
                //     if (data.status) {
                //         console.log("Okee")
                //         table.ajax.reload();
                //         let msg = data.data;
                //         console.log(msg)
                //         $("#msg-success").css('display', 'flex').text(msg)
                //         $("#msg-failed").css('display', 'none')
                //     } else {
                //         let msg = data.data;
                //         console.log(msg)
                //         $("#msg-failed").css('display', 'flex').text("Có lỗi xảy ra! Vui lòng thử lại sau: " + msg)
                //         $("#msg-success").css('display', 'none')
                //     }
                // }, "json")
            } else {
                alert("Tính năng không hỗ trợ")
                console.log("Tính năng không hỗ trợ")
            }
            clearForm()
        });


        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/foodcombo/delete", {
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