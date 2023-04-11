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
            $.get("./?api/movie/getall", function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var tr = document.createElement('tr');
                    tr.innerHTML =
                        `
                        <tr >
                            <td>${object.ID}</td>
                            <td>${object.TITLE}</td>
                            <td>${object.GENRE}</td>
                            <td>${object.DURATION}</td>
                            <td>${object.RATING}</td>
                            <td>${object.STORY}</td>
                            <td><img class="poster" src="${object.POSTER}" alt=""></td>
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


        $("#add").click(function() {


            let TITLE = $('#TITLE').val()
            let GENRE = $('#GENRE').val()
            let DURATION = $('#DURATION').val()
            let RATING = $('#RATING').val()
            let STORY = $('#STORY').val()
            let POSTER = $('#POSTER').val()


            let action = $("#action").val();

            if (action == "Add") {
                $.post("./?api/movie/add", {
                    TITLE,
                    GENRE,
                    DURATION,
                    RATING,
                    STORY,
                    POSTER,
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
            } else {
                let ID = $("#action").val();
                $.post("./?api/movie/update", {
                    TITLE,
                    GENRE,
                    DURATION,
                    RATING,
                    STORY,
                    POSTER,
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


        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/movie/delete", {
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
        document.getElementById("student_name").innerHTML = tds[1].innerText;
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