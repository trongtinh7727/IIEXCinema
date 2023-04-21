<div class="container my-5">
    <!-- Step indicator -->
    <div id="bookticket-ticket-stepindicator" class="d-flex flex-wrap justify-content-center">
        <a href="/?ticketbooking" id="bookticket-ticket-stepindicator-ticket" class="pointer-first bg-cyan my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Chọn vé
        </a>
        <div href="/?seatbooking" id="bookticket-seat-stepindicator-seat" class="pointer bg-yellow  my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Chọn ghế
        </div>
        <div href="/?combobooking" id="bookticket-seat-stepindicator-food" class="pointer bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Thức ăn
        </div>
        <div href="/?comfirmbooking" id="bookticket-seat-stepindicator-confirm" class="pointer-last bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Xác nhận 
        </div>
    </div>

    <!-- Main -->
    <div id="bookticket-ticket-main">
        <div class="row mt-5">
            <!-- Left -->
            <div class="col-12 col-lg-9 my-4">
                <!-- Info -->
                <div id="bookticket-ticket-main-info" class="rounded-4">
                    <div class="row">
                        <div class="col-12 col-lg-5 text-center py-5">
                            <img class="align-self-center" src="<?php echo $_SESSION['booking']['schedule'][0]->POSTER ?>" alt="Poster">
                        </div>
                        <div class="col-12 col-lg-7 my-3">
                            <h3 id="bookticket-ticket-main-info-title" class="text-yellow text-center text-uppercase my-3"><?php echo $_SESSION['booking']['schedule'][0]->TITLE ?></h3>
                            <div id="bookticket-ticket-main-info-time" class="my-3 text-white">
                                <h4 class="d-inline-block mx-2" style="min-width: 140px;">Thời gian:</h4>
                                <h5 class="d-inline-block mx-2" id="bookticket-ticket-main-info-time-time"> <?php echo date("h:i", strtotime($_SESSION['booking']['schedule'][0]->STARTTIME)) ?>
                                </h5>
                                <h5 class="d-inline-block mx-2" id="bookticket-ticket-main-info-time-date">
                                    <?php echo date("d/m/Y", strtotime($_SESSION['booking']['schedule'][0]->STARTTIME)) ?></h5>
                            </div>
                            <div id="bookticket-ticket-main-info-theater" class="my-3 text-white">
                                <h4 class="d-inline-block mx-2" style="width: 140px;">Rạp:</h4>
                                <h5 class="d-inline-block mx-2" id="bookticket-ticket-main-info-theater-room"><?php echo $_SESSION['booking']['schedule'][0]->NAME ?>
                                </h5>
                            </div>
                            <div id="bookticket-ticket-main-info-theater" class="my-3 text-white ">
                                <h4 class="d-inline-block mx-2" style="width: 140px;">Địa chỉ:</h4>
                                <h5 class="d-inline-block mx-2" id="bookticket-ticket-main-info-theater-room"><?php echo $_SESSION['booking']['schedule'][0]->ADDRESS ?>
                                </h5>
                            </div>
                            <div id="bookticket-ticket-main-info-theater" class="my-3 text-white ">
                                <h4 class="d-inline-block mx-2" style="width: 140px;">Phòng số:</h4>
                                <h5 class="d-inline-block mx-2" id="bookticket-ticket-main-info-theater-room"><?php echo $_SESSION['booking']['schedule'][0]->SHOWROOMNUM ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Number of ticket -->
                <div id="bookticket-ticket-main-number" class="my-4 text-white">
                    <table class="w-100 text-center">
                        <thead>
                            <tr class="fs-4" style="height: 44px;">
                                <td>Vé</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="bookticket-ticket-main-number-regular" class="fs-5">
                                <td id="bookticket-ticket-main-number-regular-type" class="w-25">Vé thường</td>
                                <td id="bookticket-ticket-main-number-regular-price" class="w-25"><?php echo $_SESSION['booking']['schedule'][0]->price ?></td>
                                <td id="bookticket-ticket-main-number-regular-quantity" class="w-25">
                                    <input id="regular-quantity" type="number" min="0" max="20" step="1" value="0" style="min-width: 80px;min-height: 44px;" class="text-center my-2">
                                </td>
                                <td id="bookticket-ticket-main-number-regular-sum" class="w-25">0</td>
                            </tr>
                            <tr id="bookticket-ticket-main-number-couple" class="fs-5">
                                <td id="bookticket-ticket-main-number-couple-type" class="w-25">Vé đôi</td>
                                <td id="bookticket-ticket-main-number-couple-price" class="w-25"><?php echo ($_SESSION['booking']['schedule'][0]->price + 30000) ?></td>
                                <td id="bookticket-ticket-main-number-couple-quantity" class="w-25">
                                    <input id="couple-quantity" type="number" min="0" max="20" step="1" value="0" style="min-width: 80px;min-height: 44px;" class="text-center my-2">
                                </td>
                                <td id="bookticket-ticket-main-number-couple-sum" class="w-25">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Right -->
            <div class="col-12 col-lg-3 my-4 text-white">
                <div id="bookticket-ticket-main-cart" class="rounded-4 py-3">
                    <!-- Title -->
                    <h3 class="text-yellow text-center pb-3">Giỏ hàng</h3>
                    <!-- Regular ticket -->
                    <div id="bookticket-ticket-main-cart-regular" class="mx-3 d-flex justify-content-between">
                        <h5>Vé thường</h5>
                        <h5 id="bookticket-ticket-main-cart-regular-total">0</h5>
                    </div>
                    <!-- Couple ticket -->
                    <div id="bookticket-ticket-main-cart-couple" class="mx-3 d-flex justify-content-between">
                        <h5>Vé đôi</h5>
                        <h5 id="bookticket-ticket-main-cart-couple-total">0</h5>
                    </div>
                    <!-- Total -->
                    <div id="bookticket-ticket-main-cart-total" class="px-3 mt-3 pt-3 d-flex justify-content-between">
                        <h4>Tổng cộng</h4>
                        <h4 id="bookticket-ticket-main-cart-total-price">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nagivation button -->
    <div id="bookticket-nagivation" class="d-flex justify-content-end">
        <button id="bookticket-next" class="btn btn-lg btn-sm bg-yellow text-dark fs-4 fw-semibold hover-bg-green" role="button" style="height: 44px; width: 160px;">Tiếp
            theo</button>
    </div>
</div>