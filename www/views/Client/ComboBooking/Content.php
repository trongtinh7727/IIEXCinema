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
        <div href="/?comfirmbooking" id="bookticket-seat-stepindicator-confirm" class="pointer-last bg-yellow my-2 fs-4 fw-semibold d-flex align-items-center justify-content-center">
            Xác nhận
        </div>
    </div>
    <!-- Main -->
    <div id="bookticket-seat-main">
        <div class="row mt-5">
            <!-- Left -->
            <div class="col-12 col-lg-9 my-4 text-white">
                <div id="bookticket-combo-main-combo" class="rounded-4">
                    <div class="row px-4">
                        <!-- DATAFILL Item -->
                        <?php foreach ($foods as $food) { ?>

                            <div class="bookticket-combo-main-combo-item col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3 text-center my-4">
                                <img class="align-self-center my-2" src="<?php echo $food->Image?>" alt="Combo photo">
                                <div id="name<?php echo $food->ID; ?>" class="bookticket-combo-main-combo-item-info fs-5 fw-medium"><?php echo $food->NAME; ?></div>
                                <div id="price<?php echo $food->ID; ?>" class="bookticket-combo-main-combo-item-price fs-5 fw-medium"><?php echo number_format($food->PRICE); ?></div>
                                <div class="bookticket-combo-main-combo-item-quantity fs-5">
                                    <input type="number" id="<?php echo $food->ID; ?>" min="0" max="20" step="1" value="0" style="min-width: 80px;min-height: 44px;" class="text-center my-2 quantity">
                                </div>
                            </div>
                        <?php

                        } ?>
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