<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addEmployeeModalLabel">Add an Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./?api/staff/add" method="post">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_username">Username</span>
                        <input id="USERNAME" type="text" class="form-control" placeholder="Your User Name" aria-label="ID" aria-describedby="input_employee_username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_password">Password</span>
                        <input id="PASSWORD" type="text" class="form-control" placeholder="yourPassword" aria-label="ID" aria-describedby="input_employee_password">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_lastname">Name</span>
                        <input id="NAME" type="text" class="form-control" placeholder="Jon" aria-label="ID" aria-describedby="input_employee_name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_phone">Code</span>
                        <input id="CODE" type="text" class="form-control" placeholder="NS001" aria-label="ID" aria-describedby="input_employee_code">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_phone">Phone</span>
                        <input id="PHONE" type="text" class="form-control" placeholder="0123456789" aria-label="ID" aria-describedby="input_employee_phone">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_address">Address</span>
                        <input id="ADDRESS" type="text" class="form-control" placeholder="HCMC, Vietnam" aria-label="ID" aria-describedby="input_employee_address">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="input_employee_salary">Salary</span>
                        <input id="SALARY" type="text" class="form-control" placeholder="5000000" aria-label="ID" aria-describedby="input_employee_salary">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="addStaff" type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hiden" style="display: none;" name="" id="action" value="Add">