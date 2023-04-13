<script>
    $('#addEmployeeModal').on('hidden.bs.modal', function() {
        clearForm()
    })

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
        let jsonArrayObj = [{}];

        function load_theater(cinema_id) {
            $.get("./?api/theater/getByCinema&cinema_id=" + cinema_id, function(data, status) {
                console.log(data)
                jsonArrayObj = data.data;
                $.fn.dataTable();
                console.log(jsonArrayObj);
            }, "json");
        }

        $('#cinemaBox').change(function() {
            load_theater($('#cinemaBox').val());
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
            load_theater($('#cinemaBox').val());
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
                        <td class="align-middle text-center" name="data_username"> Phòng số ${jsonArrayObj[i].THEATERNUM}</td>
                        <td class="align-middle text-center" name="data_firstname"> ${jsonArrayObj[i].SEATCOUNT}</td>
                        <td class="align-middle text-center" name="data_action">
                            <button name="btn_delete_employee" class="btn btn-outline-danger"
                                onclick="confirmRemoval(this)"> Delete
                            </button>
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

            let CIN_ID = $('#cinemaBox').val();
            let THEATERNUM = $('#THEATERNUM').val();
            let SEATCOUNT = $('#SEATCOUNT').val();

            $.post("./?api/theater/add", {
                CIN_ID,
                THEATERNUM,
                SEATCOUNT
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
            clearForm()
        });

        $("#delete-button").on('click', function() {
            let uid = $('#delete-button').attr('uid');
            $.post("./?api/theater/delete", {
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
    $('#addEmployeeModal').on('hidden.bs.modal', function() {
        clearForm()
    })

    function clearForm() {
        $('#THEATERNUM').val("")
        $('#SEATCOUNT').val("")
    }
    $(document).ready(function() {});
</script>