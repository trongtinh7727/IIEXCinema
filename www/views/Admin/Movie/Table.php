<div id="employee_manager" class="card mx-auto my-4 shadow rounded-4">

    <!-- Title + Button -->
    <div class="card-header bg-white rounded-top-4">
        <span class="fs-4">Quản lý phim</span>
        <br>
        <span>Kiểm tra và quản lý các bộ phim</span>
    </div>
    <div class="container my-4">
        <div class="d-flex flex-wrap justify-content-between">

            <!-- New Employee Button -->
            <button id="btn_add_employee" type="button" name="btn_add_employee" class="btn text-white shadow border-0 btn_custom" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="fa-solid fa-plus me-1"></i>Thêm mới!</button>

            <!-- Search bar -->
            <input id="searchBarInput" type="text" placeholder="&#xf002; Search..." class="form-control shadow w-25">
        </div>
    </div>

    <!-- Main -->
    <div class="container">

        <!-- Pagination header -->
        <div class="pagination-header mb-4 d-flex">
            <div class="dropdown-container">
                <select name="pagination_header" id="data_size" class="text-center border rounded">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table id="employee_manager" class="table table-hover" style="width:100%">

                <!-- Table Header -->
                <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <!-- <th scope="col" class="text-center">Email</th> -->
                        <th scope="col" class="text-center">Tiêu đề</th>
                        <th scope="col" class="text-center">Tác giả</th>
                        <!-- <th scope="col" class="text-center">Last name</th> -->
                        <th scope="col" class="text-center">Diễn viên</th>
                        <th scope="col" class="text-center">Thể loại</th>
                        <th scope="col" class="text-center">Thời lượng</th>
                        <th scope="col" class="text-center">Ngày khởi chiếu</th>
                        <th scope="col" class="text-center">Ngày Ngày kết thúc</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="myTable" style="font-size: 14px;">

                </tbody>
            </table>

        </div>

        <!-- Pagination -->
        <nav aria-label="pagination" class="d-flex justify-content-between">
            <span class="data_size_details"></span>
            <ul class="pagination pagination-buttons justify-content-end">
            </ul>
        </nav>
    </div>
</div>