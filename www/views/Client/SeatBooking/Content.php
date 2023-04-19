<div class="container my-5">
    <!-- Step indicator -->
    <div id="bookticket-seat-stepindicator" class="d-flex flex-wrap justify-content-center">
        <a href="/?ticketbooking" id="bookticket-ticket-stepindicator-ticket" class="pointer-first bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Chọn vé
        </a>
        <a href="/?seatbooking" id="bookticket-seat-stepindicator-seat" class="pointer bg-cyan my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Chọn ghế
        </a>
        <div href="/?combobooking" id="bookticket-seat-stepindicator-food" class="pointer bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Thức ăn
        </div>
        <div href="/?comfirmbooking" id="bookticket-seat-stepindicator-confirm" class="pointer-last bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Xác nhận
        </div>
    </div>
    <!-- Main -->
    <div id="bookticket-seat-main">
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
                                <h6 class="d-inline-block mx-2" id="bookticket-ticket-main-info-time-time"> <?php echo date("h:i", strtotime($_SESSION['booking']['schedule'][0]->STARTTIME)) ?>
                                </h6>
                                <h6 class="d-inline-block mx-2" id="bookticket-ticket-main-info-time-date">
                                    <?php echo date("d/m/Y", strtotime($_SESSION['booking']['schedule'][0]->STARTTIME)) ?></h6>
                            </div>
                            <div id="bookticket-ticket-main-info-theater" class="my-3 text-white d-inline">
                                <h4 class="d-inline-block mx-2" style="width: 140px;">Rạp:</h4>
                                <h6 class="d-inline-block mx-2" id="bookticket-ticket-main-info-theater-room"><?php echo $_SESSION['booking']['schedule'][0]->THEATERNUM ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Seat -->
                <!-- Class ghế đang chọn: seat-choosing -->
                <!-- Class ghế đã bán: seat-sold -->
                <div id="bookticket-seat-main-seat" class="my-4 pb-2 text-white">
                    <!-- Seat status -->
                    <div id="bookticket-seat-main-seat-status" class="d-flex flex-wrap justify-content-around">
                        <!-- Choosing -->
                        <div id="bookticket-seat-main-seat-status-choosing" class="d-flex align-items-center my-2">
                            <div class="status-block mx-2" style="background-color: red;"></div>
                            <span class="fw-medium fs-5">Ghế đang chọn</span>
                        </div>
                        <!-- Empty -->
                        <div id="bookticket-seat-main-seat-status-empty" class="d-flex align-items-center my-2">
                            <div class="status-block mx-2" style="background-color: #959595;"></div>
                            <span class="fw-medium fs-5">Ghế trống</span>
                        </div>
                        <!-- Sold -->
                        <div id="bookticket-seat-main-seat-status-sold" class="d-flex align-items-center my-2">
                            <div class="status-block mx-2" style="background-color: #FFBA08;"></div>
                            <span class="fw-medium fs-5">Ghế đã bán</span>
                        </div>
                    </div>
                    <!-- Screen -->
                    <div id="bookticket-seat-main-seat-screen" class="w-75 text-center fs-4 fw-medium my-2 mx-auto">
                        SCREEN
                    </div>
                    <!-- Single -->
                    <div id="bookticket-seat-main-seat-single" class="d-flex justify-content-around my-2">
                        <!-- Letter -->

                        <!-- Seat -->

                    </div>
                    <!-- Couple -->
                    <div id="bookticket-seat-main-seat-couple" class="d-flex justify-content-around my-2">
                        <!-- Letter -->
                        <div class="seatcol">
                            <div class="seat-letter">I</div>
                            <div class="seat-letter">J</div>
                        </div>
                        <!-- Seat col 1 2 -->
                        <div class="seatcol-big d-flex">
                            <div class="seatcol">
                                <div class="seat-item seat-item-couple" id="I1"></div>
                                <div class="seat-item seat-item-couple" id="J1"></div>
                                <div class="seat-letter seat-item-couple">1</div>
                            </div>
                        </div>
                        <!-- Seat col 3 4 5 6 7 8 -->
                        <div class="seatcol-big d-flex">
                            <!-- Seat col 3 4 -->
                            <div class="seatcol">
                                <div class="seat-item seat-item-couple" id="I2"></div>
                                <div class="seat-item seat-item-couple" id="J2"></div>
                                <div class="seat-letter seat-item-couple">2</div>
                            </div>
                            <!-- Seat col 5 6 -->
                            <div class="seatcol">
                                <div class="seat-item seat-item-couple" id="I3"></div>
                                <div class="seat-item seat-item-couple" id="J3"></div>
                                <div class="seat-letter seat-item-couple">3</div>
                            </div>
                            <!-- Seat col 7 8 -->
                            <div class="seatcol">
                                <div class="seat-item seat-item-couple" id="I4"></div>
                                <div class="seat-item seat-item-couple" id="J4"></div>
                                <div class="seat-letter seat-item-couple">4</div>
                            </div>
                        </div>
                        <!-- Seat col 9 10 -->
                        <div class="seatcol-big d-flex">
                            <div class="seatcol">
                                <div class="seat-item seat-item-couple" id="I5"></div>
                                <div class="seat-item seat-item-couple" id="J5"></div>
                                <div class="seat-letter seat-item-couple">5</div>
                            </div>
                        </div>
                        <!-- Letter -->
                        <div class="seatcol">
                            <div class="seat-letter">I</div>
                            <div class="seat-letter">J</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right -->
            <div class="col-12 col-lg-3 my-4 text-white">
                <div id="bookticket-seat-main-cart" class="rounded-4 py-3">
                    <!-- Title -->
                    <h3 class="text-yellow text-center pb-3">Giỏ hàng</h3>
                    <!-- Regular ticket -->
                    <div id="bookticket-seat-main-cart-regular" class="mx-3 d-flex justify-content-between">
                        <h5>Vé thường x<span id="quantity_regular"><?php echo $_SESSION['booking']['quantity_regular'] ?></span></h5>
                        <h5 id="bookticket-seat-main-cart-regular-total"><?php echo $_SESSION['booking']['total_regular'] ?></h5>
                    </div>
                    <!-- Couple ticket -->
                    <div id="bookticket-seat-main-cart-couple" class="mx-3 d-flex justify-content-between">
                        <h5>Vé đôi x<span id="quantity_couple"><?php echo $_SESSION['booking']['quantity_couple'] ?></span></h5>
                        <h5 id="bookticket-seat-main-cart-couple-total"><?php echo $_SESSION['booking']['total_couple'] ?></h5>
                    </div>
                    <!-- Total -->
                    <div id="bookticket-seat-main-cart-total" class="px-3 mt-3 pt-3 d-flex justify-content-between">
                        <h4>Tổng cộng</h4>
                        <h4 id="bookticket-seat-main-cart-total-price"><?php
                                                                        $a = intval(str_replace(',', '', $_SESSION['booking']['total_regular']));
                                                                        $b = intval(str_replace(',', '', $_SESSION['booking']['total_couple']));
                                                                        $result = $a + $b;
                                                                        echo number_format($result);
                                                                        ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nagivation button -->
    <div id="bookticket-nagivation" class="d-flex justify-content-between">
        <button id="bookticket-prev" class="btn btn-lg btn-sm bg-secondary text-white fs-4 fw-semibold hover-bg-green" role="button" style="height: 44px; width: 160px;">Trở lại</button>
        <button id="bookticket-next" class="btn btn-lg btn-sm bg-yellow text-dark fs-4 fw-semibold hover-bg-green" role="button" style="height: 44px; width: 160px;">Tiếp
            theo</button>
    </div>
</div>