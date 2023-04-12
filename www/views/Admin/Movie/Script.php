<script>
    function fillEditForm(btn) {
        $("#addCinemaModalLabel").val("Update Cinema");
        let tds = $(btn).closest('tr').find('td');
        let ID = tds[0].innerHTML;
        $("#action").val(ID);

        $.post("./?api/movie/getbyid", {
            ID
        }, function (data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function (object) {
                $('#TITLE').val(object.TITLE)
                $('#DIRECTOR').val(object.DIRECTOR)
                $('#ACTORS').val(object.ACTORS)
                $('#GENRE').val(object.GENRE)
                $('#STORY').val(object.STORY)
                $('#DURATION').val(object.DURATION)
                $('#OPENING_DAY').val(object.OPENING_DAY)
                $('#CLOSING_DAY').val(object.CLOSING_DAY)
                $('#POSTER').val(object.POSTER)
                $('#TRAILER').val(object.TRAILER)
            });
        }, "json");
    }
    $(document).ready(function () {
        function deleteRow() {
            var table = document.querySelector("table");
            var rowCount = table.rows.length;
            for (let index = rowCount; index > 1; index--) {
                if (rowCount > 1) {
                    table.deleteRow(index - 1);
                }
            }
        }
        let jsonArrayObj = [{}];
        function load_data() {
            fetch('./?api/movie/getall')
                .then(response => response.json())
                .then(data => {
                    jsonArrayObj = data.data;
                    $.fn.dataTable();
                    console.log(jsonArrayObj);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        load_data();

        // đọc dữ liệu ngay khi tải trang xong
        var pageNumber = 1;
        var entriesPerPage = 10;
        var totalPage = Math.ceil(jsonArrayObj.length / entriesPerPage);


        // Data from json
        $.fn.dataTable = function () {
            var start_index = (pageNumber - 1) * entriesPerPage;
            var end_index = start_index + (entriesPerPage - 1);
            end_index = (end_index >= jsonArrayObj.length) ? jsonArrayObj.length - 1 : end_index;

            $("table tbody tr").remove();
            for (var i = start_index; i <= end_index; i++) {
                id = `trv${jsonArrayObj[i].ID}`;
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <tr>
                    <td class="align-middle text-center" name="data_id"> ${jsonArrayObj[i].ID}</td>
                        <td class="align-middle text-center" name="data_username"> ${jsonArrayObj[i].TITLE}</td>
                        <td class="align-middle text-center" name="data_firstname"> ${jsonArrayObj[i].DIRECTOR}</td>
                        <td class="align-middle text-center" name="data_phone"> ${jsonArrayObj[i].ACTORS}</td>
                        <td class="align-middle text-center" name="data_address"> ${jsonArrayObj[i].GENRE}</td>
                        <td class="align-middle text-center" name="data_address"> ${jsonArrayObj[i].DURATION}</td>
                        <td class="align-middle text-center" name="data_salary"> ${jsonArrayObj[i].OPENING_DAY}</td>
                        <td class="align-middle text-center" name="data_salary"> ${jsonArrayObj[i].CLOSING_DAY}</td>
                        <td class="align-middle text-center" name="data_action">
                            <button name="btn_delete_employee" class="btn btn-outline-danger"
                                onclick="confirmRemoval(this)"> Delete
                            </button>
                            <button name="btn_edit_employee" class="btn btn-outline-secondary" onclick="fillEditForm(this)"
                                data-bs-toggle="modal" data-bs-target="#addEmployeeModal"> Edit </button>
                        </td>
                    </tr>
                `;
                tr.id = `${id}`;
                $("table tbody").append(tr);
            }
            $(".page_index").removeClass("active");
            $("#page_index" + pageNumber).addClass("active");
            $(".data_size_details").text(`Showing ` + (start_index + 1) + ` to ` + (end_index + 1) + ` of ` + jsonArrayObj.length + ` entries`);
        }

        setTimeout(() => {
            var tab_size = 10;
            pageNumber = 1;
            entriesPerPage = parseInt(tab_size);
            totalPage = Math.ceil(jsonArrayObj.length / entriesPerPage);
            $.fn.paginationButtons();
            $.fn.dataTable();
        }, 100);

        $.fn.nextPage = function () {
            if (pageNumber != totalPage) {
                pageNumber++;
                $.fn.dataTable();
            }
        }

        // Previous page
        $.fn.prevPage = function () {
            if (pageNumber > 1) {
                pageNumber--;
                $.fn.dataTable();
            }
        }

        // Index page
        $.fn.indexPage = function (index) {
            pageNumber = parseInt(index)
            $.fn.dataTable();
        }

        // Data size change
        $("#data_size").change(function () {
            var tab_size = $(this).val();
            pageNumber = 1;
            entriesPerPage = parseInt(tab_size);
            totalPage = Math.ceil(jsonArrayObj.length / entriesPerPage);
            $.fn.paginationButtons();
            $.fn.dataTable();
        });

        $.fn.dataTable();

        // Pagination button
        $.fn.paginationButtons = function () {
            var buttons_text = `<li class="page-item"><a class="page-link" onClick="javascript:$.fn.prevPage();" href="#">Previous</a></li>`;
            var active = "";
            for (var i = 1; i <= totalPage; i++) {
                if (i == 1) {
                    active = "active";
                } else {
                    active = "";
                }
                buttons_text = buttons_text + `<li class="page-item"><a id="page_index` + i + `" onClick="javascript:$.fn.indexPage(` + i + `);" class="page-link page_index ` + active + `" href="#">` + i + `</a></li>`;
            }
            buttons_text = buttons_text + `<li><a class="page-link" href="#" onClick="javascript:$.fn.nextPage();">Next</a></li>`;
            $(".pagination-buttons").text("");
            $(".pagination-buttons").append(buttons_text);
        }

        $.fn.paginationButtons();

        $("#searchBarInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#add").click(function () {
            // let TITLE = $('#TITLE').val()
            // let GENRE = $('#GENRE').val()
            // let DURATION = $('#DURATION').val()
            // let RATING = $('#RATING').val()
            // let STORY = $('#STORY').val()
            // let POSTER = $('#POSTER').val()

            let TITLE = $('#TITLE').val()
            let DIRECTOR = $('#DIRECTOR').val()
            let ACTORS = $('#ACTORS').val()
            let GENRE = $('#GENRE').val()
            let STORY = $('#STORY').val()
            let DURATION = $('#DURATION').val()
            let OPENING_DAY = $('#OPENING_DAY').val()
            let CLOSING_DAY = $('#CLOSING_DAY').val()
            let POSTER = $('#POSTER').val()
            let TRAILER = $('#TRAILER').val()


            let action = $("#action").val();

            if (action == "Add") {
                $.post("./?api/movie/add", {
                    TITLE,
                    DIRECTOR,
                    ACTORS,
                    GENRE,
                    STORY,
                    DURATION,
                    OPENING_DAY,
                    CLOSING_DAY,
                    POSTER,
                    TRAILER
                }, function (data, status) {
                    console.log(data)
                    if (data.status) {
                        console.log("Okee")
                        load_data();
                        $.fn.dataTable();
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
                $.post("./?api/movie/update", {
                    TITLE,
                    GENRE,
                    DURATION,
                    RATING,
                    STORY,
                    POSTER,
                    ID,
                }, function (data, status) {
                    console.log(data)
                    if (data.status) {
                        console.log("Okee")
                        load_data();
                        $.fn.dataTable();
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


        $("#delete-button").on('click', function () {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/movie/delete", {
                id: uid
            }, function (data, status) {
                console.log(data)
                if (data.status) {
                    load_data();
                    $.fn.dataTable();
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
        $('#name').val("");
        $("#email").val("");
        $("#phone").val("");
    }
</script>