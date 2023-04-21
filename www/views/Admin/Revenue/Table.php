<div id="employee_manager" class="card mx-auto my-4 shadow rounded-4">

    <!-- Title + Button -->
    <div class="card-header bg-white rounded-top-4">
        <span class="fs-4">Quản lý doanh thu</span>
        <br>
        <span>Kiểm tra doanh thu theo tháng</span>
    </div>
    <div class="container my-4">
        <div class="d-flex flex-wrap justify-content-between">
            <input type="month" id="month">
            <Strong>Tổng: </Strong>
            <span id="total_revenue">0</span>
        </div>
    </div>

    <!-- Main -->
    <div class="container">

        <div class="table-responsive">
            <div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>