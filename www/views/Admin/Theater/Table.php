<div id="employee_manager" class="card mx-auto my-4 shadow rounded-4">

    <!-- Title + Button -->
    <div class="card-header bg-white rounded-top-4">
        <span class="fs-4">Quản lý phòng chiếu phim</span>
        <br>
        <span>Kiểm tra và quản lý phòng chiếu. Đối với các phòng chiếu, 1/3 số ghế cuối cùng là loại COUPLE, phần còn lại là Standard</span>
    </div>
    <div class="container my-4">
        <div class="d-flex flex-wrap justify-content-between">

            <!-- New Employee Button -->
            <button id="btn_add_employee" type="button" name="btn_add_employee" class="btn text-white shadow border-0 btn_custom" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i class="fa-solid fa-plus me-1"></i>Thêm mới!</button>

        </div>
    </div>

    <!-- Main -->
    <div class="container">
        <!-- Table -->
        <table id="dataTable" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã phòng chiếu</th>
                    <th>Số lượng các ghế</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Mã phòng chiếu</th>
                    <th>Số lượng các ghế</th>
                    <th>Hành động</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>