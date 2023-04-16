<div id="employee_manager" class="card mx-auto my-4 shadow rounded-4">

    <!-- Title + Button -->
    <div class="card-header bg-white rounded-top-4">
        <span class="fs-4">Quản lý lịch chiếu phim</span>
        <br>
        <span>Kiểm tra và quản lý lịch chiếu của từng rạp, từng phòng chiếu</span>
    </div>
    <div class="container my-4">
        <div class="d-flex flex-wrap justify-content-between">
            <!-- New Employee Button -->
            <button id="btn_add_employee" type="button" name="btn_add_employee" class="btn text-white shadow border-0 btn_custom" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="fa-solid fa-plus me-1"></i>Thêm mới!
            </button>
            <select id="theaterBox" class="form-select w-25" aria-label="Default select example">
                <option value="-1">Chọn phòng chiếu</option>

            </select>

        </div>
    </div>

    <!-- Main -->
    <div class="container">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped dt-responsive nowrap" style="width:100%">

                <!-- Table Header -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề phim</th>
                        <th>Thời lượng</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Trạng thái đặt vé (empty/total) </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề phim</th>
                        <th>Thời lượng</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Trạng thái đặt vé (empty/total) </th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>