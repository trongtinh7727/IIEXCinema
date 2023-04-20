<script>
    function fillEditForm(btn) {
        $("#addCinemaModalLabel").val("Update Cinema");
        let tds = $(btn).closest('tr').find('td');
        let ID = tds[0].innerHTML;
        $("#action").val(ID);

        $.post("./?api/movie/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#TITLE').val(object.TITLE)
                $('#DIRECTOR').val(object.DIRECTOR)
                $('#ACTORS').val(object.ACTORS)
                $('#GENRE').val(object.GENRE)
                $('#STORY').val(object.STORY)
                $('#DURATION').val(object.DURATION)
                $('#OPENING_DAY').val(object.OPENING_DAY)
                $('#CLOSING_DAY').val(object.CLOSING_DAY)
                // $('#POSTER').val(object.POSTER)
                $('#TRAILER').val(object.TRAILER)
            });
        }, "json");
    }
    $(document).ready(function() {

        var table = $('#dataTable').DataTable({
            ajax: "./?api/movie/getall",
            columns: [{
                    data: 'ID'
                },
                {
                    data: 'POSTER',
                    render: function(data, type, row) {
                        return '<img src="' + data + '" width="100"/>';
                    }
                },
                {
                    data: 'TITLE'
                },
                {
                    data: 'DIRECTOR'
                },
                {
                    data: 'ACTORS'
                },
                {
                    data: 'GENRE'
                },
                {
                    data: 'DURATION'
                },
                {
                    data: 'OPENING_DAY'
                },
                {
                    data: 'CLOSING_DAY'
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

            // Create a new FormData object
            var formData = new FormData();

            // Append the movie data to the form data
            formData.append("TITLE", $('#TITLE').val());
            formData.append("DIRECTOR", $('#DIRECTOR').val());
            formData.append("ACTORS", $('#ACTORS').val());
            formData.append("GENRE", $('#GENRE').val());
            formData.append("STORY", $('#STORY').val());
            formData.append("DURATION", $('#DURATION').val());
            formData.append("OPENING_DAY", $('#OPENING_DAY').val());
            formData.append("CLOSING_DAY", $('#CLOSING_DAY').val());
            formData.append("TRAILER", $('#TRAILER').val());

            // Append the poster file to the form data
            formData.append("POSTER", document.getElementById("POSTER").files[0]);



            let action = $("#action").val();

            if (action == "Add") {

                $.ajax({
                    url: './?api/movie/add',
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
            } else {
                let ID = $("#action").val();
                formData.append("ID", ID);
                $.ajax({
                    url: './?api/movie/update',
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
                $("#action").val("Add");
            }
            clearForm()
        });


        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/movie/delete", {
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
        $('#TITLE').val("")
        $('#DIRECTOR').val("")
        $('#ACTORS').val("")
        $('#GENRE').val("")
        $('#STORY').val("")
        $('#DURATION').val("")
        $('#OPENING_DAY').val("")
        $('#CLOSING_DAY').val("")
        $('#POSTER').val("")
        $('#TRAILER').val("")
    }
</script>