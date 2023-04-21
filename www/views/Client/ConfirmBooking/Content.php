<div class="container my-5">
    <!-- Step indicator -->
    <div id="bookticket-seat-stepindicator" class="d-flex flex-wrap justify-content-center">
        <a href="/?ticketbooking" id="bookticket-ticket-stepindicator-ticket" class="pointer-first bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Chọn vé
        </a>
        <a href="/?seatbooking" id="bookticket-seat-stepindicator-seat" class="pointer bg-yellow  my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Chọn ghế
        </a>
        <a href="/?combobooking" id="bookticket-seat-stepindicator-food" class="pointer bg-cyan my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Thức ăn
        </a>
        <a href="/?comfirmbooking" id="bookticket-seat-stepindicator-confirm" class="pointer-last bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Xác nhận
        </a>
    </div>
    <!-- Main -->
    <div id="bookticket-confirm-main" class="rounded-4 text-white my-5 px-4 py-3">
        <h3 class="text-yellow text-center fw-semibold">Giỏ hàng của bạn</h3>

        <!-- Movie info -->
        <div id="bookticket-confirm-main-movieinfo" class="fs-5 d-flex">
            <!-- Title -->
            <div id="bookticket-confirm-main-movieinfo-title">
                <div id="bookticket-confirm-main-movieinfo-title-title" class="my-3 me-4 text-end">Tên phim:
                </div>
                <div id="bookticket-confirm-main-movieinfo-title-date" class="my-3 me-4 text-end">Ngày chiếu:
                </div>
                <div id="bookticket-confirm-main-movieinfo-title-showtime" class="my-3 me-4 text-end">Suất
                    chiếu:</div>
                <div id="bookticket-confirm-main-movieinfo-title-room" class="my-3 me-4 text-end">Rạp:</div>
                <div id="bookticket-confirm-main-movieinfo-title-room" class="my-3 me-4 text-end">Địa chỉ:</div>
                <div id="bookticket-confirm-main-movieinfo-title-room" class="my-3 me-4 text-end">Phòng số:</div>
                <div id="bookticket-confirm-main-movieinfo-title-seat" class="my-3 me-4 text-end">Ghế:</div>
            </div>
            <!-- DATAFILL VALUE -->
            <div id="bookticket-confirm-main-movieinfo-value">
                <div id="bookticket-confirm-main-movieinfo-value-title" class="my-3"><?php print_r($_SESSION['booking']['schedule'][0]->TITLE)  ?>
                </div>
                <div id="bookticket-confirm-main-movieinfo-value-date" class="my-3"><?php echo date("d/m/Y", strtotime($_SESSION['booking']['schedule'][0]->STARTTIME)) ?></div>
                <div id="bookticket-confirm-main-movieinfo-value-showtime" class="my-3"><?php echo date("h:i", strtotime($_SESSION['booking']['schedule'][0]->STARTTIME)) ?></div>
                <div id="bookticket-confirm-main-movieinfo-value-room" class="my-3">Rạp <?php echo ($_SESSION['booking']['schedule'][0]->NAME)  ?></div>
                <div id="bookticket-confirm-main-movieinfo-value-room" class="my-3"><?php echo ($_SESSION['booking']['schedule'][0]->ADDRESS)  ?></div>
                <div id="bookticket-confirm-main-movieinfo-value-room" class="my-3"><?php echo ($_SESSION['booking']['schedule'][0]->SHOWROOMNUM)  ?></div>
                <div id="bookticket-confirm-main-movieinfo-value-seat" class="my-3">
                    <?php
                    $string = implode(",", $_SESSION['booking']['seats']);
                    echo $string;
                    ?>
                </div>
            </div>
        </div>
        <!-- Cart info -->
        <div id="bookticket-confirm-main-cartinfo">
            <table class="w-100 text-center">
                <thead class="text-yellow fs-4">
                    <tr>
                        <td class="px-2">Mục</td>
                        <td class="px-2">Giá</td>
                        <td class="px-2">Số lượng</td>
                        <td class="px-2">Tổng</td>
                    </tr>
                </thead>
                <!-- DATAFILL -->
                <tbody>
                    <tr>
                        <td class="bookticket-confirm-main-cartinfo-category px-2">Vé thường</td>
                        <td class="bookticket-confirm-main-cartinfo-price px-2"><?php echo number_format((float) $_SESSION['booking']['schedule'][0]->price) ?></td>
                        <td class="bookticket-confirm-main-cartinfo-quantity px-2"><?php echo $_SESSION['booking']['quantity_regular'] ?></td>
                        <td class="bookticket-confirm-main-cartinfo-total px-2"></td>
                    </tr>
                    <tr>
                        <td class="bookticket-confirm-main-cartinfo-category px-2">Vé đôi</td>
                        <td class="bookticket-confirm-main-cartinfo-price px-2"><?php echo number_format((float) $_SESSION['booking']['schedule'][0]->price + 30000) ?></td>
                        <td class="bookticket-confirm-main-cartinfo-quantity px-2"><?php echo $_SESSION['booking']['quantity_couple'] ?></td>
                        <td class="bookticket-confirm-main-cartinfo-total px-2"></td>
                    </tr>
                    <?php foreach ($_SESSION['booking']['foods'] as $food) { ?>
                        <tr>
                            <td class="bookticket-confirm-main-cartinfo-category px-2"><?php echo $food['name'] ?></td>
                            <td class="bookticket-confirm-main-cartinfo-price px-2"><?php
                                                                                    echo $food['price']; ?></td>
                            <td class="bookticket-confirm-main-cartinfo-quantity px-2"><?php echo $food['quantity'];
                                                                                        ?></td>
                            <td class="bookticket-confirm-main-cartinfo-total px-2"></td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
            <div id="bookticket-confirm-main-cartinfo-totalall" class="text-end mt-3 fs-3">
                Tổng cộng:
            </div>
        </div>
    </div>
    <!-- Payments -->
    <div id="bookticket-confirm-payments" class="my-5">
        <h3 class="text-yellow fw-semibold">Phương thức thanh toán</h3>
        <!-- DATAFILL -->
        <!-- Zalo -->
        <div id="bookticket-confirm-payments-zalo" class="fs-5 fw-semibold my-3">
            <input name="paymentsMethod" type="radio" id="zalo" value="zalo" class="form-check-input mx-3">
            <label for="zalo" style="color: #2b66f6;">ZaloPay</label>
        </div>
        <!-- Momo -->
        <div id="bookticket-confirm-payments-momo" class="fs-5 fw-semibold my-3">
            <input name="paymentsMethod" type="radio" id="momo" value="momo" class="form-check-input mx-3">
            <label for="momo" style="color: #a13371;">Momo</label>
        </div>
    </div>

    <!-- Payments modal -->
    <div id="bookticket-confirm-paymodal" class="my-5 text-yellow">
        <!-- Zalo -->
        <div id="bookticket-confirm-paymodal-zalo" class="w-100 d-none">
            <h3>Vui lòng quét mã để thanh toán</h3>
            <h3>Zalo</h3>
            <img class="align-self-center w-25" src="../assets/img/bookticket/confirm/img-QR.png" alt="QR Code">
        </div>
        <!-- Momo -->
        <div id="bookticket-confirm-paymodal-momo" class="w-100 d-none">
            <h3>Vui lòng quét mã để thanh toán</h3>
            <h3>Momo</h3>
            <img class="align-self-center w-25" src="../assets/img/bookticket/confirm/img-QR.png" alt="QR Code">
        </div>
    </div>

    <!-- Warning -->
    <div id="bookticket-confirm-warning" class="my-5">
        <div class="text-white text-end">Quý khách vui lòng kiểm tra thông tin trước khi thanh toán</div>
        <div class="text-danger text-end">Sau khi thanh toán sẽ không được đổi trả</div>
    </div>
    <!-- Nagivation button -->
    <div id="bookticket-nagivation" class="d-flex justify-content-between">
        <button id="bookticket-prev" class="btn btn-lg btn-sm bg-secondary text-white fs-4 fw-semibold hover-bg-green" role="button" style="height: 44px; width: 160px;">Trở lại</button>
        <button id="bookticket-next" class="btn btn-lg btn-sm bg-yellow text-dark fs-4 fw-semibold hover-bg-green" role="button" style="height: 44px; width: 160px;">Tiếp
            theo</button>
    </div>
</div>