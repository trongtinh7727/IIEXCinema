<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTicketModalLabel">Add an Ticket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./?api/ticket/add" method="post">
                <div class="modal-body">
                    <!-- Input -->
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_username">SCH_ID</span>
                        <input id="SCH_ID" type="text" class="form-control" placeholder="Your User Name" aria-label="ID" aria-describedby="input_employee_username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_lastname">BOO_ID</span>
                        <input id="BOO_ID" type="text" class="form-control" placeholder="Jon" aria-label="ID" aria-describedby="input_employee_name">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="input_employee_password">SEAT_ID</span>
                    <input id="SEAT_ID" type="text" class="form-control" placeholder="address" aria-label="ID" aria-describedby="input_employee_password">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="input_employee_password">Price</span>
                    <input id="PRICE" type="text" class="form-control" placeholder="address" aria-label="ID" aria-describedby="input_employee_password">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="addTicket" type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hiden" style="display: none;" name="" id="action" value="Add">