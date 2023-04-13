<script>
    function fillEditForm(btn) {
        $("#addModalLabel").val("Update");
        let tds = $(btn).closest('tr').find('td')
        let ID = tds[0].innerHTML;
        $("#action").val(ID);
        $.post("./?api/schedule/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#movieBox').val(object.MOV_ID);
                $('#startTimne').val(object.STARTTIME);
            });

        }, "json");
    }

    $(document).ready(function() {
        function load_cinema() {
            $.get("./?api/cinema/getall", function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.innerText = object.NAME;
                    $('#cinemaBox').append(option);
                });
            }, "json");
        }
        load_cinema();

        function load_theater(cinema_id) {
            $.get("./?api/theater/getByCinema&cinema_id=" + cinema_id, function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.innerText = "Phòng số " + object.THEATERNUM;
                    $('#theaterBox').append(option);
                });
            }, "json");
        }

        function load_ongoing_movie() {
            $.get("./?api/movie/ongoing", function(data, status) {
                var table = $('#table');
                console.log(data)
                data.data.forEach(function(object) {
                    var option = document.createElement('option');
                    var option = document.createElement('option');
                    option.value = object.ID;
                    option.dataset.duration = object.DURATION;
                    option.innerText = object.TITLE;
                    $('#movieBox').append(option);
                });
            }, "json");
        }
        load_ongoing_movie();

        $('#cinemaBox').change(function() {
            load_theater($('#cinemaBox').val());
        })
        let jsonArrayObj = [{}];
        $('#theaterBox').change(function() {
            let theater_id = $('#theaterBox').val();
            $.get("./?api/schedule/getByTheater&theater_id=" + theater_id, function(data, status) {
                jsonArrayObj = data.data;
                $.fn.dataTable();
                console.log(jsonArrayObj);
            }, "json");
        })


        function deleteRow() {
            var table = document.querySelector("myTable");
            var rowCount = table.rows.length;
            for (let index = rowCount; index > 1; index--) {
                if (rowCount > 1) {
                    table.deleteRow(index - 1);
                }
            }
        }


        function load_data() {
            let theater_id = $('#theaterBox').val();
            $.get("./?api/schedule/getByTheater&theater_id=" + theater_id, function(data, status) {
                jsonArrayObj = data.data;
                $.fn.dataTable();
                console.log(jsonArrayObj);
            }, "json");
        }
        load_data();
        var pageNumber = 1;
        var entriesPerPage = 10;
        var totalPage = Math.ceil(jsonArrayObj.length / entriesPerPage);


        // Data from json
        $.fn.dataTable = function() {
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
                        <td class="align-middle text-center" name="data_firstname"> ${jsonArrayObj[i].DURATION}</td>
                        <td class="align-middle text-center" name="data_phone"> ${jsonArrayObj[i].STARTTIME}</td>
                        <td class="align-middle text-center" name="data_address"> ${jsonArrayObj[i].ENDTIME}</td>
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

        $.fn.nextPage = function() {
            if (pageNumber != totalPage) {
                pageNumber++;
                $.fn.dataTable();
            }
        }

        // Previous page
        $.fn.prevPage = function() {
            if (pageNumber > 1) {
                pageNumber--;
                $.fn.dataTable();
            }
        }

        // Index page
        $.fn.indexPage = function(index) {
            pageNumber = parseInt(index)
            $.fn.dataTable();
        }

        // Data size change
        $("#data_size").change(function() {
            var tab_size = $(this).val();
            pageNumber = 1;
            entriesPerPage = parseInt(tab_size);
            totalPage = Math.ceil(jsonArrayObj.length / entriesPerPage);
            $.fn.paginationButtons();
            $.fn.dataTable();
        });

        $.fn.dataTable();

        $("#addStaff").click(function() {

            let MOV_ID = $('#movieBox').val();
            let STARTTIME = $('#startTimne').val();
            console.log(STARTTIME);
            let THEA_ID = $('#theaterBox').val();
            let duration = $('#movieBox option:selected').data('duration');
            const start = new Date(STARTTIME);
            const end = new Date(start.getTime() + (duration + 15) * 60000 + 7 * 60 * 60 * 1000);
            console.log(end);
            const ENDTIME = end.toISOString();
            console.log(ENDTIME);

            let action = $("#action").val();
            if (action == "Add") {
                $.post("./?api/schedule/add", {
                    THEA_ID,
                    MOV_ID,
                    STARTTIME,
                    ENDTIME
                }, function(data, status) {
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
                    }
                }, "json")
            } else {
                let ID = $("#action").val();
                $.post("./?api/schedule/update", {
                    THEA_ID,
                    MOV_ID,
                    STARTTIME,
                    ENDTIME,
                    ID
                }, function(data, status) {
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

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/schedule/delete", {
                id: uid
            }, function(data, status) {
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


        $("#searchBarInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Pagination button
        $.fn.paginationButtons = function() {
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

    });


    // hiện dialog xác nhận khi xóa
    function confirmRemoval(btn) {
        let tds = $(btn).closest('tr').find('td')
        let msg = `Lịch chiếu của phim ${tds[1].innerText} (ID = ${tds[0].innerText})`;
        document.getElementById("student_name").innerHTML = msg;
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
    $(document).ready(function() {});
</script>