<script>
    $(document).ready(function() {

        $('#btn_add_employee').hide();
        var table = $('#dataTable').DataTable({
            ajax: "./?api/transaction/getall",
            columns: [{
                    data: "ID"
                }, 
                {
                    data: "CINEMA"
                },
                {
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
                    data: "TICKET_PRICE",
                    render: $.fn.dataTable.render.number(',', '.', 0, '$')
                },
                {
                    data: "FOOD_PRICE",
                    render: $.fn.dataTable.render.number(',', '.', 0, '$')
                },
                {
                    data: "Total",
                    render: $.fn.dataTable.render.number(',', '.', 0, '$')
                }
            ]
        });
    })
</script>