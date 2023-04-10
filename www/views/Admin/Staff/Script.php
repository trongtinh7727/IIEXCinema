<script>
    function fillEditForm(btn) {
        $("#addEmployeeModalLabel").val("Update Staff");
        let tds = $(btn).closest('tr').find('td')
        let ID = tds[0].innerHTML;
        $("#action").val(ID);
        $.post("./?api/staff/getbyid", {
            ID
        }, function(data, status) {
            var table = $('#table');
            console.log(data)
            data.data.forEach(function(object) {
                $('#USERNAME').val(object.USERNAME)
                $('.pass').hide();
                $('#FNAME').val(object.FIRSTNAME)
                $('#LNAME').val(object.LASTNAME)
                $('#BIRTHDAY').val(object.BIRTHDAY)
                $('#PHONE').val(object.PHONE)
                $('#ADDRESS').val(object.ADDRESS)
                $('#SALARY').val(object.SALARY)
            });

        }, "json");
    }
    $(document).ready(function() {
        function deleteRow() {
            var table = document.querySelector("myTable");
            var rowCount = table.rows.length;
            for (let index = rowCount; index > 1; index--) {
                if (rowCount > 1) {
                    table.deleteRow(index - 1);
                }
            }
        }
        let jsonArrayObj = [{}];
        function load_studen() {
            fetch('./?api/staff/getall')
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
        var pageNumber = 1;
        var entriesPerPage = 10;
        var totalPage = Math.ceil(jsonArrayObj.length / entriesPerPage);
        load_studen();


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
                        <td class="align-middle text-center" name="data_username"> ${jsonArrayObj[i].USERNAME}</td>
                        <td class="align-middle text-center" name="data_firstname"> ${jsonArrayObj[i].FIRSTNAME + ` `+ jsonArrayObj[i].LASTNAME}</td>
                        <td class="align-middle text-center" name="data_phone"> ${jsonArrayObj[i].PHONE}</td>
                        <td class="align-middle text-center" name="data_address"> ${jsonArrayObj[i].ADDRESS}</td>
                        <td class="align-middle text-center" name="data_salary"> ${jsonArrayObj[i].SALARY}</td>
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

            let PASSWORD = $('#PASSWORD').val().trim()
            let PASS_CONFIRM = $('#PASS-CONFIRM').val().trim()
            if (PASSWORD != PASS_CONFIRM) {
                console.assert("Mật khẩu không trùng khớp !");
                return;
            }

            let USERNAME = $('#USERNAME').val()
            let FIRSTNAME = $('#FNAME').val() 
            let LASTNAME = $('#LNAME').val()
            let SEX = $("#SEX").val() === "M" ? "nam" : "nữ" 
            let BIRTHDAY = $("#BIRTHDAY").val()
            let PHONE = $('#PHONE').val()
            let ADDRESS = $('#ADDRESS').val()
            let SALARY = $('#SALARY').val()
            let ROLE = $("#ROLE").val()
            let action = $("#action").val();
            console.log(action);
            if (action == "Add") {
                $.post("./?api/staff/add", {
                    USERNAME,
                    PASSWORD,
                    FIRSTNAME,
                    LASTNAME,
                    SEX,
                    BIRTHDAY,
                    PHONE,
                    ADDRESS,
                    SALARY,
                    ROLE
                }, function(data, status) {
                    console.log(data)
                    if (data.status) {
                        console.log("Okee")
                        load_studen();
                        $.fn.dataTable();
                        $("#msg-success").css('display', 'flex').text("Add staff success")
                        $("#msg-failed").css('display', 'none')
                    } else {
                        console.log("Nooo")
                        $("#msg-failed").css('display', 'flex').text("An unknown error occured. Please try again later")
                        $("#msg-success").css('display', 'none')
                    }
                }, "json")
            } else {
                let ID = $("#action").val();
                $.post("./?api/staff/update", {
                    USERNAME,
                    PASSWORD,
                    FIRSTNAME,
                    LASTNAME,
                    SEX,
                    BIRTHDAY,
                    PHONE,
                    ADDRESS,
                    SALARY,
                    ROLE,
                    ID
                }, function(data, status) {
                    console.log(data)
                    if (data.status) {
                        console.log("Okee")
                        load_studen();
                        $.fn.dataTable();
                        $("#msg-success").css('display', 'flex').text("Update staff success")
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
            $.post("./?api/staff/delete", {
                id: uid
            }, function(data, status) {
                console.log(data)
                if (data.status) {
                    load_studen();
                    $.fn.dataTable();
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
    $(document).ready(function() {
    });
</script>