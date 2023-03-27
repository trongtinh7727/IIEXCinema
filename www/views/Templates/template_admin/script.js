$(document).ready(function () {
	$("#searchBarInput").on("keyup", function () {
		var value = $(this).val().toLowerCase();
		$("#myTable tr").filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	// Data from json
	var jsonArrayObj = [
		{email: "dummy1@gmail.com", username: "dummyUser1", password: "password1", firstname: "firstname1", lastname: "lastname1", code: "code1", phone: "0123451", address: "address1", salary: "1000"},
		{email: "dummy2@gmail.com", username: "dummyUser2", password: "password2", firstname: "firstname2", lastname: "lastname2", code: "code2", phone: "0123452", address: "address2", salary: "1000"},
		{email: "dummy3@gmail.com", username: "dummyUser3", password: "password3", firstname: "firstname3", lastname: "lastname3", code: "code3", phone: "0123453", address: "address3", salary: "1000"},
		{email: "dummy4@gmail.com", username: "dummyUser4", password: "password4", firstname: "firstname4", lastname: "lastname4", code: "code4", phone: "0123454", address: "address4", salary: "1000"},
		{email: "dummy5@gmail.com", username: "dummyUser5", password: "password5", firstname: "firstname5", lastname: "lastname5", code: "code5", phone: "0123455", address: "address5", salary: "1000"},
		{email: "dummy6@gmail.com", username: "dummyUser6", password: "password6", firstname: "firstname6", lastname: "lastname6", code: "code6", phone: "0123456", address: "address6", salary: "1000"},
		{email: "dummy7@gmail.com", username: "dummyUser7", password: "password7", firstname: "firstname7", lastname: "lastname7", code: "code7", phone: "0123457", address: "address7", salary: "1000"},
		{email: "dummy8@gmail.com", username: "dummyUser8", password: "password8", firstname: "firstname8", lastname: "lastname8", code: "code8", phone: "0123458", address: "address8", salary: "1000"},
		{email: "dummy9@gmail.com", username: "dummyUser9", password: "password9", firstname: "firstname9", lastname: "lastname9", code: "code9", phone: "0123459", address: "address9", salary: "1000"},
		{email: "dummy10@gmail.com", username: "dummyUser10", password: "password10", firstname: "firstname10", lastname: "lastname10", code: "code10", phone: "01234510", address: "address10", salary: "1000"},
		{email: "dummy11@gmail.com", username: "dummyUser11", password: "password11", firstname: "firstname11", lastname: "lastname11", code: "code11", phone: "01234511", address: "address11", salary: "1000"},
		{email: "dummy12@gmail.com", username: "dummyUser12", password: "password12", firstname: "firstname12", lastname: "lastname12", code: "code12", phone: "01234512", address: "address12", salary: "1000"},
		{email: "dummy13@gmail.com", username: "dummyUser13", password: "password13", firstname: "firstname13", lastname: "lastname13", code: "code13", phone: "01234513", address: "address13", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"},
		{email: "dummy14@gmail.com", username: "dummyUser14", password: "password14", firstname: "firstname14", lastname: "lastname14", code: "code14", phone: "01234514", address: "address14", salary: "1000"}
	];

	var pageNumber = 1;
	var entriesPerPage = 10;
	var totalPage = Math.ceil(jsonArrayObj.length / entriesPerPage);

	// Pagination button
	$.fn.paginationButtons = function() {
		var buttons_text = `<li class="page-item"><a class="page-link" onClick="javascript:$.fn.prevPage();" href="#">Previous</a></li>`;
		var active = "";

		for(var i = 1; i <= totalPage; i++) {
			if(i == 1) {
				active = "active";
			}
			else {
				active = "";
			}

			buttons_text = buttons_text + `<li class="page-item"><a id="page_index` + i + `" onClick="javascript:$.fn.indexPage(` + i + `);" class="page-link page_index ` + active + `" href="#">` + i + `</a></li>`;
		}

		buttons_text = buttons_text + `<li><a class="page-link" href="#" onClick="javascript:$.fn.nextPage();">Next</a></li>`;
		$(".pagination-buttons").text("");
		$(".pagination-buttons").append(buttons_text);
	}

	$.fn.paginationButtons();

	// Data from json
	$.fn.dataTable = function() {
		var start_index = (pageNumber - 1) * entriesPerPage;
		var end_index = start_index + (entriesPerPage - 1);
		end_index = (end_index >= jsonArrayObj.length) ? jsonArrayObj.length - 1 : end_index;

		var inner_html = "";
		for(var i = start_index; i <= end_index; i++) {
			inner_html = inner_html + 	`<tr>
											<td class="align-middle" name="data_id">` + (i + 1) + `</td>
											<td class="align-middle" name="data_email">` + jsonArrayObj[i].email + `</td>
											<td class="align-middle" name="data_username">` + jsonArrayObj[i].username + `</td>
											<td class="align-middle" name="data_password">` + jsonArrayObj[i].password + `</td>
											<td class="align-middle" name="data_firstname">` + jsonArrayObj[i].firstname + `</td>
											<td class="align-middle" name="data_lastname">` + jsonArrayObj[i].lastname + `</td>
											<td class="align-middle" name="data_code">` + jsonArrayObj[i].code + `</td>
											<td class="align-middle" name="data_phone">` + jsonArrayObj[i].phone + `</td>
											<td class="align-middle" name="data_address">` + jsonArrayObj[i].address + `</td>
											<td class="align-middle" name="data_salary">` + jsonArrayObj[i].salary + `</td>
											<td class="align-middle" name="data_action">
												<button name="btn_edit_employee" class="btn btn-outline-secondary">Edit</button>
												<button name="btn_delete_employee" class="btn btn-outline-danger">Delete</button>
											</td>
										</tr>`
		}

		$("table tbody tr").remove();
		$("table tbody").append(inner_html);

		$(".page_index").removeClass("active");
		$("#page_index" + pageNumber).addClass("active");

		$(".data_size_details").text(`Showing ` + (start_index + 1) + ` to ` + (end_index + 1) + ` of ` + jsonArrayObj.length + ` entries`);
	}

	// Next page
	$.fn.nextPage = function() {
		if(pageNumber != totalPage) {
			pageNumber++;
			$.fn.dataTable();	
		}
	}

	// Previous page
	$.fn.prevPage = function() {
		if(pageNumber > 1) {
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
	
});