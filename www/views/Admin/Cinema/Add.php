<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCinemaModalLabel">Add an Cinema</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./?api/cinema/add" method="post">
                <div class="modal-body">
                    <!-- Input -->

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_username">Name</span>
                        <input id="NAME" type="text" class="form-control" placeholder="Your User Name" aria-label="ID" aria-describedby="input_employee_username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_lastname">Phone</span>
                        <input id="PHONE" type="text" class="form-control" placeholder="Jon" aria-label="ID" aria-describedby="input_employee_name">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="input_employee_password">Address</span>
                    <input id="ADDRESS" type="text" class="form-control" placeholder="address" aria-label="ID" aria-describedby="input_employee_password">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="add" type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hiden" style="display: none;" name="" id="action" value="Add">