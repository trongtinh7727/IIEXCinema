$(document).ready(function () {
    $('#employeeManagerDataTable').DataTable({
        "ajax": "employees.json",
        "columns": [
            {"data": "id"},
            {"data": "email"},
            {"data": "username"},
            {"data": "name"},
            {"data": "familyname"},
            {"data": "code"},
            {"data": "phone"},
            {"data": "address"},
            {"data": "salary"},
            {"data": "html"}
        ]
    });

});