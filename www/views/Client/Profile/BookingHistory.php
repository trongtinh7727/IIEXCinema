    <div class="container">
        <div id="bookingHistory-main" class="rounded-4">
            <div id="bookingHistory-main-inner" class="card mx-auto pb-4 pt-2 my-4 bg-dark shadow rounded-4 container text-white">
                <!-- Title + Button -->
                <div id="bookingHistory-main-inner-title" class="card-header rounded-top-4 mb-3">
                    <span class="fs-4 fw-medium">Lịch sử đặt vé</span>
                    <br>
                    <span>Kiểm tra lịch sử đặt vé của bạn </span>
                </div>

                <!-- Main -->
                <div class="container">
                    <table id="bookingHistoryDataTable" class="table table-dark table-borderless table-hover dt-responsive nowrapt">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề phim</th>
                                <th>Ngày đặt vé</th>
                                <th>Thời gian bắt đầu</th>
                                <th>Số ghế</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction) {
                            ?>
                                <tr>
                                    <td><?php echo $transaction['ID'] ?></td>
                                    <td><?php echo $transaction['TITLE'] ?></td>
                                    <td><?php echo $transaction['CREATED_AT'] ?></td>
                                    <td><?php echo $transaction['STARTTIME'] ?></td>
                                    <td><?php echo $transaction['Seats'] ?></td>
                                    <td>
                                        <button type="button" data-id="<?php echo $transaction['ID'] ?>" class="btn text-white border-0" data-bs-toggle="modal" data-bs-target="#historyItemModal">
                                            Chi tiết
                                        </button>
                                       
                                    </td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="historyItemModal" tabindex="-1" aria-labelledby="historyItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-white bg-dark">
                    <!-- Title -->
                    <h3 class="text-center">Title</h3>
                    <!-- Showtime -->
                    <div class="modal-showtime text-yellow text-center">
                        <span>Suất chiếu:</span>
                        <h5>22/2/2022</h5>
                        <p>15:30</p>
                    </div>
                    <!-- Details -->
                    <div class="modal-details mx-5">
                        <!-- Theater -->
                        <div class="modal-details-theater d-flex justify-content-between align-items-center">
                            <span class="mx-3">Phòng chiếu:</span>
                            <p class="mx-3">01</p>
                        </div>
                        <!-- Seat -->
                        <div class="modal-details-seat d-flex justify-content-between align-items-center">
                            <span class="mx-3">Ghế:</span>
                            <p class="mx-3">A01</p>
                        </div>
                        <!-- Combo -->
                        <div class="modal-details-combo d-flex justify-content-between align-items-center">
                            <span class="mx-3">Loại combo:</span>
                            <p class="mx-3">Không ăn gì</p>
                        </div>
                        <!-- Transaction time -->
                        <div class="modal-details-transactiontime d-flex justify-content-between align-items-center">
                            <span class="mx-3">Thời gian thanh toán:</span>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mx-3">22/02/2022</p>
                                <p class="mx-3">17:30:20</p>
                            </div>
                        </div>
                        <!-- Movie price -->
                        <div class="modal-details-movieprice d-flex justify-content-between align-items-center">
                            <span class="mx-3">Tiền vé:</span>
                            <p class="mx-3">1,000</p>
                        </div>
                        <!-- Combo price -->
                        <div class="modal-details-comboprice d-flex justify-content-between align-items-center">
                            <span class="mx-3">Tiền combo:</span>
                            <p class="mx-3">1,000</p>
                        </div>
                        <!-- Total -->
                        <div class="modal-details-total d-flex justify-content-between align-items-center">
                            <span class="mx-3">Tổng:</span>
                            <p class="mx-3">2,000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>