<script>
    $(document).ready(function() {

        $('#btn_add_employee').hide();
        var table = $('#dataTable').DataTable({
            ajax: "./?api/transaction/getall",
            columns: [{
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
                    data: "Seats"
                },
                {
                    data: "ticketPrice"
                },
                {
                    data: "Food"
                },
                {
                    data: "PRICE"
                },
                {
                    data: "Total"
                }
            ]
        });
    })
</script>