$(document).ready(function() {
	var table = $('#employee_manager').DataTable( {
		responsive: true,
		fixedHeader: true
	});
	new $.fn.dataTable.FixedHeader( table );
});