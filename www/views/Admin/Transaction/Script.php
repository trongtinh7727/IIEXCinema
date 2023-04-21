<script>
    $(document).ready(function() {

        $('#btn_add_employee').hide();
        var table = $('#dataTable').DataTable({
            ajax: "./?api/transaction/getall",
            columns: [{
                    data: "ID"
                }, {
                    data: "USERNAME"
                },
                {
                    data: "PHONE"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return data.FIRSTNAME + ' ' + data.LASTNAME;
                    }
                },
                {
                    data: "TITLE"
                },
                {
                    data: "STARTTIME"
                },
                {
                    data: "CREATED_AT"
                },
                {
                    data: "Seats"
                },
                {
                    data: "TICKET_PRICE"
                },
                {
                    data: "FOOD_PRICE"
                },
                {
                    data: "Total"
                }
            ]
        });
    })
</script>