<div id="employee_manager" class="card mx-auto my-4 shadow rounded-4">

    <!-- Title + Button -->
    <div class="card-header bg-white rounded-top-4">
        <span class="fs-4">Lịch sử đặt vé</span>
        <br>
        <span>Kiểm tra lịch sử đặt vé</span>
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
            <table id="dataTable" class="table table-striped dt-responsive nowrap" style="width:100%">

                <!-- Table Header -->
                <thead>
                    <tr>
                        <th>Tên đăng nhập</th>
                        <th>Số điện thoại</th>
                        <th>Họ và tên</th>
                        <th>Tiêu đề phim</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Các ghế</th>
                        <th>Tổng giá vé</th>
                        <th>Combo đồ ăn</th>
                        <th>Giá commbo</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>Tên đăng nhập</th>
                        <th>Số điện thoại</th>
                        <th>Họ và tên</th>
                        <th>Tiêu đề phim</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Các ghế</th>
                        <th>Tổng giá vé</th>
                        <th>Combo đồ ăn</th>
                        <th>Giá commbo</th>
                        <th>Thành tiền</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>