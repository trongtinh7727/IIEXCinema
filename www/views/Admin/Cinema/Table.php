<div id="employee_manager" class="card mx-auto my-4 shadow rounded-4">

    <!-- Title + Button -->
    <div class="card-header bg-white rounded-top-4">
        <span class="fs-4">Quản lý rạp phim</span>
        <br>
        <span>Kiểm tra và quản lý các rạp phim</span>
    </div>
    <div class="container my-4">
        <div class="d-flex flex-wrap justify-content-between">

            <!-- New Employee Button -->
            <button id="btn_add_employee" type="button" name="btn_add_employee" class="btn text-white shadow border-0 btn_custom" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i class="fa-solid fa-plus me-1"></i>Thêm mới!</button>

        </div>
    </div>

    <!-- Main -->
    <div class="container">

        <div class="table-responsive">
            <table id="employeeManagerDataTable" class="table table-striped" style="width:100%">

                <!-- Table Header -->
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Tên rạp</th>
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-center">Địa chỉ</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="myTable" style="font-size: 14px;">

                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Tên rạp</th>
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-center">Địa chỉ</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>